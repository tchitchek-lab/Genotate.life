<script>
	document.title = "Genotate.life - Explore annotation results";
</script>


<script src="/js/search.js?v=64856161" xmlns:right></script>
<label type=title>Annotated transcripts research interface</label>
<p style='text-align: justify;text-justify: inter-word;'>
The research interface allows the filtration of the available annotated transcripts to select specific annotations. The annotations can be filtered either by the service or by the annotation name, with a minimum and a maximum number of annotations. Different type of annotation are available such as the protein family, transcript or protein accession number, the active site, the cleavage site, the transcript or protein accession name.
</p>
<br>
<form action="index.php?page=search_annotations_results" method="post" id="search" name="search">
	<input type='hidden' name='user_id' id='user_id' value='<?php $userid = $user->data()->id; if ($userid > 0){echo $userid;}else{ echo '0';}?>'>
	<div class="div-border-title">
		Annotation result dataset
		<a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['dataset_filter']; ?>">
		<img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
	</div>
	<div id="dataset_div" class='div-border' style="padding:5px;width: 100%;margin-bottom:10px;">
	<?php
  if (isset($_GET ['encoded_id']) && $_GET ['encoded_id'] != ''){
    $encoded_id = $_GET ['encoded_id'];
    $request = "SELECT * FROM dataset INNER JOIN parameters USING (dataset_id) WHERE encoded_id='$encoded_id' ORDER BY name";
    $results = mysqli_query ( $connexion, $request ) or die ( "SQL Error 2 :<br>$request<br>" . mysqli_error ( $connexion ) );
    $row = mysqli_fetch_array ( $results, MYSQLI_ASSOC );
    $_POST ['dataset'] = $row ['dataset_id'];
  }
$rwhere = '';
	echo "<select class='menulist' name='dataset' id='dataset' style=\"width: 100%; height: 30px;padding-top:5px \" onchange=\"dataset_refresh(this.value);\">";
	echo "<option value='' >All datasets</option>";
  if($user->isLoggedIn()){ //anyone is logged in
    $userid = $user->data()->id;
    $rwhere = " AND user_id = $userid ";
    $request = "SELECT name, dataset_id FROM dataset WHERE state !='computing' $rwhere ORDER BY name ";
    $results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
    while ( $row = mysqli_fetch_array ( $results, MYSQLI_ASSOC ) ) {
      echo "<option value='" . $row ['dataset_id'] . "'";
      if ($row ['dataset_id'] == $_POST ['dataset']) {	echo "selected";}
      echo ">private - " . $row ['name'] . "</option>";
    }
  }
    
	$request = "SELECT name, dataset_id FROM dataset WHERE state !='computing' ORDER BY name ";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
	while ( $row = mysqli_fetch_array ( $results, MYSQLI_ASSOC ) ) {
		echo "<option value='" . $row ['dataset_id'] . "'";
		if ($row ['dataset_id'] == $_POST ['dataset']) {	echo "selected";}
		echo ">public  - " . $row ['name'] . "</option>";
	}
  
	echo "</select>";
	?>
	</div>
  <div id="annotations_filters" style="width: 100%;">
	<div class="div-border-title">
		Annotation result filters
		<a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['keyword_filter']; ?>">
		<img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
	</div>
	<div id="filters_div" class='div-border' style="padding:0px;width: 100%;">
	<div style="padding:5px;width: 100%;">
	<div class='div-border' style="margin:0;padding:0;width: 100%;">
	<input form='' type='text' id='annotation_keyword_filter' name='annotation_keyword_filter' onchange="keyword_refresh();" placeholder='type a keyword to filter annotation results' style='margin:0;height:30px;padding:5px;width:100%'>
	</div>
	</div>
<?php
include("./includes/services_info.php");
foreach ($services_info as $service => $info_service){
	//$description = $info_service['description'];
	echo "<div class='div_keywords' id='div_names_$service'>";
	echo "</div>";
}
echo "<script>dataset_refresh($('#dataset').val());</script>";
?>
	</div>
	</div>
	<button name="submit_search_form" id="submit_search_form" style="width: 100%; font-size: 1.3em;margin-top:10px;" class="btn btn-secondary active">Search sequences</button>
	<input type='hidden' name='activepage' id='activepage' value='1'>
</form>
<script>
$(document).ready(function(){
	$("#submit_search_form").click(function(){
		var div = document.getElementById("filters_div");
		$.post("./includes/search_display.php",
			$('#search').serialize(),
			function(data,status){
				$("#search_display_div").html("");
				$('#search_display_div').append(data);
				div.style.display = 'none';
				var button = document.getElementById("toggle_filters_div");
				button.src="/img/plus.svg"
				document.getElementById("content_scroll").scrollTop = 0;
			}
		);
	});
});
</script>

<div id="search_display_div" name="search_display_div" style='width: 100%;margin-top:10px;'></div>
<canvas id="canvas" width="0" height="0" style='display: none;'></canvas>
