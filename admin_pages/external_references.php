<?php
// load BLAST available databases
$request = "SELECT name, version, species, sequence_type FROM blast";
$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
$blast_db_array = array ();
while ( $row = mysqli_fetch_array ( $results, MYSQLI_ASSOC ) ) {
	$db_name = $row ['name'];
	if ($row ['version'] != "") {
		$db_name = $row ['name'];
	}
	array_push ( $blast_db_array, $db_name );
}
?>

<script src="/js/synchronize.js?v=26514651" xmlns:right></script>

<?php
$noncode_file = array ();
$noncode_file ["Arabidopsis Thaliana"] = 'NONCODEv5_arabidopsis.fa.gz';
$noncode_file ["Gallus gallus"] = 'NONCODEv5_chicken.fa.gz';
$noncode_file ["Pan troglodytes"] = 'NONCODEv5_chimp.fa.gz';
$noncode_file ["Bos taurus"] = 'NONCODEv5_cow.fa.gz';
$noncode_file ["Caenorhabditis Elegans"] = 'NONCODEv5_celegans.fa.gz';
$noncode_file ["Drosophila Melanogaster"] = 'NONCODEv5_fruitfly.fa.gz';
$noncode_file ["Gorilla"] = 'NONCODEv5_gorilla.fa.gz';
$noncode_file ["Homo sapiens"] = 'NONCODEv5_human.fa.gz';
$noncode_file ["Mus musculus"] = 'NONCODEv5_mouse.fa.gz';
$noncode_file ["Opossum"] = 'NONCODEv5_opossum.fa.gz';
$noncode_file ["Orangutan"] = 'NONCODEv5_orangutan.fa.gz';
$noncode_file ["Sus scrofa"] = 'NONCODEv5_pig.fa.gz';
$noncode_file ["Ornithorhynchus anatinus"] = 'NONCODEv5_platypus.fa.gz';
$noncode_file ["Rattus"] = 'NONCODEv5_rat.fa.gz';
$noncode_file ["Rhesus"] = 'NONCODEv5_rhesus.fa.gz';
$noncode_file ["Saccharomyces cerevisiae"] = 'NONCODEv5_yeast.fa.gz';
$noncode_file ["Danio rerio"] = 'NONCODEv5_zebrafish.fa.gz';

$noncode_link = array ();
$noncode_link ["Arabidopsis Thaliana"] = 'A.Thaliana';
$noncode_link ["Gallus gallus"] = 'Chicken';
$noncode_link ["Pan troglodytes"] = 'Chimp';
$noncode_link ["Bos taurus"] = 'Cow';
$noncode_link ["Caenorhabditis Elegans"] = 'C.Elegans';
$noncode_link ["Drosophila Melanogaster"] = 'D.Melanogaster';
$noncode_link ["Gorilla"] = 'Gorilla';
$noncode_link ["Homo sapiens"] = 'Human';
$noncode_link ["Mus musculus"] = 'Mouse';
$noncode_link ["Opossum"] = 'Opossum';
$noncode_link ["Orangutan"] = 'Orangutan';
$noncode_link ["Sus scrofa"] = 'Pig';
$noncode_link ["Ornithorhynchus anatinus"] = 'Platypus';
$noncode_link ["Rattus"] = 'Rat';
$noncode_link ["Rhesus"] = 'Rhesus';
$noncode_link ["Saccharomyces cerevisiae"] = 'Yeast';
$noncode_link ["Danio rerio"] = 'Zebrafish';

