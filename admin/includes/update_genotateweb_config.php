<?php
function values_set(){
  if(! isset($_POST['USER_MODE'])){return false;}
  if(! isset($_POST['PARALLEL_REGIONS'])){return false;}
  if(! isset($_POST['PARALLEL_ANNOTATIONS'])){return false;}
  if(! isset($_POST['PARALLEL_BLAST_PROCESS'])){return false;}
  if(! isset($_POST['BLAST'])){return false;}
  if(! isset($_POST['BLASTDB'])){return false;}
  if(! isset($_POST['DATABASE_CONFIG'])){return false;}
  if(! isset($_POST['DIR_BINARIES'])){return false;}
  if(! isset($_POST['DIR_DATABASE_CONFIG'])){return false;}
  if(! isset($_POST['DIR_SERVICES'])){return false;}
  if(! isset($_POST['DIR_STORAGE'])){return false;}
  if(! isset($_POST['DIR_TMP'])){return false;}
  if(! isset($_POST['DIR_WORKSPACE'])){return false;}
  if(! isset($_POST['GENOTATE'])){return false;}
  if(! isset($_POST['GENOTATE_CONFIG'])){return false;}
  if(! isset($_POST['JAVA)'])){return false;}
  return true;
}
if (values_set()){
  $file_path = $_SERVER['DOCUMENT_ROOT'] . "/genotateweb.config.php";

  $text = "<?php\n";
  foreach ($_POST as $key => $value) {
      $text .= $key . ":" . $value . "\n";
  }
  $text .= "?>";

  file_put_contents($file_path, $text) or die ("failed to write config file $file_path");
}
