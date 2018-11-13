<script src="/js/manage.js?v=612656" xmlns:right></script>

<label type=title>Manage reference homology datasets</label>
<p style='text-align: justify; text-justify: inter-word;'>Homology annotations management interface lists the reference database with their computation current state, information, sequences, and the possibility to rename or delete them. The details can be displayed with the release, the species, the
	sequence type, and the description.</p>
<br>
<div class="div-border-title">
	Reference homology datasets <a style='float: right; margin-right: 10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['manage_references']; ?>"> <img src="/img/tutorial.svg" style='margin-bottom: 2px; height: 20px; filter: invert(90%);'></a>
</div>
<div class="div-border">
	<form name='form' id='form' action='' method='post'></form>
<?php
echo "<table class='manage_tables' style='width: 100%;' >";
echo "<thead><tr>";
echo "<td>dataset name</td>";
echo "<td style='width:10%;text-align:center;'>number of sequences</td>";
echo "<td style='width:10%;text-align:center;'>type</td>";
echo "<td style='width:190px;text-align:center;'>possible actions</td>";
echo "<td style='width:10%;text-align:center;'>status</td>";
echo "</tr></thead>";
$request = "SELECT * FROM blast ORDER BY name";
$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
while ( $row = mysqli_fetch_array ( $results, MYSQLI_ASSOC ) ) {
	$dataset_id = $row ['blast_id'];
	$file_base = dirname ( dirname ( __DIR__ ) ) . "/workspace/blastdb/";
	$file_name = "$dataset_id.fasta";
	$file_path = $file_base . $file_name;
	echo "<form name='fasta_$dataset_id' id='fasta_$dataset_id' action='../includes/download_file.php' method='post' target=\"_blank\">";
	echo "<input type='hidden' name='file_name' value='" . $row ['name'] . ".fasta'>";
	echo "<input type='hidden' name='file_path' value=$file_path></form>";
	echo "<tr>";
	echo "<td>{$row['name']}</td>";
	echo "<td style='text-align:right'>" . number_format ( $row ['size'], 0, '.', ',' ) . "</td>";
	echo "<td style='text-align:center;'>{$row['type']}</td>";
	echo "<td>";
	echo "<button style='width:90px;' class='btn btn-md btn-primary' form=\"fasta_$dataset_id\">download</button>";
	echo "<a href='./index.php?page=manage_references_details&dataset_id=$dataset_id'><button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='get details about the homology reference dataset'
  class='btn btn-md btn-primary'>";
	echo "<span class='glyphicon glyphicon-th-list' aria-hidden='true'></span></button></a>";
	if ($USER_MODE == "restricted") {
		echo "<button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='rename the homology reference dataset' class='btn btn-md btn-primary' onclick='rename_reference_dataset($dataset_id)' disabled><span class='glyphicon glyphicon-pencil'></span></button></a>";
		echo "<button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='delete the homology reference dataset' class='btn btn-md btn-danger' onclick='delete_reference_dataset($dataset_id)' disabled><span class='glyphicon glyphicon-remove'></span></button></a>";
	}else {
		echo "<button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='rename the homology reference dataset' class='btn btn-md btn-primary' onclick='rename_reference_dataset($dataset_id)'><span class='glyphicon glyphicon-pencil'></span></button></a>";
		echo "<button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='delete the homology reference dataset' class='btn btn-md btn-danger' onclick='delete_reference_dataset($dataset_id)'><span class='glyphicon glyphicon-remove'></span></button></a>";
	}
	echo "</td>";
	echo "<td style='text-align:right;'>";
	if ($row ['state'] != "complete") {
		echo "<div class='progress' style='width: 100%;'>";
		echo "<div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='width: 0%;' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'>0%</div>";
		echo "</div>";
	} else {
		echo "<div class='progress' style='margin:0;padding:0;height:30px;width: 100%;'>";
		echo "<div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='padding:5px;width: 100%;' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>";
		echo "</div>";
	}
	echo "</td>";
	echo "</tr>";
}
echo "</table>";
?>

</div>