$noncode_desc = array ();
$noncode_desc ["Arabidopsis Thaliana"] = "3,853 lncRNA transcripts for 2,477 lncRNA genes ";
$noncode_desc ["Gallus gallus"] = "24,075 lncRNA transcripts for 16,674 lncRNA genes";
$noncode_desc ["Pan troglodytes"] = "18,604 lncRNA transcripts for 13,224 lncRNA genes";
$noncode_desc ["Bos taurus"] = "43,283 lncRNA transcripts for 40,432 lncRNA genes";
$noncode_desc ["Caenorhabditis Elegans"] = "6,308 lncRNA transcripts for 5,637 lncRNA genes";
$noncode_desc ["Drosophila Melanogaster"] = "56,016 lncRNA transcripts for 14,848 lncRNA genes";
$noncode_desc ["Gorilla"] = "20,785 lncRNA transcripts for 17,140 lncRNA genes";
$noncode_desc ["Homo sapiens"] = "233,696 lncRNA transcripts for 144,134 lncRNA genes";
$noncode_desc ["Mus musculus"] = "185,033 lncRNA transcripts for 126,415 lncRNA genes";
$noncode_desc ["Opossum"] = "21,014 lncRNA transcripts for 14,135 lncRNA genes";
$noncode_desc ["Orangutan"] = "15,601 lncRNA transcripts for 13,432 lncRNA genes";
$noncode_desc ["Sus scrofa"] = "30,261 lncRNA transcripts for 18,221 lncRNA genes";
$noncode_desc ["Ornithorhynchus anatinus"] = "11,518 lncRNA transcripts for 9,394 lncRNA genes";
$noncode_desc ["Rattus"] = "59,902 lncRNA transcripts for 50,570 lncRNA genes";
$noncode_desc ["Rhesus"] = "9,325 lncRNA transcripts for 6,125 lncRNA genes";
$noncode_desc ["Saccharomyces cerevisiae"] = "137 lncRNA transcripts for 121 lncRNA genes";
$noncode_desc ["Danio rerio"] = "13,407 lncRNA transcripts for 9,936 lncRNA genes";

