<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/connect_database.php");

function insert_annotation($encoded_id, $db_name, $description, $connexion)
{
    $request = "INSERT INTO analysis(encoded_id, name, description, status) VALUES (";
    $request .= "'" . $encoded_id . "', ";
    $request .= "'" . $db_name . "', ";
    $request .= "'" . $description . "', ";
    $request .= "'computing') ";

    mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
    $analysis_id = mysqli_insert_id($connexion);
    return $analysis_id;
}

function create_cmd($analysis_id, $connexion)
{
    $listprogcmd = "";
    if (!empty ($_POST ['algorithm'])) {
        foreach ($_POST ['algorithm'] as $id) {
            if (!empty ($_POST ['checkbox_score_' . $id])) {
                $score = $_POST ['score_' . $id];
            } else {
                if ($_POST ['score_' . $id] == "0.05") {
                    $score = 1;
                } else {
                    $score = 0;
                }
            }
            $listprogcmd .= $id . "[$score],";
        }
    }
    $listprogsql = $listprogcmd;
    if (!empty ($_POST ['BLASTN'])) {
        foreach ($_POST ['BLASTN'] as $id) {
            $request = "SELECT name FROM reference WHERE reference_id = '$id'";
            $results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
            $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
            $blast_name = $row ['name'];
            if (!empty ($_POST ['checkbox_identity_' . $id])) {
                $identity = $_POST ['identity_' . $id];
            } else {
                $identity = 0;
            }
            if (!empty ($_POST ['checkbox_query_cover_' . $id])) {
                $query_cover = $_POST ['query_cover_' . $id];
            } else {
                $query_cover = 0;
            }
            if (!empty ($_POST ['checkbox_subject_cover_' . $id])) {
                $subject_cover = $_POST ['subject_cover_' . $id];
            } else {
                $subject_cover = 0;
            }
            $listprogcmd .= "BLASTN[" . $id . ",$identity,$query_cover,$subject_cover],";
            $listprogsql .= "BLASTN[" . $blast_name . ",$identity,$query_cover,$subject_cover],";
        }
    }
    if (!empty ($_POST ['BLASTP'])) {
        foreach ($_POST ['BLASTP'] as $id) {
            $request = "SELECT name FROM reference WHERE reference_id = '$id'";
            $results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
            $row = mysqli_fetch_array($results, MYSQLI_ASSOC);
            $blast_name = $row ['name'];
            if (!empty ($_POST ['checkbox_identity_' . $id])) {
                $identity = $_POST ['identity_' . $id];
            } else {
                $identity = 0;
            }
            if (!empty ($_POST ['checkbox_query_cover_' . $id])) {
                $query_cover = $_POST ['query_cover_' . $id];
            } else {
                $query_cover = 0;
            }
            if (!empty ($_POST ['checkbox_subject_cover_' . $id])) {
                $subject_cover = $_POST ['subject_cover_' . $id];
            } else {
                $subject_cover = 0;
            }
            $listprogcmd .= "BLASTP[" . $id . ",$identity,$query_cover,$subject_cover],";
            $listprogsql .= "BLASTP[" . $blast_name . ",$identity,$query_cover,$subject_cover],";
        }
    }
    $listprogcmd = rtrim($listprogcmd, ", ");
    $listprogsql = rtrim($listprogsql, ", ");

    $request = "INSERT INTO parameter(start_codons, stop_codons, inner_orf, outside_orf, compute_reverse, compute_ncrna, min_orf_size, use_CPAT, CPAT_threshold, services, analysis_id) VALUES (";
    $request .= "'" . $_POST ['start_codon'] . "', ";
    $request .= "'" . $_POST ['stop_codon'] . "', ";
    if (empty ($_POST ['inner_orf'])) {
        $request .= "'0', ";
    } else {
        $request .= "'1', ";
    }
    if (empty ($_POST ['outside_orf'])) {
        $request .= "'0', ";
    } else {
        $request .= "'1', ";
    }
    if (empty ($_POST ['compute_reverse'])) {
        $request .= "'0', ";
    } else {
        $request .= "'1', ";
    }
    if (empty ($_POST ['compute_ncrna'])) {
        $request .= "'0', ";
    } else {
        $request .= "'1', ";
    }
    if (empty ($_POST ['checkbox_orf_min_size'])) {
        $request .= "'0', ";
    } else {
        $request .= "'" . $_POST ['orf_min_size'] . "', ";
    }
    if (empty ($_POST ['checkbox_checkORF'])) {
        $request .= "'0', ";
    } else {
        $request .= "'1', ";
    }
    if (empty ($_POST ['checkORF_threshold'])) {
        $request .= "'0', ";
    } else {
        $request .= "'" . $_POST ['checkORF_threshold'] . "', ";
    }
    $request .= "'" . $listprogsql . "', ";
    $request .= "'" . $analysis_id . "') ";

    mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
    return ($listprogcmd);
}

function upload_file($TARGET_DIR, $analysis_id)
{
    if ($_POST['myseq'] == 0) {
        $target_file = $TARGET_DIR . $analysis_id . ".fasta";
        $file = $_FILES ["file"];
        $tmpfilename = $file ["tmp_name"];
        if (file_exists($target_file)) {
            unlink($target_file);
        }
        move_uploaded_file($tmpfilename, $target_file);
    } else {
        $target_file = $TARGET_DIR . $analysis_id . ".fasta";
        file_put_contents($target_file, $_POST ['sequence']) or die ("$target_file not  writable");
    }
    return $target_file;
}

function get_file_size($target_file)
{
    $size = shell_exec("grep '>' {$target_file} | wc -l");
    return $size;
}

function update_dataset_size($analysis_id, $size, $connexion)
{
    $request = "UPDATE analysis SET nb_transcripts='$size' WHERE analysis_id=$analysis_id";
    mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
}

