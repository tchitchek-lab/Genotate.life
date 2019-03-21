<?php
  function values_set(){
    if(! isset($_POST['BEPIPRED'])){return false;}
    if(! isset($_POST['BLAST'])){return false;}
    if(! isset($_POST['BLASTALL'])){return false;}
    if(! isset($_POST['BLASTDB'])){return false;}
    if(! isset($_POST['INTERPROSCAN'])){return false;}
    if(! isset($_POST['JAVA'])){return false;}
    if(! isset($_POST['MHCI'])){return false;}
    if(! isset($_POST['MHCII'])){return false;}
    if(! isset($_POST['NETCGLYC'])){return false;}
    if(! isset($_POST['NETNGLYC'])){return false;}
    if(! isset($_POST['PROP'])){return false;}
    if(! isset($_POST['SIGNALP'])){return false;}
    if(! isset($_POST['TMHMM'])){return false;}
    if(! isset($_POST['RNAMMER'])){return false;}
    if(! isset($_POST['TRNASCANSE'])){return false;}
    if(! isset($_POST['TRNASCANSE_ENV'])){return false;}
    return true;
  }
  if (values_set()){

    $file_path = $_SERVER['DOCUMENT_ROOT'] . "../binaries/genotate.config";

    $text = "";
    foreach ($_POST as $key => $value) {
        $text .= $key . ":" . $value . "\n";
    }

    file_put_contents($file_path, $text) or die ("failed to write config file $file_path");
  }
