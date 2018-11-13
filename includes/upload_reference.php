<?php
$genotate_dir = dirname ( dirname ( __DIR__ ) );
$file_path = $genotate_dir . "/web/genotateweb.config.php";
$paths = array ();
if (file_exists ( $file_path )) {
	$configfile = fopen ( $file_path, "r" );
	while ( ! feof ( $configfile ) ) {
		$line = fgets ( $configfile );
		$line = rtrim ( $line );
		if ($line != "") {
			$splitline = explode ( ':', $line );
			$paths [$splitline [0]] = $splitline [1];
		}
	}
}
$makeblastdb = $paths ['BLAST'];
$blastdbdir = $paths ['BLASTDB'];

$app_main_dir = dirname ( dirname ( __DIR__ ) );
$tmp_dir = $app_main_dir . "/tmp/";

include ("connect.php");
$connexion = connectdatabase ();

echo '<pre>';
print_r ( $_POST );
echo '</pre>';

if (isset ( $_POST ['upload_type'] )) {
	$upload_type = $_POST ['upload_type'];
}
if (isset ( $_POST ['ftp'] )) {
	$ftp = $_POST ['ftp'];
}
if (isset ( $_GET ['ftp'] )) {
	$ftp = $_GET ['ftp'];
}
if (isset ( $_POST ['db_name'] )) {
	$db_name = $_POST ['db_name'];
}
if (isset ( $_GET ['name'] )) {
	$db_name = $_GET ['name'];
}
if (isset ( $_POST ['description'] )) {
	$description = $_POST ['description'];
}
if (isset ( $_POST ['type'] )) {
	$type = $_POST ['type'];
}
if (isset ( $_GET ['type'] )) {
	$type = $_GET ['type'];
}
if (isset ( $_GET ['seq_type'] )) {
	$seq_type = $_GET ['seq_type'];
}
if (isset ( $_POST ['email'] )) {
	$email = $_POST ['email'];
}

//insert into the database
if ($db_name == "") {
	die ( "<br>Error on db name" );
}
$request = "INSERT INTO blast (name,description,type,state) VALUES ('$db_name','$description','$type', 'computing')";
$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
$id = mysqli_insert_id($connexion);

//load file
if ($upload_type == "file") {
	$target_file = $tmp_dir . basename ( $_FILES ["file"] ["name"] );
	$file = $_FILES ["file"];
	$tmpfilename = $file ["tmp_name"];
	if (file_exists ( $target_file )) {
		unlink ( $target_file );
	}
	move_uploaded_file ( $tmpfilename, $target_file );
} else {
	$target_file_gz = str_replace ( " ", "", $tmp_dir . basename ( $ftp ) );
	exec ( "wget $ftp -P $tmp_dir" );
	//remove gz tgz zip
	if (substr ( $target_file_gz, - 3 ) == ".gz") {
		echo "<br>"."gunzip " . $target_file_gz;
		exec ( "gunzip " . $target_file_gz );
		$target_file = str_replace ( ".gz", "", $target_file_gz );
	} else if (substr ( $target_file_gz, - 4 ) == ".zip") {
		echo "<br>"."unzip " . $target_file_gz;
		exec ( "unzip " . $target_file_gz . " -d " . $tmp_dir );
		$target_file = str_replace ( ".zip", "", $target_file_gz );
	} else {
		echo "<br>"."tar -xzvf $target_file_gz -C $tmp_dir";
		exec ( "tar -xzvf $target_file_gz -C $tmp_dir" );
		$target_file = str_replace ( ".tgz", "", $target_file_gz );
	}
}

//check target file
if (!file_exists ( $target_file )) {
	$target_file .= ".fa";
}
if (!file_exists ( $target_file )) {
	$target_file .= "sta";
}
if (!file_exists ( $target_file )) {
	die ("<br>file upload failed $target_file");
}

//update nb sequence
$size = shell_exec("grep '>' {$target_file} | wc -l");
$request = "UPDATE blast SET size='$size' WHERE blast_id = '$id'";
$results = mysqli_query($connexion, $request) or die("SQL Error:<br>$request<br>".mysqli_error($connexion));

//create request
$cmd = "$makeblastdb -in $target_file -out {$blastdbdir}/{$id}";
if ($type == 'nucleic') {
	$cmd .= " -dbtype nucl";
} else {
	$cmd .= " -dbtype prot";
}
$cmd .= " ; mv {$target_file} {$blastdbdir}/{$id}.fasta";
echo "<br>" . $cmd;
$cmd = "nohup bash -c \" $cmd > /dev/null 2>&1 & echo $!";
exec ( $cmd );
$request = "UPDATE blast SET state='complete' WHERE blast_id=$id";
$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );

//send email
if ($email != "") {
	$message = "Dear user,<br>\r\n
	<br>\r\n
	Thanks for using <a href='http://www.genotate.life'>Genotate</a> transcripts annotation platform.<br>\r\n
	Your BLAST database $db_name is now available online.<br>\r\n
	<br>\r\n
	Best regards<br>\r\n";
	$headers = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: Genotate <noreply@genotate.life>' . "\r\n";
	mail ( $email, "Genotate BLAST - $db_name is available online", $message, $headers );
}
?>