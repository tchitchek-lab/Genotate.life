<?php
session_start();

if(isset($_GET["encoded_id"])){
    $_SESSION["encoded_id"] = $_GET["encoded_id"];
}

if(isset($_SESSION["encoded_id"]) && !isset($_GET["encoded_id"])) {
    $encoded_id = $_SESSION["encoded_id"];
    if (!isset($_GET["page"])){
        header('Location: index.php?encoded_id=' . $encoded_id);
    }else {
        header('Location: index.php?page='.$_GET["page"].'&encoded_id=' . $encoded_id);
    }
}

?>

<?php
ini_set('max_execution_time', '0');
?>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/connect_database.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/tooltips.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/config_file.php");

include($_SERVER['DOCUMENT_ROOT'] . "/includes/clean_db.php");

?>

<?php
$connexion = connect_database();

$paths = read_configfile();
?>

<!doctype html>
<html lang="en">
<head>

    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
    <!--[if IE]>
    <link rel="shortcut icon" type="image/x-icon" href="./img/favicon.ico"/><![endif]-->

    <script src="/js/jquery-2.2.2.min.js?v=26544864651"></script>
    <script src="/js/bootstrap.min.js?v=26544864651"></script>
    <script src="/js/create_svg.js?v=647892654836"></script>

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
    <meta http-equiv="X-UA-Compatible" content="IE=11; IE=9; IE=8; IE=7"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>

    <script src="/js/matomo.js"></script>

</head>
<body>

<?php
include($_SERVER['DOCUMENT_ROOT'] . "/includes/menu_user.php");
?>

<div id="content_scroll">
    <script>
        $(document).ready(function () {
            let resizeDelay = 200;
            let doResize = true;
            let resizer = function () {
                if (doResize) {
                    let heightSlider = $('#header').height();
                    $('#content_scroll').css({height: $(window).height() - heightSlider});
                    doResize = false;
                }
            };
            setInterval(resizer, resizeDelay);
            resizer();
            $(window).resize(function () {
                doResize = true;
            });
        });
    </script>


    <div id="content"
         style='float: none;display:block;max-width:60em;margin-top: 0;margin-right: auto;margin-bottom: 0;margin-left: auto;'>
        <div id="content-top-margin" style='width:100%;height:0;padding:15px;'></div>
        <?php

        $PAGES = array();
        $PAGES['home'] = '/pages/home.php';
        $PAGES['annotate_single'] = '/pages/annotate_single.php';
        $PAGES['annotate_multiple'] = '/pages/annotate_multiple.php';
        $PAGES['manage_references'] = '/pages/manage_references.php';
        $PAGES['explore_annotations'] = '/pages/explore_annotations.php';
        $PAGES['explore_annotation_results'] = '/pages/explore_annotation_results.php';
        $PAGES['view_annotations'] = '/pages/view_annotations.php';
        $PAGES['about'] = '/pages/about.php';
        $PAGES['tutorial'] = '/pages/tutorial.php';

        $page = "";
        if (isset($_GET ['page'])) {
            $page = $_GET ['page'];
        }
        if (array_key_exists($page,$PAGES)) {
            include($_SERVER['DOCUMENT_ROOT'] . $PAGES[$page]);
        } else {
            include($_SERVER['DOCUMENT_ROOT'] . "/pages/home.php");
        }
        ?>

        <div id="content-bottom-margin" style='width:100%;padding-top:15px;padding-bottom:15px;'>
            Genotate is supported by the IDMIT infrastructure and funded by the ANR.
            <br><a href="http://www.idmitcenter.fr/">IDMIT</a> is part of the French Alternative Energies and Atomic
            Energy Commission (CEA) | <a href="http://genotate.life/index.php?page=gpl3">Terms of use (GPL license)</a>
        </div>
    </div>
</div>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip({trigger: 'hover'});
    })
</script>

</body>
</html>