$ensembl_release = 88;
$ensembl_desc ["ailuropoda melanoleuca"] = "Coding genes 19,343 Non coding genes 3,141";
$ensembl_desc ["anas platyrhynchos"] = "Coding genes 15,634 Non coding genes 567";
$ensembl_desc ["anolis carolinensis"] = "Coding genes 18,595 Non coding genes 7,168";
$ensembl_desc ["astyanax mexicanus"] = "Coding genes 23,042 Non coding genes 2,208";
$ensembl_desc ["bos taurus"] = "Coding genes 19,994 Non coding genes 3,825";
$ensembl_desc ["caenorhabditis elegans"] = "Coding genes 20,362 Non coding genes 24,719";
$ensembl_desc ["callithrix jacchus"] = "Coding genes 20,978 Non coding genes 9,000";
$ensembl_desc ["canis familiaris"] = "Coding genes 19,856 Non coding genes 11,898";
$ensembl_desc ["cavia porcellus"] = "Coding genes 18,673 Non coding genes 5,963";
$ensembl_desc ["chlorocebus sabaeus"] = "Coding genes 19,165 Non coding genes 8,245";
$ensembl_desc ["choloepus hoffmanni"] = "Coding genes 12,393 Non coding genes 2,030";
$ensembl_desc ["ciona intestinalis"] = "Coding genes 16,671 Non coding genes 455";
$ensembl_desc ["ciona savignyi"] = "Coding genes 11,616 Non coding genes 340";
$ensembl_desc ["danio rerio"] = "Coding genes 25,832 Non coding genes 6,060";
$ensembl_desc ["dasypus novemcinctus"] = "Coding genes 22,711 Non coding genes 9,163";
$ensembl_desc ["dipodomys ordii"] = "Coding genes 15,798 Non coding genes 3,036";
$ensembl_desc ["drosophila melanogaster"] = "Coding genes 13,918 Non coding genes 3,384";
$ensembl_desc ["echinops telfairi"] = "Coding genes 16,575 Non coding genes 5,680";
$ensembl_desc ["equus caballus"] = "Coding genes 20,449 Non coding genes 2,142";
$ensembl_desc ["erinaceus europaeus"] = "Coding genes 14,601 Non coding genes 6,456";
$ensembl_desc ["felis catus"] = "Coding genes 19,493 Non coding genes 1,855";
$ensembl_desc ["ficedula albicollis"] = "Coding genes 15,303 Non coding genes 6,539";
$ensembl_desc ["gadus morhua"] = "Coding genes 20,095 Non coding genes 1,541";
$ensembl_desc ["gallus gallus"] = "Coding genes 18,346 Non coding genes 6,492";
$ensembl_desc ["gasterosteus aculeatus"] = "Coding genes 20,787 Non coding genes 1,617";
$ensembl_desc ["gorilla gorilla"] = "Coding genes 20,962 Non coding genes 6,701";
$ensembl_desc ["homo sapiens"] = "Coding genes 20,310 Non coding genes 22,529";
$ensembl_desc ["ictidomys tridecemlineatus"] = "Coding genes 18,826 Non coding genes 3,166";
$ensembl_desc ["latimeria chalumnae"] = "Coding genes 19,569 Non coding genes 2,918";
$ensembl_desc ["lepisosteus oculatus"] = "Coding genes 18,341 Non coding genes 4,932";
$ensembl_desc ["loxodonta africana"] = "Coding genes 20,033 Non coding genes 2,644";
$ensembl_desc ["macaca mulatta"] = "Coding genes 21,099 Non coding genes 11,001";
$ensembl_desc ["macropus eugenii"] = "Coding genes 15,290 Non coding genes 1,472";
$ensembl_desc ["meleagris gallopavo"] = "Coding genes 14,123 Non coding genes 755";
$ensembl_desc ["microcebus murinus"] = "Coding genes 18,103 Non coding genes 10,226";
$ensembl_desc ["monodelphis domestica"] = "Coding genes 21,327 Non coding genes 8,320";
$ensembl_desc ["mus musculus"] = "Coding genes 22,615 Non coding genes 14,299";
$ensembl_desc ["myotis lucifugus"] = "Coding genes 19,728 Non coding genes 4,408";
$ensembl_desc ["nomascus leucogenys"] = "Coding genes 18,575 Non coding genes 7,172";
$ensembl_desc ["ochotona princeps"] = "Coding genes 16,006 Non coding genes 5,732";
$ensembl_desc ["oreochromis niloticus"] = "Coding genes 21,437 Non coding genes 5,626";
$ensembl_desc ["ornithorhynchus anatinus"] = "Coding genes 21,698 Non coding genes 7,531";
$ensembl_desc ["oryctolagus cuniculus"] = "Coding genes 19,293 Non coding genes 3,375";
$ensembl_desc ["oryzias latipes"] = "Coding genes 19,699 Non coding genes 759";
$ensembl_desc ["otolemur garnettii"] = "Coding genes 19,506 Non coding genes 7,276";
$ensembl_desc ["ovis aries"] = "Coding genes 20,921 Non coding genes 5,843";
$ensembl_desc ["pan troglodytes"] = "Coding genes 18,759 Non coding genes 8,681";
$ensembl_desc ["papio anubis"] = "Coding genes 19,210 Non coding genes 9,272";
$ensembl_desc ["pelodiscus sinensis"] = "Coding genes 18,189 Non coding genes 1,042";
$ensembl_desc ["petromyzon marinus"] = "Coding genes 10,415 Non coding genes 2,652";
$ensembl_desc ["poecilia formosa"] = "Coding genes 23,615 Non coding genes 679";
$ensembl_desc ["pongo abelii"] = "Coding genes 20,424 Non coding genes 6,996";
$ensembl_desc ["procavia capensis"] = "Coding genes 16,057 Non coding genes 1,720";
$ensembl_desc ["pteropus vampyrus"] = "Coding genes 16,990 Non coding genes 4,171";
$ensembl_desc ["rattus norvegicus"] = "Coding genes 22,250 Non coding genes 8,934";
$ensembl_desc ["saccharomyces cerevisiae"] = "Coding genes 6,692 Non coding genes 413";
$ensembl_desc ["sarcophilus harrisii"] = "Coding genes 18,788 Non coding genes 1,490";
$ensembl_desc ["sorex araneus"] = "Coding genes 13,187 Non coding genes 4,558";
$ensembl_desc ["sus scrofa"] = "Coding genes 21,630 Non coding genes 3,124";
$ensembl_desc ["taeniopygia guttata"] = "Coding genes 17,488 Non coding genes 724";
$ensembl_desc ["takifugu rubripes"] = "Coding genes 18,523 Non coding genes 703";
$ensembl_desc ["tarsius syrichta"] = "Coding genes 13,628 Non coding genes 5,386";
$ensembl_desc ["tetraodon nigroviridis"] = "Coding genes 19,602 Non coding genes 813";
$ensembl_desc ["tupaia belangeri"] = "Coding genes 15,471 Non coding genes 3,073";
$ensembl_desc ["tursiops truncatus"] = "Coding genes 16,550 Non coding genes 3,790";
$ensembl_desc ["vicugna pacos"] = "Coding genes 11,765 Non coding genes 2,532";
$ensembl_desc ["xenopus tropicalis"] = "Coding genes 18,442 Non coding genes 1,306";
$ensembl_desc ["xiphophorus maculatus"] = "Coding genes 20,379 Non coding genes 372";
?>
<label type=title>Load external references for homology annotation</label>
<p style='text-align: justify; text-justify: inter-word;'>Create
	references databases based on genome, proteome, transcriptome available
	on NONCODE, ENSEMBL and Uniref.</p>
