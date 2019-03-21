<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/connect_database.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/algorithms_info.php");

function drop_tables(mysqli $mysqli)
{

    $request = "DROP TABLE IF EXISTS annotation;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "DROP TABLE IF EXISTS parameter;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "DROP TABLE IF EXISTS reference;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "DROP TABLE IF EXISTS transcript;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "DROP TABLE IF EXISTS analysis;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "DROP TABLE IF EXISTS region;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "DROP TABLE IF EXISTS algorithm;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
}

function create_tables(mysqli $mysqli)
{
    $request = "CREATE TABLE annotation ( annotation_id int(11) NOT NULL, algorithm varchar(255) NOT NULL, name varchar(255) NOT NULL, description text, begin int(11) NOT NULL, end int(11) NOT NULL, region_id int(11) NOT NULL, analysis_id int(11) NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "CREATE TABLE parameter ( parameter_id int(11) NOT NULL, start_codons varchar(255), stop_codons varchar(255), inner_orf tinyint(1) DEFAULT NULL, outside_orf tinyint(1) DEFAULT NULL, compute_reverse tinyint(1) DEFAULT NULL, compute_ncrna tinyint(1) DEFAULT NULL, min_orf_size int(11) DEFAULT NULL, use_CPAT tinyint(1) DEFAULT NULL, CPAT_threshold float DEFAULT NULL, services text, analysis_id int(11) NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "CREATE TABLE reference (reference_id int(11) NOT NULL,  name varchar(255) NOT NULL,  description text,  version varchar(255) DEFAULT NULL,  species varchar(255), type varchar(255) DEFAULT NULL,  size int(11) DEFAULT NULL,  status varchar(255) DEFAULT NULL, creation_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "CREATE TABLE transcript ( transcript_id int(11) NOT NULL, name varchar(255) NOT NULL, description text NOT NULL, size int(11) NOT NULL, analysis_id int(11) NOT NULL, relative_transcript_id int(11) NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "CREATE TABLE analysis ( analysis_id int(11) NOT NULL, encoded_id varchar(255) DEFAULT NULL, name varchar(255) NOT NULL, description text, nb_transcripts int(11) DEFAULT NULL, status varchar(255) DEFAULT NULL, pid int(11) DEFAULT NULL, creation_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, is_permanent tinyint(1) DEFAULT NULL) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "CREATE TABLE region ( region_id int(11) NOT NULL, begin int(11) NOT NULL, end int(11) NOT NULL, size int(11) NOT NULL, strand char(1) NOT NULL, coding varchar(255) NOT NULL, type varchar(255) NOT NULL, transcript_id int(11) NOT NULL, analysis_id int(11) NOT NULL, relative_region_id int(11) NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "CREATE TABLE algorithm ( name varchar(255) NOT NULL, score_name varchar(255) NOT NULL DEFAULT 'score', score float DEFAULT '0.5', score_min float DEFAULT '0', score_max float NOT NULL DEFAULT '1', color varchar(255) NOT NULL ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);

    $request = "ALTER TABLE annotation ADD PRIMARY KEY (annotation_id);";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "ALTER TABLE parameter ADD PRIMARY KEY (parameter_id);";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "ALTER TABLE reference ADD PRIMARY KEY (reference_id), ADD UNIQUE KEY name (name);";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "ALTER TABLE transcript ADD PRIMARY KEY (transcript_id);";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "ALTER TABLE analysis ADD PRIMARY KEY (analysis_id)";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "ALTER TABLE region ADD PRIMARY KEY (region_id);";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "ALTER TABLE algorithm ADD PRIMARY KEY (name);";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);

    $request = "ALTER TABLE annotation MODIFY annotation_id int(11) NOT NULL AUTO_INCREMENT;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "ALTER TABLE parameter MODIFY parameter_id int(11) NOT NULL AUTO_INCREMENT;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "ALTER TABLE reference MODIFY reference_id int(11) NOT NULL AUTO_INCREMENT;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "ALTER TABLE transcript MODIFY transcript_id int(11) NOT NULL AUTO_INCREMENT;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "ALTER TABLE analysis MODIFY analysis_id int(11) NOT NULL AUTO_INCREMENT;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $request = "ALTER TABLE region MODIFY region_id int(11) NOT NULL AUTO_INCREMENT;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
}

function insert_algorithms($mysqli)
{
    $algorithms_info = get_algorithms_info();
    foreach ($algorithms_info as $algorithm => $info_algorithm) {
        $request = "INSERT INTO algorithm VALUES (";
        $request .= "'$algorithm', ";
        $request .= "'" . $info_algorithm['name'] . "', ";
        $request .= "'" . $info_algorithm['score'] . "', ";
        $request .= "'" . $info_algorithm['min'] . "', ";
        $request .= "'" . $info_algorithm['max'] . "', ";
        $request .= "'" . $info_algorithm['color'] . "') ";
        $results = mysqli_query($mysqli, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($mysqli));
    }
}

function delete_storage()
{

    $cmd = " rm -rf /var/www/genotate.life/workspace/blastdb/*";
    exec($cmd);

    $cmd = " rm -rf /var/www/genotate.life/workspace/storage/*";
    exec($cmd);
}

function delete_tmp()
{

    $cmd = " rm -rf /var/www/genotate.life/tmp/*";
    exec($cmd);
}

if ($_GET['action'] == "create") {
    $db_name = $_GET['db_name'];
    $mysqli = connect_dbms();
    $request = "SHOW DATABASES LIKE '$db_name'";
    $results = mysqli_query($mysqli, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($mysqli));
    if (mysqli_num_rows($results) != 0) {
        die("database already exist");
    }
    $request = "CREATE DATABASE IF NOT EXISTS $db_name DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;";
    $mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
    $mysqli->select_db($db_name);
    create_tables($mysqli);
    insert_algorithms($mysqli);
}
if ($_GET['action'] == "reset") {
    $db_name = $_GET['db_name'];
    $mysqli = connect_dbms();
    $request = "SHOW DATABASES LIKE '$db_name'";
    $results = mysqli_query($mysqli, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($mysqli));
    if (mysqli_num_rows($results) == 0) {
        die("database do not exist");
    }
    $mysqli->select_db($db_name);
    drop_tables($mysqli);
    delete_storage();
    delete_tmp();
    create_tables($mysqli);
    insert_algorithms($mysqli);
}
