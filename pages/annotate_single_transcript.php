<script>
	document.title = "Genotate.life - Annotate single transcript";
</script>

<script src="./js/create.js" xmlns:right></script>
<script>
function exec_genotate()
{
    if (!checkEntries_myseq()){
	    return false;
	}
    var debug = document.getElementById("debug").checked;
    if(debug){
		document.getElementById("demo").innerHTML = "Computing, please wait ...";
	}
	var xhr = new XMLHttpRequest();
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

<form action="" enctype="multipart/form-data" id="annotform" name="annotform" value="annotform" method="post">
	<input type='hidden' name='myseq' id='myseq' value='1'>
	<input type='hidden' name='user_id' id='user_id' value='<?php $userid = $user->data()->id; if ($userid > 0){echo $userid;}else{ echo '0';}?>'>
	<label type=title>Annotate a single transcript</label>
	<?php
	if ($USER_MODE == "debug") {
		echo "<label data-toggle='buttons' class='btn btn-default btn-sm' for='debug'><input type='checkbox' id='debug' name='debug' style='display: none;'>debug</label>";
	}else{
		echo "<label data-toggle='buttons' class='btn btn-default btn-sm' for='debug' style='display: none;'><input type='checkbox' id='debug' name='debug' style='display: none;'>debug</label>";
	}
	?>
	<p style='text-align: justify; text-justify: inter-word;'>For a provided transcript sequence, Genotate first searches all the possible Open Reading Frames (ORF). The sequence of each detected ORF is then translated to obtain the sequence of the encoded protein. For each transcript sequence and associated protein, Genotate searches for homology and functional annotations. On the one hand, Genotate identifies homology annotations based on transcriptomic and proteomic references. On the other hand, Genotate identifies functional annotations on the associated protein based on several algorithms and databases (such as conserved domains, protein family, primary and secondary structure, ...).  </p>
	<div style='width: 420px; padding: 0; margin: 0;padding-right:5px;padding-bottom:5px; height: 300px;'>
		<div class="div-border-title">
			Transcript sequence
			<a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['transcript_panel'];?>">
			<img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
		</div>
		<div class='div-border' style='padding:5px;height: 260px;'>
			<div style="width: 100%;">
				<?php 
				$file_path = dirname(dirname(__DIR__)) . "/web/example/1.fasta";
				if ( file_exists($file_path) ) {
					$seq1 = file_get_contents($file_path);
					echo "<input type='hidden' value='$seq1' id='seq1'>";
				}
				$file_path = dirname(dirname(__DIR__)) . "/web/example/2.fasta";
				if ( file_exists($file_path) ) {
					$seq2 = file_get_contents($file_path);
					echo "<input type='hidden' value='$seq2' id='seq2'>";
				}
				$file_path = dirname(dirname(__DIR__)) . "/web/example/3.fasta";
				if ( file_exists($file_path) ) {
					$seq3 = file_get_contents($file_path);
					echo "<input type='hidden' value='$seq3' id='seq3'>";
				}
				?>
				<textarea data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['transcript_sequence_input'];?>" id="sequence" name="sequence" maxlength="20000" value="" onchange="onchangeSequence()" onkeyup='onchangeSequence()' style="white-space: nowrap;width: 100%; height: 115px; text-align: left; resize: none;"></textarea>
				<button class='btn btn-sm btn-secondary' style='border:1px solid lightgrey;margin-bottom:2px;' onclick="setExemple(1);" form='' data-toggle="tooltip" data-placement="right" title="<?php echo $tooltip_text['example_sequence_1'];?>" >sequence exemple 1</button>
				<button class='btn btn-sm btn-secondary' style='border:1px solid lightgrey;margin-bottom:2px;' onclick="setExemple(2);" form='' data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['example_sequence_2'];?>" >sequence exemple 2</button>
				<button class='btn btn-sm btn-secondary' style='border:1px solid lightgrey;margin-bottom:2px;' onclick="setExemple(3);" form='' data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['example_sequence_3'];?>" >sequence exemple 3</button>
				
				<input type="text" id="sequence_clean" name="sequence_clean" value="" readonly style="display: none;">
				<input type="text" id="description" name="description" value="" readonly style="display: none;">
			</div>
			<div>
				<div class="form-group row" style="width: 100%;">
					<label for='db_name'>analysis name</label>
					<input data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['annotation_name'];?>" type="text" id="db_name" name="db_name" value="" onchange='checkName()' onkeyup='checkName()' style="width: 100%; height: 2em; text-align: left;">
				</div>
				<div class="form-group" style="width: 100%;">
					<label for='email'>email notification</label>
					<input data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['email'];?>" type="text" id="email" name="email" value="" onchange='check_email()' onkeyup='check_email()' onchange='check_email()' style="width: 100%; height: 2em; text-align: left;">
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
Annotate transcript 
</button>

<p id="demo"></p>