<br>
<div class="div-border-title">
	NONCODE reference homology datasets
	<a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['NONCODE']; ?>">
	<img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
</div>
<div class="div-border" style="width:100%;margin-bottom:10px;">
	<table style='width: 100%;' class='manage_tables'>
	<thead>
		<tr>
			<td style='width: 35%;'>database</td>
			<td style='width: 5%;'>sync</td>
			<td style='width: 55%;'>description</td>
			<td style='width: 5%;'>link</td>
		</tr>
		</thead>
<?php
foreach ( $noncode_link as $species => $name ) {
	echo "<form id='form_$species' action='http://www.noncode.org/browse.php' method='post' target='_blank'><input type='hidden' name='org' value='$name'></form>";
}
foreach ( $noncode_desc as $species => $desc ) {
	$file = $noncode_file [$species];
	echo "<tr>";
	$dbname = "NONCODE_".str_replace(" ","_",strtolower($species));
	echo "<td>$dbname</td>";
	if (in_array ( $dbname, $blast_db_array )) {
		echo "	<td><button class='btn btn-success btn-sm' id='$dbname' form='' ";
		echo ($USER_MODE == 'restricted'?'disabled':'');
		echo ">ncRNA</button></td>";
	} else {
		echo "	<td><button class='btn btn-primary btn-sm' id='$dbname' onclick=\"synchronize_noncode('$dbname', '$file');\" form='' ";
		echo ($USER_MODE == 'restricted'?'disabled':'');
		echo ">ncRNA</button></td>";
	}
	echo "	<td>$desc</td>";
	echo "	<td><button class='btn btn-link btn-sm' type='submit' form='form_$species' style='width:30px;height:30px;padding:5px;' ";
		//echo ($USER_MODE == 'restricted'?'disabled':'');
		echo "><span class='glyphicon glyphicon-search' aria-hidden='true'></span></button></td>";
	echo "</tr>";
	
	
//	<a href='./index.php?page=display&database=$dataset_id'><button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='".$tooltip_text['manage_explore']."'  class='btn btn-md btn-primary'>";
//	echo "<span class='glyphicon glyphicon-search' aria-hidden='true'></span></button></a>
	
}
?>
</table>
</div>
<div class="div-border-title">
	Uniref reference homology datasets
	<a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['UNIREF']; ?>">
	<img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
