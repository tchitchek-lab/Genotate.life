<?php
function datasets_info($row, $connexion, $database_id, $USER_MODE) {
	?>
<script>
function copytextfunctional(){
    text = document.getElementById('textarea_functional').value;
    prompt("Copy to clipboard: Ctrl+C, Enter", text);
}
function copytextsimilarity(){
    text = document.getElementById('textarea_similarity').value;
    prompt("Copy to clipboard: Ctrl+C, Enter", text);
}
</script>
<div style='width: 50%; padding: 0; margin: 0; padding-right: 5px; padding-bottom: 5px; height: 270px;'>
	<div class="div-border-title">
		Dataset information <a style='float: right; margin-right: 10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['dataset_info']; ?>"> <img src="/img/tutorial.svg"
			style='margin-bottom: 2px; height: 20px; filter: invert(90%);'></a>
	</div>
	<div class="div-border" style="padding: 5px; height: 230px">
		<div style="width: 100%;">
			<label for='db_name'>name</label>
			<input readonly type="text" id="name" name="name" value="<?php echo $row['name'];?>" style="width: 100%; height: 2em; text-align: left;background-color:rgba(229,229,229, 0.2);">
		</div>
		<div style="width: 100%;">
			<label for='db_name'>description</label>
			<input readonly type="text" id="name" name="name" value="<?php echo $row['description'];?>" style="width: 100%; height: 2em; text-align: left;background-color:rgba(229,229,229, 0.2);">
		</div>
<?php
	$request_nb_transcript = "SELECT count(*) FROM transcript WHERE dataset_id=" . $row ['dataset_id'];
	$query_nb_transcript = mysqli_query ( $connexion, $request_nb_transcript ) or die ( "SQL Error:<br>$request_nb_transcript<br>" . mysqli_error ( $connexion ) );
	$result_nb_transcript = mysqli_fetch_array ( $query_nb_transcript ) or die ( "SQL Error:<br>$request_nb_transcript<br>" . mysqli_error ( $connexion ) );
	$result_nb_transcript = number_format ( $result_nb_transcript [0], 0, '.', ',' );
	$request_nb_region = "SELECT count(*) FROM region WHERE dataset_id=" . $row ['dataset_id'];
	$query_nb_region = mysqli_query ( $connexion, $request_nb_region ) or die ( "SQL Error:<br>$request_nb_region<br>" . mysqli_error ( $connexion ) );
	$result_nb_region = mysqli_fetch_array ( $query_nb_region ) or die ( "SQL Error:<br>$request_nb_region<br>" . mysqli_error ( $connexion ) );
	if ($row ['state'] == "computing") {
		$result_nb_region = number_format ( $row ['nb_computed_region'], 0, '.', ',' );
	} else {
		$result_nb_region = number_format ( $result_nb_region [0], 0, '.', ',' );
	}
	$request_nb_annot = "SELECT count(*) FROM annotation WHERE dataset_id=" . $row ['dataset_id'];
	$query_nb_annot = mysqli_query ( $connexion, $request_nb_annot ) or die ( "SQL Error:<br>$request_nb_annot<br>" . mysqli_error ( $connexion ) );
	$result_nb_annot = mysqli_fetch_array ( $query_nb_annot ) or die ( "SQL Error:<br>$request_nb_annot<br>" . mysqli_error ( $connexion ) );
	$result_nb_annot = number_format ( $result_nb_annot [0], 0, '.', ',' );
	?>
	<div style="width: 50%; padding-right: 5px;">
			<label for='db_name'>processed transcripts</label>
			<input readonly type="text" value="<?php echo $result_nb_transcript;?>" style="width: 100%; height: 2em; text-align: right;background-color:rgba(229,229,229, 0.2);">
		</div>
		<div style="width: 50%;">
			<label>identified ORFs</label>
			<input readonly type="text" value="<?php echo $result_nb_region;?>" style="width: 100%; height: 2em; text-align: right;background-color:rgba(229,229,229, 0.2);">
		</div>
		<div style="width: 50%; padding-right: 5px;">
			<label>identified annotations</label>
			<input readonly type="text" value="<?php echo $result_nb_annot;?>" style="width: 100%; height: 2em; text-align: right;background-color:rgba(229,229,229, 0.2);">
		</div>
		<div style="width: 50%;">
			<label>creation date</label>
			<input readonly type="text" value="<?php echo $row['creation_date'];?>" style="width: 100%; height: 2em; text-align: center;background-color:rgba(229,229,229, 0.2);">
		</div>
	</div>
</div>
<div style='width: 50%; padding: 0; margin: 0; padding-bottom: 5px; height: 270px;'>
	<div class="div-border-title">
		ORF identification parameters<a style='float: right; margin-right: 10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank"
			title="<?php echo $tooltip_text['orf_panel']; ?>"> <img src="/img/tutorial.svg" style='margin-bottom: 2px; height: 20px; filter: invert(90%);'></a>
	</div>
	<div class="div-border" style="padding: 5px; height: 230px">
		<div style="width: 100%;">
			<label for="start_codon">start codon(s)</label>
			<input readonly type="text" value="<?php echo $row['start_codons'];?>" style="width: 100%; height: 2em; text-align: left;background-color:rgba(229,229,229, 0.2);">
		</div>
		<div style="width: 100%;">
			<label for="stop_codon">stop codon(s)</label>
			<input readonly type="text" value="<?php echo $row['stop_codons'];?>" style="width: 100%; height: 2em; text-align: left;background-color:rgba(229,229,229, 0.2);">
		</div>
		<div class="input-group" style="padding: 0; margin: 0; margin-top: 5px; width: 100%; height: 30px;">
			<span class='input-group-btn' style="width: 66.6%; height: 30px;"><label style="width: 100%; height: 30px;" class="btn btn-default <?php if(intval($row['min_orf_size'])>0){echo "active";}?>" type="button" for='orf_min_size'>minimal ORF length</label></span>
			<input readonly class="form-control" type="number" value="<?php echo $row['min_orf_size'];?>" style="height: 30px; text-align: right;">
			<span class='input-group-addon' style='padding-top: 0; padding-bottom: 0;'>bases</span>
		</div>
		<div class="btn-group" style="width: 100%; padding: 0; margin: 0; margin-top: 5px;">
			<label data-toggle='buttons' style='width: 50%;' class='btn btn-default <?php if($row['inner_orf']){echo "active";}?>'> compute inner ORFs </label>
			<label data-toggle='buttons' style='width: 50%;' class='btn btn-default <?php if($row['outside_orf']){echo "active";}?>'> compute outside ORFs </label>
		</div>
		<div class="btn-group" style="width: 100%; padding: 0; margin: 0; margin-top: 5px; margin-bottom: 5px;">
			<label data-toggle='buttons' style='width: 50%;' class='btn btn-default <?php if($row['compute_ncrna']){echo "active";}?>'> compute ncRNA</label>
			<label data-toggle='buttons' style='width: 50%;' class='btn btn-default <?php if($row['compute_reverse']){echo "active";}?>'> compute both strands</label>
		</div>
	</div>
</div>
<div style='width: 50%; padding: 0; margin: 0; padding-right: 5px; padding-bottom: 5px; height: 250px;'>
	<div class="div-border-title">
		Homology annotation parameters <a style='float: right; margin-right: 10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['similarity_panel']; ?>"> <img src="/img/tutorial.svg"
			style='margin-bottom: 2px; height: 20px; filter: invert(90%);'></a>
		<button onclick='copytextsimilarity();' style="float: right; margin-right: 5px; width: 30px; height: 30px; padding: 5px;" data-toggle="tooltip" data-placement="top" title="" class="btn btn-md btn-primary" data-original-title="copy similarity annotation references">
			<span class="glyphicon glyphicon-copy" aria-hidden="true"></span>
		</button>
	</div>
	<div class="div-border" style='padding: 5px; height: 210px; width: 100%; overflow: auto; overflow-y: scroll;'>
	<?php
	$services_array = explode ( "],", $row ['services'] );
	$i = 0;
	foreach ( $services_array as $service ) {
		if (substr_count ( $service, "BLASTN" ) > 0 || substr_count ( $service, "BLASTP" ) > 0) {
			$key = explode ( "[", $service ) [0];
			$value = explode ( "[", $service ) [1];
			$name = explode ( ",", $value ) [0];
			$identity = explode ( ",", $value ) [1];
			$qc = explode ( ",", $value ) [2];
			$sc = explode ( ",", $value ) [3];
			$sc = rtrim ( $sc, "]" );
			$i ++;
			?>

<div style="padding: 0; margin: 0; margin-top: 5px; width: 100%;">
			<div class='btn-group' role='group' style='align: left; width: 100%;'>
				<label style="width: 90%; height: 20px;" class="btn btn-sm btn-default active" type="button"><?php echo $name;?></label>
				<button style='width: 10%; height: 20px;' class='btn btn-default' type='button' data-toggle='collapse' data-target='#collapse_<?php echo $i;?>' aria-expanded='false' aria-controls='collapse_<?php echo $i;?>'>
					<span class='caret' style='height: 20px;'></span>
				</button>
				<div class='collapse' id='collapse_<?php echo $i;?>' style='width: 100%;'>
					<div class='card card-block' style='width: 100%;'>
						<div class='input-group' style='width: 100%;'>
							<span class='input-group-addon' style='width: 70%; padding-top: 0; padding-bottom: 0;'>identity percentage</span>
							<input readonly class="form-control" type="number" value="<?php echo $identity;?>" style="width: 100%; height: 20px; text-align: right;">
						</div>
						<div class='input-group' style='width: 100%;'>
							<span class='input-group-addon' style='width: 70%; padding-top: 0; padding-bottom: 0;'>query alignment coverage</span>
							<input readonly class="form-control" type="number" value="<?php echo $qc;?>" style="width: 100%; height: 20px; text-align: right;">
						</div>
						<div class='input-group' style='width: 100%;'>
							<span class='input-group-addon' style='width: 70%; padding-top: 0; padding-bottom: 0;'>subject alignment coverage</span>
							<input readonly class="form-control" type="number" value="<?php echo $sc;?>" style="width: 100%; height: 20px; text-align: right;">
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		}
	}
	?>
	</div>
</div>
<div style='width: 50%; padding: 0; margin: 0; padding-bottom: 5px; height: 250px;'>
	<div class="div-border-title">
		Functionnal annotation parameters <a style='float: right; margin-right: 10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['functional_panel']; ?>"> <img src="/img/tutorial.svg"
			style='margin-bottom: 2px; height: 20px; filter: invert(90%);'></a>
		<button onclick='copytextfunctional();' style="float: right; margin-right: 5px; width: 30px; height: 30px; padding: 5px;" data-toggle="tooltip" data-placement="top" title="" class="btn btn-md btn-primary" data-original-title="copy functional annotation services">
			<span class="glyphicon glyphicon-copy" aria-hidden="true"></span>
		</button>
	</div>
	<div class="div-border" style='padding: 5px; height: 210px; width: 100%; overflow: auto; overflow-y: scroll;'>
	<?php
	$services_array = explode ( "],", $row ['services'] );
	foreach ( $services_array as $service ) {
		if ($service != "" && substr_count ( $service, "BLASTN" ) == 0 && substr_count ( $service, "BLASTP" ) == 0) {
			$key = explode ( "[", $service ) [0];
			$value = explode ( "[", $service ) [1];
			$value = rtrim ( $value, "]" );
			?>
<div class="input-group" style="padding: 0; margin: 0; margin-top: 5px; width: 100%; height: 20px;">
			<span class="input-group-btn" style="width: 66.6%; height: 20px;"> <label style="width: 100%; height: 20px;" class="btn btn-sm btn-default active" type="button"><?php echo $key;?></label></span>
			<input readonly class="form-control" type="number" value="<?php echo $value;?>" style="height: 20px; text-align: right;">
		</div>
		<?php
		}
	}
	?>
	</div>
</div>
<?php
	// COPY PASTE AREAS
	$text = "";
	$services_array = explode ( "],", $row ['services'] );
	foreach ( $services_array as $service ) {
		if ($service != "" && substr_count ( $service, "BLASTN" ) == 0 && substr_count ( $service, "BLASTP" ) == 0) {
			$service = rtrim ( $service, "]" );
			$text .= "$service], ";
		}
	}
	echo "<input id='textarea_functional' type='hidden' value='$text'>";
	$text = "";
	$services_array = explode ( "],", $row ['services'] );
	foreach ( $services_array as $service ) {
		if (substr_count ( $service, "BLASTN" ) > 0 || substr_count ( $service, "BLASTP" ) > 0) {
			$key = explode ( "[", $service ) [0];
			$value = explode ( "[", $service ) [1];
			$name = explode ( ",", $value ) [0];
			$identity = explode ( ",", $value ) [1];
			$qc = explode ( ",", $value ) [2];
			$sc = explode ( ",", $value ) [3];
			$sc = rtrim ( $sc, "]" );
			$service = ($name . " identity=" . $identity . ";query_cover=" . $qc . ";subject_cover=" . $sc);
			$text .= "$service, ";
		}
	}
	echo "<input id='textarea_similarity' type='hidden' value='$text'>";
	// DEBUG FILE TABLE
	if ($USER_MODE == "debug") {
		echo "<div class='div-border' style='overflow: auto; margin-bottom: 10px;'>";
		echo "<label type=title>DEBUG: State of annotation services</label>";
		$file_base = dirname ( dirname ( __DIR__ ) ) . "/workspace/storage/" . $database_id . "/temporary/";
		if ($row ['state'] != complete) {
			$file_base = dirname ( dirname ( __DIR__ ) ) . "/tmp/" . $database_id . "/temporary/";
		}
		$folders = scandir ( $file_base );
		array_shift ( $folders );
		array_shift ( $folders );
		$table = array ();
		sort ( $folders );
		// echo '<pre>'; print_r($folders); echo '</pre>';
		foreach ( $folders as $folder ) {
			$files = scandir ( $file_base . $folder . "/" );
			array_shift ( $files );
			array_shift ( $files );
			$service_tmp = "";
			// echo "<br>".$folder;
			// echo '<pre>'; print_r($files); echo '</pre>';
			foreach ( $files as $file ) {
				if (preg_match ( '/^(\d+\_[A-Z]+)\_.+$/', $file, $matches )) {
					$service = $matches [1];
					if (strpos ( $file, "complete.txt" ) !== false) {
						$table [$service] [$folder] = "computed";
					} else {
						if ($table [$service] [$folder] != "computed") {
							$table [$service] [$folder] = "waiting";
						}
					}
				}
			}
		}
		// echo '<pre>'; print_r($table); echo '</pre>';
		if (count ( $folders ) > 0) {
			echo "<table class='manage_tables' >";
			echo "<thead><tr>";
			echo "<td>Service</td>";
			foreach ( $folders as $folder ) {
				echo "<td>region subset $folder</td>";
			}
			echo "</tr></thead>";
			foreach ( $table as $service => $subsets_state ) {
				echo "<tr>";
				echo "<td>$service</td>";
				foreach ( $subsets_state as $service_state ) {
					echo "<td>$service_state</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
		}
		echo "</div>";
	}
}
?>