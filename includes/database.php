<?php 
function drop_tables($mysqli){
	$request = "DROP TABLE IF EXISTS annotation;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "DROP TABLE IF EXISTS parameters;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "DROP TABLE IF EXISTS blast;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "DROP TABLE IF EXISTS transcript;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "DROP TABLE IF EXISTS dataset;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "DROP TABLE IF EXISTS region;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "DROP TABLE IF EXISTS service;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
}
function create_tables($mysqli){
	$request = "CREATE TABLE annotation ( annotation_id bigint(11) NOT NULL, service varchar(100) NOT NULL, name text NOT NULL, description text, begin int(11) NOT NULL, end int(11) NOT NULL, region_id int(11) NOT NULL, dataset_id int(11) NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "CREATE TABLE parameters ( parameters_id bigint(11) NOT NULL, start_codons text, stop_codons text, inner_orf tinyint(1) DEFAULT NULL, outside_orf tinyint(1) DEFAULT NULL, compute_reverse tinyint(1) DEFAULT NULL, compute_ncrna tinyint(1) DEFAULT NULL, min_orf_size int(11) DEFAULT NULL, services text, dataset_id int(11) NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "CREATE TABLE blast (blast_id bigint(11) NOT NULL,  name varchar(100) NOT NULL,  description text,  version int(11) DEFAULT NULL,  species text,  sequence_type varchar(100) DEFAULT NULL,  type varchar(100) DEFAULT NULL,  size int(11) DEFAULT NULL,  state varchar(50) DEFAULT NULL, creation_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "CREATE TABLE transcript ( transcript_id bigint(11) NOT NULL, name text NOT NULL, description text NOT NULL, size int(11) NOT NULL, dataset_id int(11) NOT NULL, temp_transcript_id int(11) NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "CREATE TABLE dataset ( dataset_id bigint(11) NOT NULL,  user_id bigint(11) NOT NULL, encoded_id varchar(20) DEFAULT NULL, name varchar(1000) NOT NULL, myseq tinyint(1) DEFAULT 0, description text, nb_transcripts bigint(20) DEFAULT NULL, state varchar(50) DEFAULT NULL, pid int(11) DEFAULT NULL, creation_date timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "CREATE TABLE region ( region_id bigint(11) NOT NULL, begin int(11) NOT NULL, end int(11) NOT NULL, size int(11) NOT NULL, strand varchar(1) NOT NULL, coding varchar(10) NOT NULL, type varchar(10) NOT NULL, transcript_id int(11) NOT NULL, dataset_id int(11) NOT NULL, temp_region_id int(11) NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "CREATE TABLE service ( name varchar(200) NOT NULL, score_name varchar(200) NOT NULL DEFAULT 'score', score float DEFAULT '0.5', score_min float DEFAULT '0', score_max float NOT NULL DEFAULT '1', color varchar(100) NOT NULL ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);

	$request = "ALTER TABLE annotation ADD PRIMARY KEY (annotation_id);";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "ALTER TABLE parameters ADD PRIMARY KEY (parameters_id);";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "ALTER TABLE blast ADD PRIMARY KEY (blast_id), ADD UNIQUE KEY name (name);";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "ALTER TABLE transcript ADD PRIMARY KEY (transcript_id);";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "ALTER TABLE dataset ADD PRIMARY KEY (dataset_id), ADD UNIQUE KEY name (name);";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "ALTER TABLE region ADD PRIMARY KEY (region_id);";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "ALTER TABLE service ADD PRIMARY KEY (name);";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	
	$request = "ALTER TABLE annotation MODIFY annotation_id bigint(11) NOT NULL AUTO_INCREMENT;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "ALTER TABLE parameters MODIFY parameters_id bigint(11) NOT NULL AUTO_INCREMENT;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "ALTER TABLE blast MODIFY blast_id bigint(11) NOT NULL AUTO_INCREMENT;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "ALTER TABLE transcript MODIFY transcript_id bigint(11) NOT NULL AUTO_INCREMENT;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "ALTER TABLE dataset MODIFY dataset_id bigint(11) NOT NULL AUTO_INCREMENT;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$request = "ALTER TABLE region MODIFY region_id bigint(11) NOT NULL AUTO_INCREMENT;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
}
function insert_services($mysqli){
	include("services_info.php");
	foreach ($services_info as $service => $info_service){
		$request = "INSERT INTO service VALUES (";
		$request .= "'$service', ";
		$request .= "'".$info_service['name']."', ";
		$request .= "'".$info_service['score']."', ";
		$request .= "'".$info_service['min']."', ";
		$request .= "'".$info_service['max']."', ";
		$request .= "'".$info_service['color']."') ";
		$results = mysqli_query ( $mysqli, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $mysqli ) );
	}
}

if($_GET['action'] == "create"){
	include ("./connect.php");
	$db_name = $_GET['db_name'];
	$mysqli = connectGlobal();
	
	$request = "SHOW DATABASES LIKE '$db_name'";
	$results = mysqli_query ( $mysqli, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $mysqli ) );
	if(mysqli_num_rows($results) != 0){
		die("database already exist");
	}
	
	$request = "CREATE DATABASE IF NOT EXISTS $db_name DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;";
	$mysqli->query($request) or die ("Failed on database request: ($request) " . $mysqli->error);
	$mysqli->select_db($db_name);
	create_tables($mysqli);
	insert_services($mysqli);
	echo "1";
}

if($_GET['action'] == "reset"){
	include ("./connect.php");
	$db_name = $_GET['db_name'];
	$mysqli = connectGlobal();
	
	$request = "SHOW DATABASES LIKE '$db_name'";
	$results = mysqli_query ( $mysqli, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $mysqli ) );
	if(mysqli_num_rows($results) == 0){
		die("database do not exist");
	}
	
	$mysqli->select_db($db_name);
	drop_tables($mysqli);
	create_tables($mysqli);
	insert_services($mysqli);
	echo "1";
}
?>

