<?php 
$genotate_dir = dirname(dirname(__DIR__));
$file_path = $genotate_dir . "/web/genotateweb.config.php";
$paths = array();
if ( file_exists($file_path) ) {
	$configfile = fopen($file_path, "r");
	while (!feof($configfile)) {
		$line = fgets($configfile);
		$line=rtrim($line);
		if ($line != ""){
			$splitline = explode(':', $line);
			$paths[$splitline[0]]=$splitline[1];
		}
	}
}
$makeblastdb = $paths['BLAST'];
$blastdbdir = $paths['BLASTDB'];

include ("./connect.php");

echo '<pre>'; print_r($_GET); echo '</pre>';
if($_GET){
	$connexion = connectdatabase();
	$release = $_GET['release'];
	$species = $_GET['species'];
	$type = $_GET['type'];
	$dbname = $_GET['name'];
	$file_path = "/pub/release-$release/fasta/".str_replace(" ","_",$species)."/$type/";
	$app_main_dir = dirname(dirname(__DIR__));
	$tmp_dir = $app_main_dir . "/tmp/";
	
	//INSERT BLAST IN DB
	$db_type = "nucleic";
	if($type == "pep"){
		$db_type = "proteic";
	}
	if($dbname == ""){
		die("Error on db name");
	}
	$request = "INSERT INTO blast (name,description,type,state, version, species, sequence_type) VALUES ('$dbname','','$db_type', 'computing', '$release', '$species', '$type')";
	$results = mysqli_query($connexion, $request) or die("SQL Error:<br>$request<br>".mysqli_error($connexion));
	$request = "SELECT blast_id FROM blast WHERE name='{$dbname}'";
	$results = mysqli_query($connexion, $request) or die("SQL Error:<br>$request<br>".mysqli_error($connexion));
	$row = mysqli_fetch_array($results, MYSQLI_ASSOC);
	$id = $row['blast_id'];
	if($id == ""){
		die("database ID not set: $request");
	}
	
	//GET FTP FILE
	$ftp_server = "ftp.ensembl.org";
	$conn_id = ftp_connect($ftp_server) or die("ftp_connect failed");
	ftp_login($conn_id, "anonymous", "anonymous@") or die("ftp_login failed");
	$files = ftp_nlist($conn_id, $file_path);
	foreach($files as $file){
		if (strpos($file, '.all.fa.gz') !== false) {
			$file_path = $file;
			break;
		}
		if (strpos($file, '.ncrna.fa.gz') !== false) {
			$file_path = $file;
			break;
		}
	}
	echo "ftp get $file_path <br>";
	$target_file_gz = $tmp_dir . basename($file_path);
	ftp_get($conn_id, $target_file_gz, $file_path, FTP_BINARY) or die("ftp_get failed $file_path");
	ftp_close($conn_id);
	
	//EXTRACT GZ
	$buffer_size = 4096;
	$target_file = str_replace('.gz', '', $target_file_gz);
	$file = gzopen($target_file_gz, 'rb');
	$out_file = fopen($target_file, 'wb');
	while (!gzeof($file)) {
		fwrite($out_file, gzread($file, $buffer_size));
	}
	fclose($out_file);
	gzclose($file);
	
	//UPDATE BLAST IN DB
	$size = shell_exec("grep '>' {$target_file} | wc -l");
	$request = "UPDATE blast SET size='$size' WHERE blast_id = '{$id}'";
	$results = mysqli_query($connexion, $request) or die("SQL Error:<br>$request<br>".mysqli_error($connexion));
	
	//CREATE COMMAND AND REQUEST
	$cmd = "$makeblastdb -in $target_file -out {$blastdbdir}/{$id}";
	if($db_type == 'nucleic'){$cmd .= " -dbtype nucl";}else{$cmd .= " -dbtype prot";}
	$cmd .= " ; mv {$target_file} {$blastdbdir}/{$id}.fasta";
	$request = "UPDATE blast SET state='complete' WHERE blast_id = '{$id}'";
	
	//CREATE BLAST DB
	$user = "";
	$pwd = "";
	$database = "";
	$file_path = dirname(dirname(__DIR__)) . "/workspace/config/database.config";
	if ( !file_exists($file_path) ) {
		$file_path = dirname(dirname(dirname(__FILE__))) . "/workspace/config/database.config";
		if ( !file_exists($file_path) ) {
			die('Config file not found.');
		}
	}
	$configfile = fopen($file_path, "r");
	while (!feof($configfile)) {
		$line = fgets($configfile);
		$splitline = explode(':', $line);
		if (strcmp($splitline[0], "database") == 0) {
			$database = $splitline[1];
		} else if (strcmp($splitline[0], "user") == 0) {
			$user = $splitline[1];
		} else if (strcmp($splitline[0], "pwd") == 0) {
			$pwd = $splitline[1];
		}
	}
	
	fclose($configfile);
	
	$user = preg_replace( "/\r|\n/", "", $user );
	$pwd = preg_replace( "/\r|\n/", "", $pwd );
	$database = preg_replace( "/\r|\n/", "", $database );
	$cmd = "$cmd && echo \"$request\" | mysql $database -u $user -p$pwd &";
	
	exec($cmd);
}
?>