<?php
if (isset($_GET ['database']) && $_GET ['database'] != ''){
  $database_id = $_GET ['database'];
  $request = "SELECT * FROM dataset INNER JOIN parameters USING (dataset_id) WHERE dataset_id='$database_id' ORDER BY name";
  $results = mysqli_query ( $connexion, $request ) or die ( "SQL Error 1 :<br>$request<br>" . mysqli_error ( $connexion ) );
  $row = mysqli_fetch_array ( $results, MYSQLI_ASSOC );
}
if (isset($_GET ['encoded_id']) && $_GET ['encoded_id'] != ''){
  $encoded_id = $_GET ['encoded_id'];
  $request = "SELECT * FROM dataset INNER JOIN parameters USING (dataset_id) WHERE encoded_id='$encoded_id' ORDER BY name";
  $results = mysqli_query ( $connexion, $request ) or die ( "SQL Error 2 :<br>$request<br>" . mysqli_error ( $connexion ) );
  $row = mysqli_fetch_array ( $results, MYSQLI_ASSOC );
  $database_id = $row ['dataset_id'];
}
$state = $row ['state'];
if ($state != "complete") {
	?>
<hr>
<div style="width: 100%;">
	<label class="title" href='./'>Your request (<?php echo $row['nb_transcripts'];?> transcripts) is computing, refresh in:</label>
	<meta http-equiv="refresh" content="10" > 
	<label class="btn btn-default active" id="countdown" style="margin:2px;">11</label>
	<script type="text/javascript">
	  var seconds;
	  var temp;
	  function countdown() {
	    seconds = document.getElementById('countdown').innerHTML;
	    seconds = parseInt(seconds, 10);
	    seconds--;
	    temp = document.getElementById('countdown');
	    temp.innerHTML = seconds;
	    timeoutMyOswego = setTimeout(countdown, 1000);
	  } 
	  countdown();
	</script>
	<?php 
	$file_base = dirname(dirname ( __DIR__ )) . "/tmp/" . $database_id . "/temporary/";
	//echo $file_base;
	$folders = scandir ( $file_base );
	array_shift ( $folders );
	array_shift ( $folders );
	$table = array ();
	sort($folders);
	//echo '<pre>'; print_r($folders); echo '</pre>';
	foreach ( $folders as $folder ) {
		$files = scandir ( $file_base.$folder."/" );
		array_shift ( $files );
		array_shift ( $files );
		$service_tmp = "";
		//echo "<br>".$folder;
		//echo '<pre>'; print_r($files); echo '</pre>';
		foreach ( $files as $file ) {
			if (preg_match('/^(\d+\_[A-Z]+)\_.+$/',$file, $matches)) {
				$service = $matches[1];
				if(strpos($file, "complete.txt") !== false){
					$table[$service.$folder] = "computed";
				}else{
					if($table[$service.$folder] != "computed"){
						$table[$service.$folder] = "waiting";
					}
				}
			}
		}
	}
	$counts = array_count_values($table);
	$current = $counts["computed"];
	$max = $current + $counts["waiting"] + 1;
	$progress = ($current / $max) * 100;
	//echo '<pre>'; print_r($table); echo '</pre>';
	echo "<div class='progress' style='margin:0;padding:0;height:30px;width: 100%;margin-bottom:30px;border:1px solid grey'>";
	echo "<div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='padding:5px;width: $progress%;' aria-valuenow='$progress' aria-valuemin='0' aria-valuemax='100'>".number_format ( $progress, 0, '.', ', ' )."%</div>";
	echo "</div>";
	if($progress>0){
		$startTime = strtotime ($row['creation_date']);
		$current = $progress;
		$percentleft = 100-$progress;
		$timeTaken = microtime(true) - $startTime;
		
		$days=floor($timeTaken/(60*60*24));
		$hours=floor($timeTaken/(60*60))-($days*24);
		$minutes=floor($timeTaken/(60))-($days*24*60)-($hours*60);
		$seconds=floor($timeTaken)-($days*24*60*60)-($hours*60*60)-($minutes*60);
		echo "<br>Time taken: {$days}d {$hours}h {$minutes}m {$seconds}s";
		
		$timeLeft = ($timeTaken / $current) * $percentleft;
		$days=floor($timeLeft/(60*60*24));
		$hours=floor($timeLeft/(60*60))-($days*24);
		$minutes=floor($timeLeft/(60))-($days*24*60)-($hours*60);
		$seconds=floor($timeLeft)-($days*24*60*60)-($hours*60*60)-($minutes*60);
		echo "<br>Estimated time left: {$days}d {$hours}h {$minutes}m {$seconds}s";
	}
	?>
</div>
<hr>
<?php 
include(dirname(__DIR__) . "/includes/datasets_info.php");
datasets_info($row, $connexion,$database_id,$USER_MODE);
}else{
	?>
	<label type=title>Annotation results for dataset: <?php echo($row['name'])?></label>
	<br><br>
	<?php
}
?>

<form action="javascript:void(0);" method="post" id="search" name="search">
	<input type='hidden' name='dataset' id='dataset' value='<?php echo $database_id; ?>'>
	<input type='hidden' name='myseq' id='myseq' value='<?php echo $row['myseq']; ?>'>
	<input type='hidden' name='call_jq' id='call_jq' value='call_jq'>
	<input type='hidden' name='activepage' id='activepage' value='1'>
	<input type='hidden' name='zoom_ratio' id='zoom_ratio' value='1000'>
	<button id="submit_search_form" style="display: none;"></button>
</form>

<?php if ($state == "complete"){?>
<?php if ($row['nb_transcripts'] == "1"){?>
<div id="display_regions_div" name="transcript_viewer_div" style='width: 100%;margin-bottom:5px;'>
<script>
document.getElementById('zoom_ratio').value=document.getElementById('content').offsetWidth-4;
$.post("./includes/display_transcript_svg.php",
	$('#search').serialize(),
	function(data,status){
		$("#display_regions_div").html("");
		$('#display_regions_div').append(data);
	}
);
</script>
</div>
<?php } ?>

<div id="search_display_div" name="search_display_div" style='width: 100%'>
<script>
$.post("./includes/search_display.php",
	$('#search').serialize(),
	function(data,status){
		$("#search_display_div").html("");
		$('#search_display_div').append(data);
	}
);

</script>
</div>
<script>
$(document).ready(function(){
	$("#submit_search_form").click(function(){
		$.post("./includes/search_display.php",
			$('#search').serialize(),
			function(data,status){
				$("#search_display_div").html("");
				$('#search_display_div').append(data);
			}
		);
	});
});
</script>
<?php } ?>

<canvas id="canvas" width="0" height="0" style='display: none;'></canvas>

