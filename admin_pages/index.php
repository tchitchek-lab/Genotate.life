<?php
    error_reporting( E_ALL );
?>

<?php
ini_set ( 'max_execution_time', '0' );
$page = "";

$file_path = dirname(__DIR__) . "/genotateweb.config.php";
if ( !file_exists($file_path) ) {
	echo("Config file genotateweb.config not found. $file_path");
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
$USER_MODE = $paths['USER_MODE'];

//$USER_MODE = "debug";
if ($_GET) {
	$page = $_GET ['page'];
}

include ("../includes/connect.php");
$connexion = connectdatabase ();
include("../includes/tooltip_text.php");

// echo '<pre>'; print_r($paths); echo '</pre>';
?>
<!doctype html>
<html>
	<head>
		<meta name="robots" value="noindex" />
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Expires" content="0">

		<link rel="icon" type="image/x-icon" href="/img/favicon.ico">
		<!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="./img/favicon.ico" /><![endif]-->

		<script src="../js/jquery-2.2.2.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="../js/svg.js"></script>

		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="../css/header.css">
		<link rel="stylesheet" type="text/css" href="../css/button.css">
		<link rel="stylesheet" type="text/css" href="../css/div.css">
		<link rel="stylesheet" type="text/css" href="../css/element.css">
		<link rel="stylesheet" type="text/css" href="../css/input.css">
		<link rel="stylesheet" type="text/css" href="../css/table.css">
		<link rel="stylesheet" type="text/css" href="../css/slider.css">
		<link rel="stylesheet" type="text/css" href="../css/range.css">

		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=11; IE=9; IE=8; IE=7" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge" />

	</head>
	<body id="body">
		<div id="header">
			<div id="header"  style="float: none;display:block;max-width:60em;margin-top: 0px;margin-right: auto;margin-bottom: 0px;margin-left: auto;">
				<a class="header_genotate" href='/'>Genotate</a> 
				<a class="header_link" href="index.php?page=manage_annotations">Manage annotations</a>
				<li class="dropdown"><a href="#" class="header_dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Similarity references<span style='margin-left:7px;' class="caret"></span></a>
					<ul class="dropdown-menu">
						<a class="header_dropdown_link" href="index.php?page=create_reference">Create reference</a>
						<a class="header_dropdown_link" href="index.php?page=manage_references">Manage references</a>
						<a class="header_dropdown_link" href="index.php?page=external_references">External references</a>
					</ul>
				</li> 
				<li class="dropdown"><a href="#" class="header_dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Configuration<span style='margin-left:7px;' class="caret"></span></a>
					<ul class="dropdown-menu">
						<a class="header_dropdown_link" href="index.php?page=platform_configuration">Platform configuration<span class="sr-only"></a>
							<a class="header_dropdown_link" href="index.php?page=database_configuration">Database configuration<span class="sr-only"></a>
								<a class="header_dropdown_link" href="index.php?page=annotation_colors">Annotation colors<span class="sr-only"></a>


								</ul>
								
								
								</li> 
							
							<li class="dropdown"><a href="#" class="header_dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Help<span style='margin-left:7px;' class="caret"></span></a>
								<ul class="dropdown-menu">
									<a class="header_dropdown_link" href="../index.php?page=tutorial">Tutorial<span class="sr-only"></a>
										<a class="header_dropdown_link" href="../index.php?page=about">About<span class="sr-only"></a>
											</ul>
										</li> 
          <a style="vertical-align: middle;float:right;font-size:16px;background-color:black;height:40px;width:40px;padding:10px;" href="../index.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span></a>
									</div>
							</div>

						<div id="content_scroll">
							<script>
								//AUTO RESIZE CONTENT SCROLLABLE DIV
								$(document).ready(function() {   
									var resizeDelay = 200;
									var doResize = true;
									var resizer = function () {
										if (doResize) {
											var heightSlider = $('#header').height();
											$('#content_scroll').css({ height : $(window).height() - heightSlider });
											var widthInner = $('#content').width();
											var margin = ($(window).width() - widthInner)/2;
											doResize = false;
										}
									};
									var resizerInterval = setInterval(resizer, resizeDelay);
									resizer();
									$(window).resize(function() {
										doResize = true;
									});
								});
							</script>
							<div id="content" style='float: none;display:block;max-width:60em;margin-top: 0px;margin-right: auto;margin-bottom: 0px;margin-left: auto;'>
								<div id="content-top-margin" style='width:100%;height:0px;padding:15px;'></div>
								<?php
								if ($page == "") {
									include ("home.php");
								} else {
									include("$page.php");
								}
								?>
								<div id="content-bottom-margin" style='width:100%;padding-top:15px;padding-bottom:15px;'>
									Genotate is supported by the IDMIT infrastructure and funded by the ANR.
									<br><a href="http://www.idmitcenter.fr/">IDMIT</a> is part of the French Alternative Energies and Atomic Energy Commission (CEA) | <a href="http://www.genotate.life/index.php?page=gpl3">Terms of use (GPL license)</a>
								</div>
							</div>
							<script>
								$(function () {
									$('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
								})
							</script>
						</div>
						</body>
				</html>
