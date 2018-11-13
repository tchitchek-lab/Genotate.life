<script src="/js/display_region.js" xmlns:right></script>
<?php
include ($_SERVER['DOCUMENT_ROOT']."includes/page_bar.php");
if(isset($_POST['call_jq'])){
  include ($_SERVER['DOCUMENT_ROOT']."includes/connect.php");
  include ($_SERVER['DOCUMENT_ROOT']."includes/tooltip_text.php");
}

function filter_request_service($service, $min, $max)
{
	$request = "AND region.region_id IN (SELECT region_id FROM annotation WHERE service = '$service' ";
	$request .= "GROUP BY(region_id) ";
	$request .= "HAVING COUNT(annotation_id) >= $min ";
	$request .= "AND COUNT(annotation_id) <= $max ";
	$request .= " ) ";
	return($request);
}

function filter_request_name($name)
{
	$request = "AND region.region_id IN (SELECT distinct(region_id) FROM annotation WHERE name LIKE '%".rtrim($name)."%' ) ";
	return($request);
}

function filter_request_description($description)
{
	$request = "AND region.region_id IN (SELECT distinct(region_id) FROM annotation WHERE description LIKE '%".rtrim($description)."%' ) ";
	return($request);
}

if (!empty($_POST)) {
	$connexion = connectdatabase();
	
	//CREATE REQUEST
	$current_request = "SELECT ";
	$current_request .= "region_id, ";
	$current_request .= "region.begin AS region_begin, ";
	$current_request .= "region.end AS region_end, ";
	$current_request .= "region.size AS region_size ";
	//$current_request .= "region.strand AS region_strand, ";
	//$current_request .= "region.coding AS region_coding, ";
	//$current_request .= "region.type AS region_type, ";
	//$current_request .= "region.transcript_id AS transcript_id, ";
	//$current_request .= "region.dataset_id AS dataset_id, ";
	//$current_request .= "region.temp_region_id AS temp_region_id, ";
	//$current_request .= "transcript.name AS transcript_name, ";
	//$current_request .= "transcript.description AS transcript_desc, ";
	//$current_request .= "transcript.size AS transcript_size, ";
	//$current_request .= "transcript.temp_transcript_id AS temp_transcript_id, ";
	//$current_request .= "dataset.name AS dataset_name, ";
	//$current_request .= "dataset.myseq AS myseq ";
	$current_request .= "FROM region, transcript, dataset ";
	$current_request .= "WHERE region.transcript_id = transcript.transcript_id ";
	$current_request .= "AND region.dataset_id = dataset.dataset_id ";
	//FILTER
	$filters_request = "";
	if ($_POST['dataset'] != "") {
		$filters_request .= " AND region.dataset_id = '" . $_POST['dataset'] . "' ";
	}
	//if ($_POST['myseq'] == "1") {
	//	$filters_request  .= " AND myseq = '1' ";
	//}else{
	//	$filters_request  .= " AND myseq = '0' ";
	//}
	foreach($_POST['name'] as $name){
		$filters_request .= filter_request_name($name);
	}
	foreach($_POST['service'] as $service){
		$filters_request .= filter_request_service($service,$_POST['min_'.$service],$_POST['max_'.$service]);
	}
	$current_request .= $filters_request;
	//ORDER
	if(!empty($_POST['order'])){
		if ($_POST['order'] == "begin"){
			$current_request .= " ORDER BY region_begin";
		}
		if ($_POST['order'] == "end"){
			$current_request .= " ORDER BY region_end DESC";
		}
		if ($_POST['order'] == "length"){
			$current_request .= " ORDER BY region_size DESC";
		}
	}else {
		$current_request .= " ORDER BY region_size DESC";
	}

	//STAT REQUEST
	$request_nbregions = "SELECT region.region_id FROM region, transcript, dataset WHERE region.transcript_id = transcript.transcript_id AND region.dataset_id = dataset.dataset_id ";
	$request_nbregions .= $filters_request;
	
	$request_nbtranscript = "SELECT transcript.transcript_id FROM region, transcript, dataset WHERE region.transcript_id = transcript.transcript_id AND region.dataset_id = dataset.dataset_id ";
	$request_nbtranscript .= $filters_request;
	
	$request_nbannotations = "SELECT annotation_id FROM annotation, region, transcript, dataset ";
	$request_nbannotations .= "WHERE region.transcript_id = transcript.transcript_id AND region.dataset_id = dataset.dataset_id AND region.region_id = annotation.region_id ";
	$request_nbannotations .= $filters_request;
	
	$results = mysqli_query($connexion, $request_nbtranscript) or die("SQL Error:<br>".$request_nbtranscript."<br>".mysqli_error($connexion));
	$nb_transcripts = mysqli_num_rows($results);
	$nb_transcripts = number_format ( $nb_transcripts, 0, '.', ',' );
	
	$request_nbregion_noncoding = "$request_nbregions AND coding='noncoding'";
	$results = mysqli_query($connexion, $request_nbregion_noncoding) or die("SQL Error:<br>".$request_nbregion_noncoding."<br>".mysqli_error($connexion));
	$nb_regions_noncoding = mysqli_num_rows($results);
	$nb_regions_noncoding = number_format ( $nb_regions_noncoding, 0, '.', ',' );
	$all_region= "";
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
		$all_region .= $row['region_id']."," ;
	}
	$all_region = rtrim($all_region, ",");
	$all_region_noncoding = serialize($all_region);
	
	$request_nbregion_coding = "$request_nbregions AND coding='coding'";
	$results = mysqli_query($connexion, $request_nbregion_coding) or die("SQL Error:<br>".$request_nbregion_coding."<br>".mysqli_error($connexion));
	$nb_regions_coding = mysqli_num_rows($results);
	$nb_regions_coding = number_format ( $nb_regions_coding, 0, '.', ',' );
	$all_region= "";
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
		$all_region .= $row['region_id']."," ;
	}
	$all_region = rtrim($all_region, ",");
	$all_region_coding = serialize($all_region);
	
	$request_nbregion_inner = "$request_nbregions AND type='inner'";
	$results = mysqli_query($connexion, $request_nbregion_inner) or die("SQL Error:<br>".$request_nbregion_inner."<br>".mysqli_error($connexion));
	$nb_regions_inner = mysqli_num_rows($results);
	$nb_regions_inner = number_format ( $nb_regions_inner, 0, '.', ',' );
	$all_region= "";
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
		$all_region .= $row['region_id']."," ;
	}
	$all_region = rtrim($all_region, ",");
	$all_region_inner = serialize($all_region);
	
	$request_nbregion_outside = "$request_nbregions AND type='outside'";
	$results = mysqli_query($connexion, $request_nbregion_outside) or die("SQL Error:<br>".$request_nbregion_outside."<br>".mysqli_error($connexion));
	$nb_regions_outside = mysqli_num_rows($results);
	$nb_regions_outside = number_format ( $nb_regions_outside, 0, '.', ',' );
	$all_region= "";
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
		$all_region .= $row['region_id']."," ;
	}
	$all_region = rtrim($all_region, ",");
	$all_region_outside = serialize($all_region);
	
	$results = mysqli_query($connexion, $request_nbannotations) or die("SQL Error:<br>".$request_nbannotations."<br>".mysqli_error($connexion));
	$nb_annotations = mysqli_num_rows($results);
	$nb_annotations = number_format ( $nb_annotations, 0, '.', ',' );
	
	$results = mysqli_query($connexion, $current_request) or die("SQL Error:<br>".$current_request."<br>".mysqli_error($connexion));
	$nb_regions = mysqli_num_rows($results);
	$nb_regions_formatted = number_format ( $nb_regions, 0, '.', ',' );
	$all_region= "";
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
		$all_region .= $row['region_id']."," ;
	}
	$all_region = rtrim($all_region, ",");
	$all_region = serialize($all_region);
	
	echo "<form name='annotations' id='annotations' action='./includes/download.php?type=annotation' method='post' target=\"_blank\">";
	echo "<input type='hidden' name='all_region' value=$all_region></form>";
	
	echo "<form name='proteins' id='proteins' action='./includes/download.php?type=protein' method='post' target=\"_blank\">";
	echo "<input type='hidden' name='all_region' value=$all_region></form>";
	
	echo "<form name='regions' id='regions' action='./includes/download.php?type=region' method='post' target=\"_blank\">";
	echo "<input type='hidden' name='all_region' value=$all_region></form>";
	
	echo "<form name='regions_noncoding' id='regions_noncoding' action='./includes/download.php?type=region' method='post' target=\"_blank\">";
	echo "<input type='hidden' name='all_region' value=$all_region_noncoding></form>";
	
	echo "<form name='regions_coding' id='regions_coding' action='./includes/download.php?type=region' method='post' target=\"_blank\">";
	echo "<input type='hidden' name='all_region' value=$all_region_coding></form>";
	
	echo "<form name='regions_inner' id='regions_inner' action='./includes/download.php?type=region' method='post' target=\"_blank\">";
	echo "<input type='hidden' name='all_region' value=$all_region_inner></form>";

	echo "<form name='regions_outside' id='regions_outside' action='./includes/download.php?type=region' method='post' target=\"_blank\">";
	echo "<input type='hidden' name='all_region' value=$all_region_outside></form>";
	
	echo "<form name='transcripts' id='transcripts' action='./includes/download.php?type=transcript' method='post' target=\"_blank\">";
	echo "<input type='hidden' name='all_region' value=$all_region></form>";
	
	//Display global results statistics div
	?>
	<br>
	<div class="div-border-title">
		Search summary
		<a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['identified_elements']; ?>">
		<img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
	</div>
	
	<div class="div-border" style='width:100%;'>
	<table style='width:100%;'>
	<thead>
	<tr>
	<td>
	type
	</td>
	<td style='text-align: center;'>
	number of elements
	</td>
	<td style='text-align: center;'>
	download
	</td>
	</tr>
	</thead>
	<tr>
	<td>processed transcripts</td>
	<td style='text-align:right;'><?php echo $nb_transcripts;?></td>
    <?php if($nb_transcripts > 0){?>
	<td style='padding:0'><button type='submit' form='transcripts' class='btn btn-default' style='width:100%;height:30px;'><span style='font-size: 1.5em;' class='glyphicon glyphicon-download' aria-hidden='true'></span></button></td>
	  <?php }else {echo "<td style='padding:0'><button class='btn btn-default' style='width:100%;height:30px;'><span style='font-size: 1.5em;' class='glyphicon glyphicon-download' aria-hidden='true'></span></button></td>";} //END IF?>
    </tr>
	<tr>
	<td>detected ncRNAs</td>
	<td style='text-align:right;'><?php echo $nb_regions_noncoding;?></td>
    <?php if($nb_regions_noncoding > 0){?>
	<td style='padding:0'><button type="submit" form='regions_noncoding' class="btn btn-default" style="width:100%;height:30px;"><span style='font-size: 1.5em;' class='glyphicon glyphicon-download' aria-hidden='true'></span></button></td>
	  <?php }else {echo "<td style='padding:0'><button class='btn btn-default' style='width:100%;height:30px;'><span style='font-size: 1.5em;' class='glyphicon glyphicon-download' aria-hidden='true'></span></button></td>";} //END IF?>
    </tr>
	<tr>
	<td>detected ORFs</td>
	<td style='text-align:right;'><?php echo $nb_regions_coding;?></td>
    <?php if($nb_regions_coding > 0){?>
	<td style='padding:0'><button type="submit" form='regions_coding' class="btn btn-default" style="width:100%;height:30px;"><span style='font-size: 1.5em;' class='glyphicon glyphicon-download' aria-hidden='true'></span></button></td>
	  <?php }else {echo "<td style='padding:0'><button class='btn btn-default' style='width:100%;height:30px;'><span style='font-size: 1.5em;' class='glyphicon glyphicon-download' aria-hidden='true'></span></button></td>";} //END IF?>
    </tr>
	<tr>
	<td>identifed proteins</td>
	<td style='text-align:right;'><?php echo $nb_regions_coding;?></td>
    <?php if($nb_regions_coding > 0){?>
	<td style='padding:0'><button type="submit" form='proteins' class="btn btn-default" style="width:100%;height:30px;"><span style='font-size: 1.5em;' class='glyphicon glyphicon-download' aria-hidden='true'></span></button></td>
	  <?php }else {echo "<td style='padding:0'><button class='btn btn-default' style='width:100%;height:30px;'><span style='font-size: 1.5em;' class='glyphicon glyphicon-download' aria-hidden='true'></span></button></td>";} //END IF?>
    </tr>
	<tr>
	<td>identifed annotations</td>
	<td style='text-align:right;'><?php echo $nb_annotations;?></td>
    <?php if($nb_annotations > 0){?>
	<td style='padding:0'><button type="submit" form='annotations' class="btn btn-default" style="width:100%;height:30px;"><span style='font-size: 1.5em;' class='glyphicon glyphicon-download' aria-hidden='true'></span></button></td>
	  <?php }else {echo "<td style='padding:0'><button class='btn btn-default' style='width:100%;height:30px;'><span style='font-size: 1.5em;' class='glyphicon glyphicon-download' aria-hidden='true'></span></button></td>";} //END IF?>
    </tr>
	</table>
	</div>
	<div style='padding:5px;width:100%;'></div>
	<?php
	$nbresultbypage = 20;
	$windownumberpage = ceil(intval($nb_regions) / $nbresultbypage);
	$activepage = $_POST["activepage"];
	$request = $current_request . " LIMIT " . (($activepage - 1) * $nbresultbypage) . " , " . $nbresultbypage;
	$results = mysqli_query($connexion, $request) or die("SQL Error:<br>$request<br>".mysqli_error($connexion));
	
	//DISPLAY RESULTS
	echo "<div id='results_header_div' style='width:100%;margin-bottom:10px;'>";
	page_bar($activepage, $windownumberpage);
	echo "<div style='display:none;line-height:30px;float:right;height:40px;border:1px solid lightgrey;padding:5px;'>";
	echo "<label style='margin-right:5px;'>order by</label>";
	echo "<div class='btn-group' style='float:right;'>";
	if($_POST['order'] == 'length' || empty($_POST['order'])){
		echo "<label class='btn btn-default active' for='length'>";
		echo "<input id='length' value='length' type='radio' name='order' form='search' style='display:none' onchange='order_update()' checked>";
		echo "length</label>";		
	}else{
		echo "<label class='btn btn-default' for='length'>";
		echo "<input id='length' value='length' type='radio' name='order' form='search' style='display:none' onchange='order_update()'>";
		echo "length</label>";
	}
	if($_POST['order'] == 'begin'){
		echo "<label class='btn btn-default active' for='begin'>";
		echo "<input id='begin' value='begin' type='radio' name='order' form='search' style='display:none' onchange='order_update()' checked>";
		echo "begin</label>";
		}else{
			echo "<label class='btn btn-default' for='begin'>";
			echo "<input id='begin' value='begin' type='radio' name='order' form='search' style='display:none' onchange='order_update()'>";
			echo "begin</label>";
		}
	if($_POST['order'] == 'end'){
		echo "<label class='btn btn-default active' for='end'>";
		echo "<input id='end' value='end' type='radio' name='order' form='search' style='display:none' onchange='order_update()' checked>";
		echo "end</label>";
		}else{
			echo "<label class='btn btn-default' for='end'>";
			echo "<input id='end' value='end' type='radio' name='order' form='search' style='display:none' onchange='order_update()'>";
			echo "end</label>";
		}
	echo "</div></div>";
	?>
	</div>
	<?php
	while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
		$region_id = $row['region_id'];
		echo "<div id='viewer_div_$region_id' style='width:100%;'></div>";
		echo "\n<script>";
		echo "\n$(document).ready(function(){";
		echo "\n	setTimeout(function() {";
		echo "\n    var xhr = new XMLHttpRequest();";
		echo "\n    xhr.open ('GET', './includes/display_region.php?region_id=$region_id', true);";
		echo "\n    xhr.onreadystatechange = function() {";
		echo "\n        if(xhr.readyState == 4 && xhr.status == 200) {";
		echo "\n    	    var div = document.getElementById('viewer_div_$region_id');";
		echo "\n    		div.innerHTML = xhr.responseText;";
		echo "\n            $('.checkbox_$region_id').on('change', function() { $('#button_$region_id').click(); });";
		echo "\n            $(document).ready(function(){";
		echo "\n            	setTimeout(function() {";
		echo "\n            		$('#button_$region_id').click();";
		echo "\n            	},10);";
		echo "\n            	$('.button_$region_id').click(function(){";
		echo "\n            		create_svg('$region_id');";
		echo "\n            	});";
		echo "\n            });";
		echo "\n        }";
		echo "\n    }";
		echo "\n    xhr.send(null);";
		echo "\n	},10);";
		echo "\n});";
		echo "\n</script>";
	}
	page_bar($activepage, $windownumberpage);
	?>
	<script>
	function order_update() {
		   $('#submit_search_form').click(); 
	}
	</script>
	<?php
}
?>