</div>
<div class="div-border" style="width:100%;margin-bottom:10px;">
	<table style='width: 100%;' class='manage_tables'>
	<thead>
		<tr>
			<td style='width: 35%;'>database</td>
			<td style='width: 5%;'>sync</td>
			<td style='width: 55%;'>description</td>
			<td style='width: 5%;'>link</td>
		</tr>
		</thead>
		<tr>
			<td>UNIREF_swissprot</td>
	<?php
	if (in_array ( "UNIREF_swissprot", $blast_db_array )) {
		echo "	<td><button class='btn btn-success btn-sm' id='UNIREF_swissprot' form='' ";
		echo ($USER_MODE == 'restricted'?'disabled':'');
		echo ">protein</button></td>";
	} else {
		echo "	<td><button class='btn btn-primary btn-sm' id='UNIREF_swissprot' onclick=\"synchronize_uniref('UNIREF_swissprot');\" form='' ";
		echo ($USER_MODE == 'restricted'?'disabled':'');
		echo ">protein</button></td>";
	}
	?>
	<td>Dataset of 554,515 proteins. High quality manually annotated and non-redundant protein sequence
				database.</td>
			<td><a href='http://www.uniprot.org/downloads' target='_blank'><img src='/img/link.svg' style='margin-left:5px;margin-bottom: 2px;height: 20px;'></a></td>
		</tr>

		<tr>
			<td>UNIREF_trEMBL</td>
	<?php
	if (in_array ( "UNIREF_trEMBL", $blast_db_array )) {

		echo "	<td><button class='btn btn-success btn-sm' id='UNIREF_trEMBL' form='' ";
		echo ($USER_MODE == 'restricted'?'disabled':'');
		echo ">protein</button></td>";
	} else {
		echo "	<td><button class='btn btn-primary btn-sm' id='UNIREF_trEMBL' onclick=\"synchronize_uniref('UNIREF_trEMBL');\" form='' ";
		echo ($USER_MODE == 'restricted'?'disabled':'');
		echo ">protein</button></td>";
	}
	?>
	<td>Dataset of 85,272,789 proteins, very important loading time. UniProtKB/TrEMBL contains high quality computationally analyzed
				records that are enriched with automatic annotation and
				classification.</td>
			<td><a href='http://www.uniprot.org/downloads' target='_blank'><img src='/img/link.svg' style='margin-left:5px;margin-bottom: 2px;height: 20px;'></a></td>
		</tr>

		<tr>
			<td>UNIREF_50</td>
	<?php
	if (in_array ( "UNIREF_50", $blast_db_array )) {
		echo "	<td><button class='btn btn-success btn-sm' id='UNIREF_50' form='' ";
		echo ($USER_MODE == 'restricted'?'disabled':'');
		echo "protein</button></td>";
	} else {
		echo "	<td><button class='btn btn-primary btn-sm' id='UNIREF_50' onclick=\"synchronize_uniref('UNIREF_50');\" form='' ";
		echo ($USER_MODE == 'restricted'?'disabled':'');
		echo ">protein</button></td>";
	}
	?>
	<td>Dataset of 22,237,361 proteins, very important loading time. UniParc(repository of all protein sequences) records clustering for
				a coverage of 50 percents.</td>
			<td><a href='http://www.uniprot.org/downloads' target='_blank'><img src='/img/link.svg' style='margin-left:5px;margin-bottom: 2px;height: 20px;'></a></td>
		</tr>

		<tr>
			<td>UNIREF_90</td>
	<?php
	if (in_array ( "UNIREF_90", $blast_db_array )) {
		echo "	<td><button class='btn btn-success btn-sm' id='UNIREF_90' form='' ";
		echo ($USER_MODE == 'restricted'?'disabled':'');
		echo ">protein</button></td>";
	} else {
		echo "	<td><button class='btn btn-primary btn-sm' id='UNIREF_90' onclick=\"synchronize_uniref('UNIREF_90');\" form='' ";
		echo ($USER_MODE == 'restricted'?'disabled':'');
		echo ">protein</button></td>";
	}
	?>
	<td>Dataset of 55,978,921 proteins, very important loading time. UniParc(repository of all protein sequences) records clustering for
				a coverage of 90 percents.</td>
			<td><a href='http://www.uniprot.org/downloads' target='_blank'><img src='/img/link.svg' style='margin-left:5px;margin-bottom: 2px;height: 20px;'></a></td>
		</tr>

		<tr>
			<td>UNIREF_100</td>
<?php
if (in_array ( "UNIREF_100", $blast_db_array )) {
	echo "	<td><button class='btn btn-success btn-sm' id='UNIREF_100' form='' ";
		echo ($USER_MODE == 'restricted'?'disabled':'');
		echo ">protein</button></td>";
} else {
	echo "	<td><button class='btn btn-primary btn-sm' id='UNIREF_100' onclick=\"synchronize_uniref('UNIREF_100');\" form='' ";
		echo ($USER_MODE == 'restricted'?'disabled':'');
		echo ">protein</button></td>";
}
?>
	<td>Dataset of 108,463,340 proteins, very important loading time. UniProt Knowledgebase(extensively curated protein information) and
				selected UniParc records (repository of all protein sequences)</td>
			<td><a href='http://www.uniprot.org/downloads' target='_blank'><img src='img/link.svg' style='margin-left:5px;margin-bottom: 2px;height: 20px;'></a></td>
		</tr>
	</table>
</div>
<div class="div-border-title">
	Ensembl reference homology datasets
	<a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['ENSEMBL']; ?>">
	<img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
