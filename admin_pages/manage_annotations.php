<script src="/js/manage.js?v=618546156" xmlns:right></script>

<label type=title>Manage annotation results</label>
<p style='text-align: justify;text-justify: inter-word;'>
Genotate management interface lists the annotated transcripts query with their computation current state, information, results, and the possibility to rename or delete them. For each query, the transcripts sequences, the ORFs sequences, and the annotations can be downloaded. The details can be displayed with the ORFs detection parameters, the tools used for the functional annotations, and the databases used for the homology annotations.
</p>
<br>
<?php
if (! empty ( $_POST ['dataset_id'] ) && $_POST ['dataset_id'] != '') {
	$dataset_id = $_POST ['dataset_id'];
	$request = "SELECT * FROM dataset INNER JOIN parameters USING (dataset_id) WHERE dataset_id='$dataset_id' ORDER BY name";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
	$row = mysqli_fetch_array ( $results, MYSQLI_ASSOC );
	include("../includes/datasets_info.php");
	datasets_info($row, $connexion,$dataset_id,$USER_MODE);
}
?>
<div class="div-border-title">
	Annotation results
	<a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['manage_annotations']; ?>">
	<img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
</div>
<div class="div-border">
<form name='datasetform' id='datasetform' action='' method='post'></form>

<?php
echo "<table class='manage_tables' style='width: 100%;' >";
echo "<thead><tr>";
echo "<td>dataset name</td>";
echo "<td style='text-align:center;'>creation date</td>";
echo "<td style='width:10%;text-align:center;'>number of transcripts</td>";
echo "<td style='width:215px;text-align:right;'>actions</td>";
echo "<td style='width:10%;text-align:right;'>status</td>";
echo "</tr></thead>";
$request = "SELECT * FROM dataset ORDER BY creation_date DESC";
$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
while ( $row = mysqli_fetch_array ( $results, MYSQLI_ASSOC ) ) {
	$dataset_id = $row ['dataset_id'];
	$file_base = dirname ( dirname ( __DIR__ ) ) . "/workspace/storage/" . $dataset_id . "/";
	if ($row['state'] != complete){
		$file_base = dirname ( dirname ( __DIR__ ) ) . "/tmp/" . $dataset_id . "/";
	}
	$file_name = "transcripts.fasta";
	$file_path = $file_base . $file_name;
	echo "<form name='transcript_$dataset_id' id='transcript_$dataset_id' action='../includes/download_file.php' method='post' target=\"_blank\">";
	echo "<input type='hidden' name='file_path' value=$file_path></form>";
	$file_name = "regions_nucl.fasta";
	$file_path = $file_base . $file_name;
	echo "<form name='region_$dataset_id' id='region_$dataset_id' action='../includes/download_file.php' method='post' target=\"_blank\">";
	echo "<input type='hidden' name='file_path' value=$file_path></form>";
	$file_name = "regions_prot.fasta";
	$file_path = $file_base . $file_name;
	echo "<form name='protein_$dataset_id' id='protein_$dataset_id' action='../includes/download_file.php' method='post' target=\"_blank\">";
	echo "<input type='hidden' name='file_path' value=$file_path></form>";
	$file_name = "all_annotations.tab";
	$file_path = $file_base . $file_name;
	echo "<form name='annotation_$dataset_id' id='annotation_$dataset_id' action='../includes/download_file.php' method='post' target=\"_blank\">";
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
  
	echo "<a href='../index.php?page=display&database=$dataset_id'><button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='explore dataset' class='btn btn-md btn-primary'>";
	echo "<span class='glyphicon glyphicon-search' aria-hidden='true'></span></button></a>";
	if ($USER_MODE != "restricted") {
		echo "<button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='rename dataset' class='btn btn-md btn-primary' onclick='rename_annotation_dataset($dataset_id)'><span class='glyphicon glyphicon-pencil'></span></button>";
		if ($row ['state'] != "computing") {
			echo "<button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='delete dataset' class='btn btn-md btn-danger' onclick='delete_annotation_dataset($dataset_id)'><span class='glyphicon glyphicon-remove'></span></button>";
		} else {
			echo "<button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='interrupt dataset' class='btn btn-md btn-danger' onclick='interrupt_annotation_dataset($dataset_id)'><span class='glyphicon glyphicon-off'></span></button>";
		}
	}else{
		
	}
	?>
	<div class="dropdown" style='width: 85px;'>
		<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style='width:85px;'>
			download<span class="caret" style='margin-left:5px;'></span>
		</button>
		<ul class="dropdown-menu">
			<?php
	echo "<li><a href=\"javascript:document.getElementById('transcript_$dataset_id').submit();\">transcripts</a></li>";
	echo "<li><a href=\"javascript:document.getElementById('region_$dataset_id').submit();\">regions</a></li>";
	echo "<li><a href=\"javascript:document.getElementById('protein_$dataset_id').submit();\">proteins</a></li>";
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
		echo "<div class='progress' style='margin:0;padding:0;height:30px;width: 100%;'>";
		echo "<div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='padding:5px;width: $progress%;' aria-valuenow='$progress' aria-valuemin='0' aria-valuemax='100'>".number_format ( $progress, 0, '.', ', ' )."%</div>";
		echo "</div>";
	}
}
echo "</td>";
echo "</table>";
?>

</div>