function create_cmd_options($PARALLEL_REGIONS, $PARALLEL_ANNOTATIONS, $PARALLEL_BLAST_PROCESS)
{
    $options = " -region_by_run $PARALLEL_REGIONS -threads $PARALLEL_ANNOTATIONS -blast_threads $PARALLEL_BLAST_PROCESS ";
    if (!empty ($_POST ['inner_orf'])) {
        $options .= " -inner_orf";
    }
    if (!empty ($_POST ['outside_orf'])) {
        $options .= " -outside_orf";
    }
    if (empty ($_POST ['compute_reverse'])) {
        $options .= " -ignore_reverse";
    }
    if (empty ($_POST ['compute_ncrna'])) {
        $options .= " -ignore_ncrna";
    }
    if (isset($_POST ['kingdom']) && $_POST ['kingdom'] == "prokaryote") {
        $options .= " -kingdom prokaryote ";
    } else {
        $options .= " -kingdom eukaryote ";
    }
    if (!empty ($_POST ['checkbox_orf_min_size'])) {
        $options .= " -orf_min_size " . $_POST ['orf_min_size'];
    } else {
        $options .= " -orf_min_size 0";
    }
    if (!empty ($_POST ['checkbox_checkORF'])) {
        $options .= " -checkORF -checkORF_threshold " . $_POST ['checkORF_threshold'];
    }
    if (!empty ($_POST ['start_codon'])) {
        $start_codon = strtoupper($_POST ['start_codon']);
        $options .= " -start_codon $start_codon";
    }
    if (!empty ($_POST ['stop_codon'])) {
        $stop_codon = strtoupper($_POST ['stop_codon']);
        $options .= " -stop_codon $stop_codon";
    }
    $options .= " -services_messages ";
    return $options;
}

function run_cmd($JAVA_DIR, $GENOTATE_JAR, $target_file, $TARGET_DIR, $analysis_id, $options, $listprogcmd, $genotate_dir, $db_name)
{
    $cmd_genotate = "$JAVA_DIR -jar $GENOTATE_JAR -input $target_file -output $TARGET_DIR" . "$analysis_id $options ";
    if ($listprogcmd != "") {
        $cmd_genotate .= " -services $listprogcmd ";
    }

    $cmd_php_upload = "php $genotate_dir/includes/insert_annotations.php $analysis_id $db_name {$_POST['email']}";
    $cmd = "nohup bash -c \" $cmd_genotate > $genotate_dir/../tmp/$analysis_id.log-jar.txt 2>&1 ; $cmd_php_upload > $genotate_dir/../tmp/$analysis_id.log-php.txt 2>&1 \" > /dev/null 2>&1 & echo $!";

    exec($cmd, $op);
    $pid = $op[0];

    return $pid;
}

function update_dataset_status($pid, $analysis_id, $connexion)
{
    $request = "UPDATE analysis SET pid='$pid' WHERE analysis_id='$analysis_id'";
    mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
}

function send_email($dataset_name, $encoded_id, $email)
{
    $message = "Dear user,<br>\r\n
	<br>\r\n
	Thank you for using the Genotate transcript annotation platform.<br>\r\n
	<br>\r\n
	The analysis of your dataset '" . $dataset_name . "' is currently under process.<br>\r\n
    <br>\r\n
	Please use the following link to access the computing status: <a href='https://genotate.life/index.php?page=view_annotation&encoded_id=$encoded_id'>https://genotate.life/index.php?page=view_annotations&encoded_id=$encoded_id</a>.<br>\r\n
	<br>\r\n
	Best regards,<br>\r\n
	<br>\r\n
	The Genotate Platorm<br>\r\n";

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: Genotate <noreply@genotate.life>' . "\r\n";

    mail($email, "Genotate.life - your analysis '" . $dataset_name . "' is under process", $message, $headers);
}

$connexion = connect_database();

$genotate_dir = $_SERVER['DOCUMENT_ROOT'];

$paths = read_configfile();
$GENOTATE_JAR = $paths['GENOTATE'];
$JAVA_DIR = $paths['JAVA'];
$TARGET_DIR = $paths['DIR_TMP'] . "/";
$PARALLEL_REGIONS = $paths['PARALLEL_REGIONS'];
$PARALLEL_ANNOTATIONS = $paths['PARALLEL_ANNOTATIONS'];
$PARALLEL_BLAST_PROCESS = $paths['PARALLEL_BLAST_PROCESS'];

$description = $_POST ['description'];

$db_name = $_POST ['db_name'];
$db_name = preg_replace('/[^A-Za-z0-9\-]/', '.', $db_name);
if ($db_name == "") {
    $db_name = "dataset_" . date("Y-m-d_H:i:s");
}

$encoded_id = str_shuffle(dechex(date("YmdHis")));

$analysis_id = insert_annotation($encoded_id, $db_name, $description, $connexion);

$target_file = upload_file($TARGET_DIR, $analysis_id);
$size = get_file_size($target_file);
update_dataset_size($analysis_id, $size, $connexion);

$listprogcmd = create_cmd($analysis_id, $connexion);
$options = create_cmd_options($PARALLEL_REGIONS, $PARALLEL_ANNOTATIONS, $PARALLEL_BLAST_PROCESS);
$pid = run_cmd($JAVA_DIR, $GENOTATE_JAR, $target_file, $TARGET_DIR, $analysis_id, $options, $listprogcmd, $genotate_dir, $db_name);

update_dataset_status($pid, $analysis_id, $connexion);

if (isset($_POST['email']) && $_POST['email'] != "") {
    $email = $_POST['email'];
    send_email($db_name, $encoded_id, $email);
}

echo $encoded_id;
