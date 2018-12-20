<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/config_file.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/connect_database.php");

function insert_reference($db_name, $description, $type, $species, $release, $connexion)
{
    $request = "INSERT INTO reference (name,description,type, status, species, version) VALUES ('$db_name','$description','$type', 'computing', '$species', '$release')";
    mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
    $id = mysqli_insert_id($connexion);

    return $id;
}

function send_email($db_name, $email)
{
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: Genotate <noreply@genotate.life>' . "\r\n";

    $title = "Genotate.life - your homology reference '" . $db_name . "' is now available";

    $message = "Dear user,<br>\r\n
	<br>\r\n
	Thank you for using the Genotate transcript annotation platform.<br>\r\n
	<br>\r\n
	Your homology reference '$db_name' is now available.<br>\r\n
	<br>\r\n
	Best regards<br>\r\n
	<br>\r\n
	The Genotate Platform";

    mail($email, $title, $message, $headers);
}

function get_reference_size($target_file)
{
    $size = shell_exec("grep '>' '{$target_file}' | wc -l");
    return $size;
}

function update_reference_size($size, $id, $connexion)
{
    $request = "UPDATE reference SET size='$size' WHERE reference_id = '$id'";
    mysqli_query($connexion, $request) or die("SQL Error:<br>$request<br>" . mysqli_error($connexion));
}

function run_makedb($makeblastdb, $target_file, $blastdbdir, $id, $type)
{
    $cmd = "$makeblastdb -in '$target_file' -out '{$blastdbdir}/{$id}'";
    if ($type == 'nucleic') {
        $cmd .= " -dbtype nucl";
    } else {
        $cmd .= " -dbtype prot";
    }

    echo $cmd;
    exec($cmd);
}

function mv_makedb($target_file, $blastdbdir, $id)
{
    $cmd = "mv '{$target_file}' '{$blastdbdir}/{$id}.fasta'";
    exec($cmd);
}

function update_reference_status($id, $connexion)
{
    $request = "UPDATE reference SET status='complete' WHERE reference_id=$id";
    mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
}

$connexion = connect_database();

$tmp_dir = $_SERVER['DOCUMENT_ROOT'] . "../tmp/";
$paths = read_configfile();
$makeblastdb = $paths['BLAST'];
$blastdbdir = $paths['BLASTDB'];
$upload_type = $_POST ['upload_type'];
$ftp = $_POST ['ftp'];
$db_name = $_POST ['db_name'];
$type = $_POST ['type'];
$species = $_POST ['species'];
$release = $_POST ['release'];
$description = $_POST ['description'];
$email = $_POST ['email'];
$id = insert_reference($db_name, $description, $type, $species, $release, $connexion);
if (isset($upload_type) && $upload_type == "file") {
    $target_file = $tmp_dir . str_shuffle(dechex(date("YmdHis"))).".fasta";
    $file = $_FILES ["file"];
    $tmpfilename = $file ["tmp_name"];
    if (file_exists($target_file)) {
        unlink($target_file);
    }
    move_uploaded_file($tmpfilename, $target_file);
} else {
    $target_file_gz = str_replace(" ", "", $tmp_dir . basename($ftp));
    exec("wget $ftp -P $tmp_dir 2>&1");
    if (substr($target_file_gz, -3) == ".gz") {
        exec("gunzip " . $target_file_gz);
        $target_file = str_replace(".gz", "", $target_file_gz);
    } else if (substr($target_file_gz, -4) == ".zip") {
        exec("unzip " . $target_file_gz . " -d " . $tmp_dir);
        $target_file = str_replace(".zip", "", $target_file_gz);
    } else {
        exec("tar -xzvf $target_file_gz -C $tmp_dir");
        $target_file = str_replace(".tgz", "", $target_file_gz);
    }
}
$size = get_reference_size($target_file);
update_reference_size($size, $id, $connexion);
run_makedb($makeblastdb, $target_file, $blastdbdir, $id, $type);
mv_makedb($target_file, $blastdbdir, $id);
update_reference_status($id, $connexion);
if (isset($email) && $email != "") {
    send_email($db_name, $email);
}
