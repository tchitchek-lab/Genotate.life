<script>
	document.title = "Genotate.life - Manage annotation results";
</script>


<script src="/js/manage.js?v=618546156" xmlns:right></script>

<label type=title>Manage annotation result datasets</label>
<p style='text-align: justify;text-justify: inter-word;'>
This interface lists the annotation result datasets with their associated information, sequences, and annotations. For each annotation result dataset, the submitted transcript sequences, the detected ORFs sequences, and the identified annotations can be downloaded. Annotation result datasets can be renamed or deleted using this interface. The parameters used of each annotation analysis can also be displayed (such as the ORFs detection parameters, the algorithm used for the prediction of the functional annotations, and the databases used for the prediction of the homology annotations, ...).
</p>

<?php
if($user->isLoggedIn()){
	echo "<div class='div-border-title'>";
	echo "	Private annotation results";
	echo "	<a style='float:right;margin-right:10px;' data-toggle='tooltip' data-placement='top' href='./index.php?page=tutorial' target='_blank' title=";
	echo $tooltip_text['manage_annotations_private'];
	echo ">";
	echo "	<img src='/img/tutorial.svg' style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>";
	echo "</div>";

	echo "<div class='div-border'>";
	echo "<table class='manage_tables' style='width: 100%;' >";
	echo "<thead><tr>";
	echo "<td>dataset name</td>";
	echo "<td style='text-align:center;'>creation date</td>";
	echo "<td style='width:10%;text-align:center;'>number of transcripts</td>";
	echo "<td style='width:155px;text-align:center;'>possible actions</td>";
	echo "<td style='width:10%;text-align:center;'>status</td>";
	echo "</tr></thead>";
	$rwhere = '';
	//if($user->isLoggedIn()){
	  $userid = $user->data()->id;
	  $rwhere = " WHERE user_id = $userid ";
	//} //anyone is logged in
	$request = "SELECT * FROM dataset $rwhere ORDER BY creation_date DESC";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
	while ( $row = mysqli_fetch_array ( $results, MYSQLI_ASSOC ) ) {
		$dataset_id = $row ['dataset_id'];
		$file_base = dirname ( dirname ( __DIR__ ) ) . "/workspace/storage/" . $dataset_id . "/";
		if ($row['state'] != complete){
			$file_base = dirname ( dirname ( __DIR__ ) ) . "/tmp/" . $dataset_id . "/";
		}
		$file_name = "transcripts.fasta";
		$file_path = $file_base . $file_name;
		echo "<form name='transcript_$dataset_id' id='transcript_$dataset_id' action='./includes/download_file.php' method='post' target=\"_blank\">";
		echo "<input type='hidden' name='file_path' value=$file_path></form>";
		$file_name = "regions_nucl.fasta";
		$file_path = $file_base . $file_name;
		echo "<form name='region_$dataset_id' id='region_$dataset_id' action='./includes/download_file.php' method='post' target=\"_blank\">";
		echo "<input type='hidden' name='file_path' value=$file_path></form>";
		$file_name = "regions_prot.fasta";
		$file_path = $file_base . $file_name;
		echo "<form name='protein_$dataset_id' id='protein_$dataset_id' action='./includes/download_file.php' method='post' target=\"_blank\">";
		echo "<input type='hidden' name='file_path' value=$file_path></form>";
		$file_name = "all_annotations.tab";
		$file_path = $file_base . $file_name;
		echo "<form name='annotation_$dataset_id' id='annotation_$dataset_id' action='./includes/download_file.php' method='post' target=\"_blank\">";
		echo "<input type='hidden' name='file_path' value=$file_path></form>";
		echo "<tr>";
		echo "<td>{$row['name']}</td>";
		echo "<td style='text-align:center;'>{$row['creation_date']}</td>";
		$result_nb_transcript = number_format ($row['nb_transcripts'], 0, '.', ',' );
		echo "<td style='text-align:right;'>$result_nb_transcript</td>";
		echo "<td>";

		echo "<a href='./index.php?page=manage_annotations_details&dataset_id=$dataset_id'><button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='";
		echo $tooltip_text['manage_getinfo'];
		echo "' class='btn btn-md btn-primary'>";
		echo "<span class='glyphicon glyphicon-plus' aria-hidden='true'></span></button></a>";
		echo "<a href='./index.php?page=display&database=$dataset_id'><button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='".$tooltip_text['manage_explore']."'  class='btn btn-md btn-primary'>";
		echo "<span class='glyphicon glyphicon-search' aria-hidden='true'></span></button></a>";
		
		echo "<div class='dropdown' style='width: 85px;'>
			<button class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown' style='width:85px;'>
				download<span class='caret' style='margin-left:5px;'></span>
			</button>
			<ul style='background-color:#2f70a9' class='dropdown-menu'>";
		echo "<li><a style='color:white' href=\"javascript:document.getElementById('transcript_$dataset_id').submit();\" data-toggle='tooltip' data-placement='top' title='".$tooltip_text['manage_download_transcripts']."'>transcripts</a></li>";
		echo "<li><a style='color:white' href=\"javascript:document.getElementById('region_$dataset_id').submit();\"  data-toggle='tooltip' data-placement='middle' title='".$tooltip_text['manage_download_regions']."'>regions</a></li>";
		echo "<li><a style='color:white' href=\"javascript:document.getElementById('protein_$dataset_id').submit();\" data-toggle='tooltip' data-placement='bottom' title='".$tooltip_text['manage_download_proteins']."'>proteins</a></li>";
		
		$request_nb_annot = "SELECT count(*) FROM annotation WHERE dataset_id=" . $dataset_id;
		$query_nb_annot = mysqli_query ( $connexion, $request_nb_annot ) or die ( "SQL Error:<br>$request_nb_annot<br>" . mysqli_error ( $connexion ) );
		$result_nb_annot = mysqli_fetch_array ( $query_nb_annot ) or die ( "SQL Error:<br>$request_nb_annot<br>" . mysqli_error ( $connexion ) );
		if ($result_nb_annot [0] > 0) {
			echo "<li><a href=\"javascript:document.getElementById('annotation_$dataset_id').submit();\">annotations</a></li>";
		}
		
		echo "		</ul>";
		echo "</div>";
	echo "</td>";


		echo "<td style='text-align:right;'>";
		if($row['state']== "complete"){
			echo "<div class='progress' style='margin:0;padding:0;height:30px;width: 100%;'>";
			echo "<div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='padding:5px;width: 100%;' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>";
			echo "</div>";
		}else{
			$file_base = dirname(dirname ( __DIR__ )) . "/tmp/" . $dataset_id . "/temporary/";
			$folders = scandir ( $file_base );
			array_shift ( $folders );
			array_shift ( $folders );
			$table = array ();
			sort($folders);
			foreach ( $folders as $folder ) {
				$files = scandir ( $file_base.$folder."/" );
				array_shift ( $files );
				array_shift ( $files );
				$service_tmp = "";
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
			echo "<div class='progress' style='margin:0;padding:0;height:30px;width: 100%;'>";
			echo "<div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='padding:5px;width: $progress%;' aria-valuenow='$progress' aria-valuemin='0' aria-valuemax='100'>".number_format ( $progress, 0, '.', ', ' )."%</div>";
			echo "</div>";
		}
	}
	echo "</td>";
	echo "</table>";
	echo "</div>";
	echo "<br><p>&nbsp;</p>";
}

?>

<div class="div-border-title">
	Public annotation results
	<a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['manage_annotations']; ?>">
	<img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
</div>

<div class="div-border">
<?php
echo "<table class='manage_tables' style='width: 100%;' >";
echo "<thead><tr>";
echo "<td>dataset name</td>";
echo "<td style='text-align:center;'>creation date</td>";
echo "<td style='width:10%;text-align:center;'>number of transcripts</td>";
echo "<td style='width:155px;text-align:center;'>possible actions</td>";
echo "<td style='width:10%;text-align:center;'>status</td>";
echo "</tr></thead>";
$rwhere = '';
$request = "SELECT * FROM dataset $rwhere ORDER BY creation_date DESC";
$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
while ( $row = mysqli_fetch_array ( $results, MYSQLI_ASSOC ) ) {
	$dataset_id = $row ['dataset_id'];
	$file_base = dirname ( dirname ( __DIR__ ) ) . "/workspace/storage/" . $dataset_id . "/";
	if ($row['state'] != complete){
		$file_base = dirname ( dirname ( __DIR__ ) ) . "/tmp/" . $dataset_id . "/";
	}
	$file_name = "transcripts.fasta";
	$file_path = $file_base . $file_name;
	echo "<form name='transcript_$dataset_id' id='transcript_$dataset_id' action='./includes/download_file.php' method='post' target=\"_blank\">";
	echo "<input type='hidden' name='file_path' value=$file_path></form>";
	$file_name = "regions_nucl.fasta";
	$file_path = $file_base . $file_name;
	echo "<form name='region_$dataset_id' id='region_$dataset_id' action='./includes/download_file.php' method='post' target=\"_blank\">";
	echo "<input type='hidden' name='file_path' value=$file_path></form>";
	$file_name = "regions_prot.fasta";
	$file_path = $file_base . $file_name;
	echo "<form name='protein_$dataset_id' id='protein_$dataset_id' action='./includes/download_file.php' method='post' target=\"_blank\">";
	echo "<input type='hidden' name='file_path' value=$file_path></form>";
	$file_name = "all_annotations.tab";
	$file_path = $file_base . $file_name;
	echo "<form name='annotation_$dataset_id' id='annotation_$dataset_id' action='./includes/download_file.php' method='post' target=\"_blank\">";
	echo "<input type='hidden' name='file_path' value=$file_path></form>";
	echo "<tr>";
	echo "<td>{$row['name']}</td>";
	echo "<td style='text-align:center;'>{$row['creation_date']}</td>";
	$result_nb_transcript = number_format ($row['nb_transcripts'], 0, '.', ',' );
	echo "<td style='text-align:right;'>$result_nb_transcript</td>";
	echo "<td>";

	echo "<a href='./index.php?page=manage_annotations_details&dataset_id=$dataset_id'><button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='";
	echo $tooltip_text['manage_getinfo'];
	echo "' class='btn btn-md btn-primary'>";
	echo "<span class='glyphicon glyphicon-th-list' aria-hidden='true'></span></button></a>";
	echo "<a href='./index.php?page=display&database=$dataset_id'><button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='".$tooltip_text['manage_explore']."'  class='btn btn-md btn-primary'>";
	echo "<span class='glyphicon glyphicon-search' aria-hidden='true'></span></button></a>";
	?>
	<div class="dropdown" style='width: 85px;'>
		<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style='width:85px;'>
			download<span class="caret" style='margin-left:5px;'></span>
		</button>
		<ul style="background-color:#2f70a9" class="dropdown-menu">
			<?php
	echo "<li><a style='color:white' href=\"javascript:document.getElementById('transcript_$dataset_id').submit();\" data-toggle='tooltip' data-placement='top' title='".$tooltip_text['manage_download_transcripts']."'>transcripts</a></li>";
	echo "<li><a style='color:white' href=\"javascript:document.getElementById('region_$dataset_id').submit();\"  data-toggle='tooltip' data-placement='middle' title='".$tooltip_text['manage_download_regions']."'>regions</a></li>";
	echo "<li><a style='color:white' href=\"javascript:document.getElementById('protein_$dataset_id').submit();\" data-toggle='tooltip' data-placement='bottom' title='".$tooltip_text['manage_download_proteins']."'>proteins</a></li>";
	
	$request_nb_annot = "SELECT count(*) FROM annotation WHERE dataset_id=" . $dataset_id;
	$query_nb_annot = mysqli_query ( $connexion, $request_nb_annot ) or die ( "SQL Error:<br>$request_nb_annot<br>" . mysqli_error ( $connexion ) );
	$result_nb_annot = mysqli_fetch_array ( $query_nb_annot ) or die ( "SQL Error:<br>$request_nb_annot<br>" . mysqli_error ( $connexion ) );
	if ($result_nb_annot [0] > 0) {
		echo "<li><a href=\"javascript:document.getElementById('annotation_$dataset_id').submit();\">annotations</a></li>";
	}
	?>
		</ul>
	</div>
</td>

<?php
	echo "<td style='text-align:right;'>";
	if($row['state']== "complete"){
		echo "<div class='progress' style='margin:0;padding:0;height:30px;width: 100%;'>";
		echo "<div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='padding:5px;width: 100%;' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>";
		echo "</div>";
	}else{
		$file_base = dirname(dirname ( __DIR__ )) . "/tmp/" . $dataset_id . "/temporary/";
		$folders = scandir ( $file_base );
		array_shift ( $folders );
		array_shift ( $folders );
		$table = array ();
		sort($folders);
		foreach ( $folders as $folder ) {
			$files = scandir ( $file_base.$folder."/" );
			array_shift ( $files );
			array_shift ( $files );
			$service_tmp = "";
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
		echo "<div class='progress' style='margin:0;padding:0;height:30px;width: 100%;'>";
		echo "<div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='padding:5px;width: $progress%;' aria-valuenow='$progress' aria-valuemin='0' aria-valuemax='100'>".number_format ( $progress, 0, '.', ', ' )."%</div>";
		echo "</div>";
	}
}
echo "</td>";
echo "</table>";
?>
</div>



