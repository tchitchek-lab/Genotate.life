<?php
function connectdatabase()
{
	$host = "";
	$user = "";
	$pwd = "";
	$database = "";
	$file_path = dirname(dirname(__DIR__)) . "/web/genotateweb.config.php";
	if ( !file_exists($file_path) ) {
		$file_path = dirname(dirname(dirname(__FILE__))) . "/web/genotateweb.config.php";
		if ( !file_exists($file_path) ) {
			echo('Config file not found.');
			return (-1);
		}
	}
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
	$file_path = $paths['DATABASE_CONFIG'];
	if ( !file_exists($file_path) ) {
		echo('Database config file not found.');
		return (-1);
	}
	$configfile = fopen($file_path, "r");
	while (!feof($configfile)) {
		$line = fgets($configfile);
		$splitline = explode(':', $line);
		if (strcmp($splitline[0], "database") == 0) {
			$database = $splitline[1];
		} else if (strcmp($splitline[0], "user") == 0) {
			$user = $splitline[1];
		} else if (strcmp($splitline[0], "host") == 0) {
			$host = $splitline[1];
		} else if (strcmp($splitline[0], "pwd") == 0) {
			$pwd = $splitline[1];
		}
	}

	fclose($configfile);
	$host = preg_replace( "/\r|\n/", "", $host );
	$user = preg_replace( "/\r|\n/", "", $user );
	$pwd = preg_replace( "/\r|\n/", "", $pwd );
	$database = preg_replace( "/\r|\n/", "", $database );
	
	if($host != "localhost" && !preg_match("/s\d+\.\d+\.\d+\.\d+.*/i",$host)){
		echo("connectdatabase failed: invalid host $host");
		return (-1);
	}
	$connexion = new mysqli($host, $user, $pwd);
	if ($connexion->connect_error) {
		echo("connectGlobal failed: " . $connexion->connect_error);
		return (-1);
	}
	$request = "SHOW DATABASES LIKE '$database'";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
	if(mysqli_num_rows($results) == 0){
		echo("database not configured");
		return (-1);
	}
	$connexion->select_db($database);
	return $connexion;
}
function connectGlobal()
{
	$host = "";
	$user = "";
	$pwd = "";
	$database = "";
	$file_path = dirname(dirname(__DIR__)) . "/web/genotateweb.config.php";
	if ( !file_exists($file_path) ) {
		$file_path = dirname(dirname(dirname(__FILE__))) . "/web/genotateweb.config.php";
		if ( !file_exists($file_path) ) {
			echo('Config file not found.');
			return (-1);
		}
	}
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
	$file_path = $paths['DATABASE_CONFIG'];
	if ( !file_exists($file_path) ) {
		echo('Database config file not found.');
		return (-1);
	}
	$configfile = fopen($file_path, "r");
	while (!feof($configfile)) {
		$line = fgets($configfile);
		$splitline = explode(':', $line);
		if (strcmp($splitline[0], "database") == 0) {
			$database = $splitline[1];
		} else if (strcmp($splitline[0], "user") == 0) {
			$user = $splitline[1];
		} else if (strcmp($splitline[0], "host") == 0) {
			$host = $splitline[1];
		} else if (strcmp($splitline[0], "pwd") == 0) {
			$pwd = $splitline[1];
		}
	}

	fclose($configfile);
	$host = preg_replace( "/\r|\n/", "", $host );
	$user = preg_replace( "/\r|\n/", "", $user );
	$pwd = preg_replace( "/\r|\n/", "", $pwd );
	$database = preg_replace( "/\r|\n/", "", $database );
	
	if($host != "localhost" && !preg_match("/\d+\.\d+\.\d+\.\d+.*/i",$host)){
		echo("connectdatabase failed: invalid host $host");
		return (-1);
	}
	
	$connexion = new mysqli($host, $user, $pwd);
	if ($connexion->connect_error) {
		echo("connectGlobal failed: " . $connexion->connect_error);
		return (-1);
	}
	return $connexion;
}
?>