<?php
require_once 'users/init.php';
//require_once $abs_us_root.$us_url_root.'users/includes/header.php';
//require_once $abs_us_root.$us_url_root.'users/includes/navigation.php';
//if(isset($user) && $user->isLoggedIn()){echo "logged in";}else{echo "not logged";}
// echo '<pre>'; print_r($array); echo '</pre>';
ini_set ( 'max_execution_time', '0' );
$page = "";

$file_path = __DIR__ . "/genotateweb.config.php";
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

//CONNECT SQL
include (__DIR__ . "/includes/connect.php");
$connexion = connectdatabase ();

//LOAD TOOLTIP TEXT
include(__DIR__ . "/includes/tooltip_text.php");

// echo '<pre>'; print_r($array); echo '</pre>';
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

    <script src="/js/jquery-2.2.2.min.js?v=26544864651"></script>
    <script src="/js/bootstrap.min.js?v=26544864651"></script>
		<script src="/js/svg.js?v=26544864651"></script>
    
    <!-- Matomo -->
<script type="text/javascript">
  var _paq = _paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="https://tchitchekguru.innocraft.cloud/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', '3']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Matomo Code -->

	<!-- UserSpice CSS --><!--
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href="<=$us_url_root?><=str_replace('../','',$settings->us_css1);?>" rel="stylesheet">
	<link href="<=$us_url_root?><=str_replace('../','',$settings->us_css2);?>" rel="stylesheet">
	<link href="<=$us_url_root?>users/css/datatables.css" rel="stylesheet">
	<link href="<=$us_url_root?><=str_replace('../','',$settings->us_css3);?>" rel="stylesheet">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
 	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap-editable/css/bootstrap-editable.css" integrity="sha256-YsJ7Lkc/YB0+ssBKz0c0GTx0RI+BnXcKH5SpnttERaY=" crossorigin="anonymous" />
	<style>
	.editableform-loading {
	    background: url('https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap-editable/img/loading.gif') center center no-repeat !important;
	}
	.editable-clear-x {
	   background: url('https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap-editable/img/clear.png') center center no-repeat !important;
	}
	</style>
	<?php //require_once $abs_us_root.$us_url_root.'usersc/includes/bootstrap_corrections.php'; ?>
  -->
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css?v=26544864651">
		<link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css?v=26544864651">
		<link rel="stylesheet" type="text/css" href="/css/header.css?v=26544864651">
		<link rel="stylesheet" type="text/css" href="/css/button.css?v=26544864651">
		<link rel="stylesheet" type="text/css" href="/css/div.css?v=26544864651">
		<link rel="stylesheet" type="text/css" href="/css/element.css?v=26544864651">
		<link rel="stylesheet" type="text/css" href="/css/input.css?v=26544864651">
		<link rel="stylesheet" type="text/css" href="/css/table.css?v=26544864651">
		<link rel="stylesheet" type="text/css" href="/css/slider.css?v=26544864651">
		<link rel="stylesheet" type="text/css" href="/css/range.css?v=26544864651">

		<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=11; IE=9; IE=8; IE=7" />
		<meta http-equiv="X-UA-Compatible" content="IE=Edge" />

		<!-- Matomo -->
<script type="text/javascript">
  var _paq = _paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//www.athenastatistics.org/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', '3']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Matomo Code -->

	</head>
 