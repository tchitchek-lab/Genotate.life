<?php
//echo '<pre>'; print_r($_POST); echo '</pre>';
echo "<form action='/index.php?page=explore_annotation_results&encoded_id={$_GET['encoded_id']}' method='post' id='search' name='search' style='display:none;'>";echo '<pre>'; print_r($_POST); echo '</pre>';
foreach($_POST as $name => $value){
  echo ("<input type='text' id='$name' name='$name' value ='$value'>");
}
echo "</form>";
include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/search_display.php');
?>

<script>
    document.title = "Genotate.life - Explore annotation results";
</script>
