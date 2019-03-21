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

function get_file_ftp($tmp_dir, $ftp)
{
    $target_file_gz = $tmp_dir."/".str_shuffle(dechex(date("YmdHis"))).".fasta.gz";
    exec("wget -O $target_file_gz $ftp -P $tmp_dir > {$target_file_gz}.log");
    return $target_file_gz;
}

function get_file_ftp_ensembl($tmp_dir, $ftp)
{

    $parse_url = parse_url($ftp);
    $ftp_server = $parse_url["host"];

    $conn_id = ftp_connect($ftp_server) or die("ftp_connect failed");
    ftp_login($conn_id, "anonymous", "anonymous@") or die("ftp_login failed");

    $files = ftp_nlist($conn_id, $parse_url["path"]);
    $file_path = "";
    foreach ($files as $file) {
        if (strpos($file, '.all.fa.gz') !== false) {
            $file_path = $file;
            break;
        }
        if (strpos($file, '.ncrna.fa.gz') !== false) {
            $file_path = $file;
            break;
        }
    }

    $target_file_gz = $tmp_dir . "/" . str_shuffle(dechex(date("YmdHis"))) . ".fasta.gz";
    ftp_get($conn_id, $target_file_gz, $file_path, FTP_BINARY) or die("ftp_get failed $file_path");
    ftp_close($conn_id);
    return $target_file_gz;
}

function unzip_file($target_file_gz)
{
    exec("gunzip " . $target_file_gz. " >> {$target_file_gz}.log");
    $target_file = str_replace(".gz", "", $target_file_gz);
    return $target_file;
}

function get_reference_size($target_file)
{
    $size = shell_exec("grep '>' {$target_file} | wc -l");
    return $size;
}

function update_reference_size($size, $id, $connexion)
{
    $request = "UPDATE reference SET size='$size' WHERE reference_id = '$id'";
    mysqli_query($connexion, $request) or die("SQL Error:<br>$request<br>" . mysqli_error($connexion));
}

function run_makedb($makeblastdb, $target_file, $blastdbdir, $id, $type)
{
    $cmd = "$makeblastdb -in $target_file -out {$blastdbdir}/{$id} > {$target_file}.log";
    if ($type == 'nucleic') {
        $cmd .= " -dbtype nucl";
    } else {
        $cmd .= " -dbtype prot";
    }

    exec($cmd);
}

function mv_makedb($target_file, $blastdbdir, $id)
{
    $cmd = "mv {$target_file} {$blastdbdir}/{$id}.fasta";
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

$db_name = $_GET ['name'];
$type = $_GET ['type'];
$species = $_GET ['species'];
$release = $_GET ['release'];
$description = $_GET ['description'];
$ftp = $_GET ['ftp'];

$id = insert_reference($db_name, $description, $type, $species, $release, $connexion);

if (substr($ftp, -1) === "/" && strpos($ftp, 'ftp.ensembl.org') !== false) {
    $target_file_gz = get_file_ftp_ensembl($tmp_dir, $ftp);
} else {
    $target_file_gz = get_file_ftp($tmp_dir, $ftp);
}

$target_file = unzip_file($target_file_gz);

$size = get_reference_size($target_file);
update_reference_size($size, $id, $connexion);

run_makedb($makeblastdb, $target_file, $blastdbdir, $id, $type);
mv_makedb($target_file, $blastdbdir, $id);

update_reference_status($id, $connexion);