</div>
<div class="div-border" style="width:100%;margin-bottom:10px;">
	<form id='form_db' name='form_db' action="" method="post"></form>
	<table class='manage_tables' id='table' style='width: 100%;'>
	<thead>
		<tr>
			<td style='width: 35%;'>database</td>
			<td style='width: 23%;'>sync</td>
			<td style='width: 37%;'>description</td>
			<td style='width: 5%;'>link</td>
		</tr>
	</thead>
<?php
foreach ( $ensembl_desc as $species => $desc ) {
	echo "<tr>";
	$dbname = "ENSEMBL_".str_replace(" ","_",$species);
	echo "<td>$dbname</td>";
	echo "<td>";
	$sequence_type = "cds";
	$dbname_type = $dbname."_".$ensembl_release."_".$sequence_type;
	if (in_array ($dbname_type, $blast_db_array )) {
		echo "<button id='$ensembl_release$species$sequence_type' class='btn btn-success btn-sm' style='margin:3px;' ";
		echo ($USER_MODE == 'restricted'?'disabled':'');
		echo ">CDS</button>";
	} else {
		echo "<button id='$ensembl_release$species$sequence_type' class='btn btn-primary btn-sm' style='margin:3px;' onclick=\"synchronize('$dbname_type', '$ensembl_release', '$species', '$sequence_type')\" ";
		echo ($USER_MODE == 'restricted'?'disabled':'');
		echo ">CDS</button>";
	}
	$sequence_type = "cdna";
	$dbname_type = $dbname."_".$ensembl_release."_".$sequence_type;
	if (in_array ($dbname_type, $blast_db_array )) {
		echo "<button id='$ensembl_release$species$sequence_type' class='btn btn-success btn-sm' style='margin:3px;' ";
		echo ($USER_MODE == 'restricted'?'disabled':'');
		echo ">cDNA</button>";
	} else {
		echo "<button id='$ensembl_release$species$sequence_type' class='btn btn-primary btn-sm' style='margin:3px;' onclick=\"synchronize('$dbname_type', '$ensembl_release', '$species', '$sequence_type')\" ";
		echo ($USER_MODE == 'restricted'?'disabled':'');
		echo ">cDNA</button>";
	}
	$sequence_type = "ncrna";
	$dbname_type = $dbname."_".$ensembl_release."_".$sequence_type;
	if (in_array ($dbname_type, $blast_db_array )) {
		echo "<button id='$ensembl_release$species$sequence_type' class='btn btn-success btn-sm' style='margin:3px;' ";
		echo ($USER_MODE == 'restricted'?'disabled':'');
		echo ">ncRNA</button>";
	} else {
		echo "<button id='$ensembl_release$species$sequence_type' class='btn btn-primary btn-sm' style='margin:3px;' onclick=\"synchronize('$dbname_type', '$ensembl_release', '$species', '$sequence_type')\" ";
		echo ($USER_MODE == 'restricted'?'disabled':'');
		echo ">ncRNA</button>";
	}
	$sequence_type = "pep";
	$dbname_type = $dbname."_".$ensembl_release."_".$sequence_type;
	if (in_array ($dbname_type, $blast_db_array )) {
		echo "<button id='$ensembl_release$species$sequence_type' class='btn btn-success btn-sm' style='margin:3px;' ";
		echo ($USER_MODE == 'restricted'?'disabled':'');
		echo ">protein</button>";
	} else {
		echo "<button id='$ensembl_release$species$sequence_type' class='btn btn-primary btn-sm' style='margin:3px;' onclick=\"synchronize('$dbname_type', '$ensembl_release', '$species', '$sequence_type')\" ";
		echo ($USER_MODE == 'restricted'?'disabled':'');
		echo ">protein</button>";
	}
	echo "</td>";
	// $content = file_get_contents("http://www.ensembl.org/".str_replace(' ', '_', $species)."/Info/Annotation");
	// $first_step = explode( '<table class="autocenter ss" style="width: 100%" cellpadding="0" cellspacing="0">' , $content );
	// $second_step = explode("</table>" , $first_step[1] );
	// $second_step = strip_tags($second_step);
	// echo "<td>$second_step[1]</td>";
	echo "<td>$desc</td>";
	echo "	<td><a href='http://www.ensembl.org/$species/Info/Annotation' target='_blank'><img src='/img/link.svg' style='margin-left:5px;margin-bottom: 2px;height: 20px;'></a></td>";
	echo "</tr>";
	// break;
}
echo "</table>";
?>
</div>