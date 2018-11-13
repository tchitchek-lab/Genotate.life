<script>
	document.title = "Genotate.life - Annotate multiple transcripts";
</script>

<script src="../js/create.js" xmlns:right></script>
<script>
function exec_genotate()
{
    if (!checkEntries()){
	    return false;
	}
    var debug = document.getElementById("debug").checked;
    if(debug){
		document.getElementById("demo").innerHTML = "Computing, please wait ...";
	}
	var xhr = new XMLHttpRequest();
	xhr.upload.addEventListener("progress", function (event) {
	    var percent = (event.loaded / event.total) * 100;
	    percent = Math.floor( percent );
	    var progressbar = $('.progress-bar');
	    var percentVal = percent + '%';
	    progressbar.width(percentVal);
	    progressbar.html(percentVal);
	});
	xhr.open ("POST", "./includes/launcher_genotate.php", true);
	xhr.onreadystatechange = function() {
	    if(xhr.readyState == 4 && xhr.status == 200) {
		    if(debug){
				document.getElementById("demo").innerHTML = xhr.responseText;
		    }else{
				window.location.replace("/index.php?page=display&database="+xhr.responseText);
		    }
	    }
	}
	var oFormElement = document.getElementById("annotform");
	xhr.send (new FormData (oFormElement));
}
</script>

<div id="db_names_div" style="display: none;">
	<?php
	$request = "SELECT name FROM dataset";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
	$value = "";
	while ( $row = mysqli_fetch_array ( $results, MYSQLI_ASSOC ) ) {
		$value .= $row ['name'] . ",";
	}
	$value = rtrim ( $value, "," );
	echo "<input id='db_names' type='hidden' value='{$value}'>";
	?>
</div>

<form action="" enctype="multipart/form-data" id="annotform" name="annotform" value="annotform" method="post" onsubmit="return checkEntries();">
	<input type='hidden' name='myseq' id='myseq' value='0'>
	<input type='hidden' name='user_id' id='user_id' value='<?php $userid = $user->data()->id; if ($userid > 0){echo $userid;}else{ echo '0';}?>'>
	<label type=title>Annotate multiple transcripts</label>
	<?php 
	if ($USER_MODE == "debug") {
		echo "<label data-toggle='buttons' class='btn btn-default btn-sm' for='debug'><input type='checkbox' id='debug' name='debug' style='display: none;'>debug</label>";
	}else{
		echo "<label data-toggle='buttons' class='btn btn-default btn-sm' for='debug' style='display: none;'><input type='checkbox' id='debug' name='debug' style='display: none;'>debug</label>";
	}
	?>
	<p style='text-align: justify;text-justify: inter-word;'>
	For all provided transcript sequences, Genotate first searches all the possible Open Reading Frames (ORF). The sequence of each detected ORF is then translated to obtain the sequence of the encoded protein. For each transcript sequence and associated protein, Genotate searches for homology and functional annotations. On the one hand, Genotate identifies homology annotations based on transcriptomic and proteomic references. On the other hand, Genotate identifies functional annotations on the associated protein based on several algorithms and databases (such as conserved domains, protein family, primary and secondary structure, ...).  
	</p>
	<?php
	$request = "SELECT dataset_id FROM dataset WHERE state = 'computing' and myseq=0";
	$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
	$nb_datasets_computing = mysqli_num_rows($results);
	if($nb_datasets_computing > 0){
		echo "<label>There is already $nb_datasets_computing dataset(s) computing</label>";
	}
	?>
	<br>
	<div style='width: 420px; padding: 0; margin: 0;padding-right:5px;padding-bottom:5px; height: 300px;'>
		<div class="div-border-title">
			Transcript sequences
			<a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['transcripts_panel'];?>">
			<img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
		</div>
		<div class="div-border" style='padding:5px;height: 260px;'>
			<div class="form-group row" style="width: 100%;">
				<input data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['transcript_sequence_file'];?>" type="button" class='btn btn-default' id="file_button" value="select a fasta file" onclick="document.getElementById('file').click();" style="border: 1px solid grey; font-size: 16px; height: 55px; width: 100%;">
				<input type="file" style="display: none;" id="file" name="file" ACCEPT=".fasta" onchange="getFileName()">
			</div>
			<div>
				<div class="form-group row" style="width: 100%;">
					<label for='db_name'>analysis name</label>
					<input data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['annotation_name'];?>" type="text" id="db_name" name="db_name" value="" onchange='checkName()' onkeyup='checkName()' style="width: 100%; height: 2em; text-align: left;">
				</div>
				<div class="form-group" style="width: 100%;">
					<label for='email'>email notification</label>
					<input data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['email'];?>" type="text" id="email" name="email" value="" onchange='check_email()' onkeyup='check_email()' style="width: 100%; height: 2em; text-align: left;">
				</div>
				<div class="form-group" style="width: 100%;">
					<label for='description'>analysis description</label>
					<textarea data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['annotation_description'];?>" type="text" id="description" name="description" value="" style="white-space: nowrap;width: 100%; height: 60px; text-align: left; resize: none;"></textarea>
				</div>
			</div>
		</div>
	</div>
	<?php 
	include(dirname(__DIR__) . "/includes/create_orf_annotations.php");
	?>
</form>
<br>
<button onclick="exec_genotate();" style="width: 100%; font-size: 1.3em;" class="btn btn-secondary active" />
Annotate transcripts
</button>
<div class='progress' style='margin: 0; padding: 0; height: 30px;width:100%;'>
	<div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='width: 0%;padding:0; ' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'></div>
</div>
<p id="demo"></p>
