<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/config_file.php");
?>

<script src="/admin/js/import_reference.js?v=6517515356" xmlns:right></script>

<?php
$disabled_status = "";
if (USER_MODE == "restricted") {
    $disabled_status = "disabled";
}
?>

<?php
$request = "SELECT name, version, species FROM reference WHERE status = 'complete' ";
$results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
$blast_db_array = array();
while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
    $db_name = $row ['name'];
    if ($row ['version'] != "") {
        $db_name = $row ['name'];
    }
    array_push($blast_db_array, $db_name);
}

$request = "SELECT name, version, species FROM reference WHERE status = 'computing' ";
$results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
$computing_blast_db_array = array();
while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
    $db_name = $row ['name'];
    if ($row ['version'] != "") {
        $db_name = $row ['name'];
    }
    array_push($computing_blast_db_array, $db_name);
}
?>

<?php
$noncode_file = array();
$noncode_file ["Arabidopsis thaliana"] = 'http://www.noncode.org/datadownload/NONCODEv5_arabidopsis.fa.gz';
$noncode_file ["Bos taurus"] = 'http://www.noncode.org/datadownload/NONCODEv5_cow.fa.gz';
$noncode_file ["Caenorhabditis elegans"] = 'http://www.noncode.org/datadownload/NONCODEv5_celegans.fa.gz';
$noncode_file ["Danio rerio"] = 'http://www.noncode.org/datadownload/NONCODEv5_zebrafish.fa.gz';
$noncode_file ["Drosophila melanogaster"] = 'http://www.noncode.org/datadownload/NONCODEv5_fruitfly.fa.gz';
$noncode_file ["Gallus gallus domesticus"] = 'http://www.noncode.org/datadownload/NONCODEv5_chicken.fa.gz';
$noncode_file ["Gorilla gorilla"] = 'http://www.noncode.org/datadownload/NONCODEv5_gorilla.fa.gz';
$noncode_file ["Homo sapiens"] = 'http://www.noncode.org/datadownload/NONCODEv5_human.fa.gz';
$noncode_file ["Monodelphis domestica"] = 'http://www.noncode.org/datadownload/NONCODEv5_opossum.fa.gz';
$noncode_file ["Mus musculus"] = 'http://www.noncode.org/datadownload/NONCODEv5_mouse.fa.gz';
$noncode_file ["Pan troglodytes"] = 'http://www.noncode.org/datadownload/NONCODEv5_chimp.fa.gz';
$noncode_file ["Pongo abelii"] = 'http://www.noncode.org/datadownload/NONCODEv5_orangutan.fa.gz';
$noncode_file ["Ornithorhynchus anatinus"] = 'http://www.noncode.org/datadownload/NONCODEv5_platypus.fa.gz';
$noncode_file ["Rattus norvegicus"] = 'http://www.noncode.org/datadownload/NONCODEv5_rat.fa.gz';
$noncode_file ["Rhesus macaque"] = 'http://www.noncode.org/datadownload/NONCODEv5_rhesus.fa.gz';
$noncode_file ["Saccharomyces cerevisiae"] = 'http://www.noncode.org/datadownload/NONCODEv5_yeast.fa.gz';
$noncode_file ["Sus scrofa"] = 'http://www.noncode.org/datadownload/NONCODEv5_pig.fa.gz';

$noncode_external_link = array();
$noncode_external_link ["Arabidopsis thaliana"] = 'A.Thaliana';
$noncode_external_link ["Bos taurus"] = 'Cow';
$noncode_external_link ["Caenorhabditis elegans"] = 'C.Elegans';
$noncode_external_link ["Danio rerio"] = 'Zebrafish';
$noncode_external_link ["Drosophila melanogaster"] = 'D.Melanogaster';
$noncode_external_link ["Gallus gallus domesticus"] = 'Chicken';
$noncode_external_link ["Gorilla gorilla"] = 'Gorilla gorilla';
$noncode_external_link ["Homo sapiens"] = 'Human';
$noncode_external_link ["Monodelphis domestica"] = 'Monodelphis domestica';
$noncode_external_link ["Mus musculus"] = 'Mouse';
$noncode_external_link ["Ornithorhynchus anatinus"] = 'Platypus';
$noncode_external_link ["Pan troglodytes"] = 'Chimp';
$noncode_external_link ["Pongo abelii"] = 'Pongo abelii';
$noncode_external_link ["Rattus norvegicus"] = 'Rat';
$noncode_external_link ["Rhesus macaque"] = 'Rhesus macaque';
$noncode_external_link ["Saccharomyces cerevisiae"] = 'Yeast';
$noncode_external_link ["Sus scrofa"] = 'Pig';

$noncode_species = array();
$noncode_species ["Arabidopsis thaliana"] = 'Arabidopsis thaliana';
$noncode_species ["Bos taurus"] = 'Bos taurus';
$noncode_species ["Caenorhabditis elegans"] = 'Caenorhabditis elegans';
$noncode_species ["Danio rerio"] = 'Danio rerio';
$noncode_species ["Drosophila melanogaster"] = 'Drosophila melanogaster';
$noncode_species ["Gallus gallus domesticus"] = 'Gallus gallus domesticus';
$noncode_species ["Gorilla gorilla"] = 'Gorilla gorilla';
$noncode_species ["Homo sapiens"] = 'Homo sapiens';
$noncode_species ["Monodelphis domestica"] = 'Monodelphis domestica';
$noncode_species ["Mus musculus"] = 'Mus musculus';
$noncode_species ["Ornithorhynchus anatinus"] = 'Ornithorhynchus anatinus';
$noncode_species ["Pan troglodytes"] = 'Pan troglodytes';
$noncode_species ["Pongo abelii"] = 'Pongo abelii';
$noncode_species ["Rattus norvegicus"] = 'Rattus norvegicus';
$noncode_species ["Rhesus macaque"] = 'Rhesus macaque';
$noncode_species ["Saccharomyces cerevisiae"] = 'Saccharomyces cerevisiae';
$noncode_species ["Sus scrofa"] = 'Sus scrofa"';

$noncode_release = array();
$noncode_release ["Arabidopsis thaliana"] = 'tair10';
$noncode_release ["Bos taurus"] = 'bosTau6';
$noncode_release ["Caenorhabditis elegans"] = 'ce10';
$noncode_release ["Danio rerio"] = 'danRer10';
$noncode_release ["Drosophila melanogaster"] = 'dm6';
$noncode_release ["Gallus gallus domesticus"] = 'garGal4';
$noncode_release ["Gorilla gorilla"] = 'gorGor3';
$noncode_release ["Homo sapiens"] = 'hg38';
$noncode_release ["Monodelphis domestica"] = 'monDom5';
$noncode_release ["Mus musculus"] = 'mm10';
$noncode_release ["Ornithorhynchus anatinus"] = 'ornAna1';
$noncode_release ["Pan troglodytes"] = 'panTro4';
$noncode_release ["Pongo abelii"] = 'ponAbe2';
$noncode_release ["Rattus norvegicus"] = 'rn6';
$noncode_release ["Rhesus macaque"] = 'rheMac3';
$noncode_release ["Saccharomyces cerevisiae"] = 'sacCer3';
$noncode_release ["Sus scrofa"] = 'susScr3';

$noncode_desc = array();
$noncode_desc ["Arabidopsis thaliana"] = "3,763 lncRNA transcripts (3,472 lncRNA genes)";
$noncode_desc ["Bos taurus"] = "23,515 lncRNA transcripts (22,227 lncRNA genes)";
$noncode_desc ["Caenorhabditis elegans"] = "3,154 lncRNA transcripts (2,552 lncRNA genes)";
$noncode_desc ["Danio rerio"] = "4,852 lncRNA transcripts (	3,503 lncRNA genes)";
$noncode_desc ["Drosophila melanogaster"] = "42,848 lncRNA transcripts (15,543 lncRNA genes)";
$noncode_desc ["Gallus gallus domesticus"] = "12,850 lncRNA transcripts (9,527 lncRNA genes)";
$noncode_desc ["Gorilla gorilla"] = "18,539 lncRNA transcripts (15,095 lncRNA genes)";
$noncode_desc ["Homo sapiens"] = "172,216 lncRNA transcripts (96,308 lncRNA genes)";
$noncode_desc ["Monodelphis domestica"] = "27,167 lncRNA transcripts (17,795 lncRNA genes)";
$noncode_desc ["Mus musculus"] = "131,697 lncRNA transcripts (87,774 lncRNA genes)";
$noncode_desc ["Ornithorhynchus anatinus"] = "11,210 lncRNA transcripts (9,163 lncRNA genes)";
$noncode_desc ["Pan troglodytes"] = "18,004 lncRNA transcripts (12,790 lncRNA genes)";
$noncode_desc ["Pongo abelii"] = "15,178 lncRNA transcripts (13,106 lncRNA genes)";
$noncode_desc ["Rattus norvegicus"] = "24,879 lncRNA transcripts (22,127 lncRNA genes)";
$noncode_desc ["Rhesus macaque"] = "9,128 lncRNA transcripts (6,010 lncRNA genes)";
$noncode_desc ["Saccharomyces cerevisiae"] = "55 lncRNA transcripts (52 lncRNA genes)";
$noncode_desc ["Sus scrofa"] = "29,585 lncRNA transcripts (17,811 lncRNA genes)";

$uniref_name = array();
$uniref_name ["UniRef_Swiss"] = "UniRef_Swiss";
$uniref_name ["UniRef_trEMBL"] = "UniRef_trEMBL";
$uniref_name ["UniRef_100"] = "UniRef_100";
$uniref_name ["UniRef_90"] = "UniRef_90";
$uniref_name ["UniRef_50"] = "UniRef_50";

$uniref_species = array();
$uniref_species ["UniRef_Swiss"] = "multiple";
$uniref_species ["UniRef_trEMBL"] = "multiple";
$uniref_species ["UniRef_100"] = "multiple";
$uniref_species ["UniRef_90"] = "multiple";
$uniref_species ["UniRef_50"] = "multiple";

$uniref_release = array();
$uniref_release ["UniRef_Swiss"] = "2018_10";
$uniref_release ["UniRef_trEMBL"] = "2018_10";
$uniref_release ["UniRef_100"] = "2018_10";
$uniref_release ["UniRef_90"] = "2018_10";
$uniref_release ["UniRef_50"] = "2018_10";

$uniref_link = array();
$uniref_link ["UniRef_Swiss"] = "ftp://ftp.uniprot.org/pub/databases/uniprot/current_release/knowledgebase/complete/uniprot_sprot.fasta.gz";
$uniref_link ["UniRef_trEMBL"] = "ftp://ftp.uniprot.org/pub/databases/uniprot/current_release/knowledgebase/complete/uniprot_trembl.fasta.gz";
$uniref_link ["UniRef_100"] = "ftp://ftp.uniprot.org/pub/databases/uniprot/uniref/uniref100/uniref100.fasta.gz";
$uniref_link ["UniRef_90"] = "ftp://ftp.uniprot.org/pub/databases/uniprot/uniref/uniref90/uniref90.fasta.gz";
$uniref_link ["UniRef_50"] = "ftp://ftp.uniprot.org/pub/databases/uniprot/uniref/uniref50/uniref50.fasta.gz";

$uniref_description = array();
$uniref_description ["UniRef_Swiss"] = "Dataset of 558,681 protein sequences. Manually annotated and reviewed";
$uniref_description ["UniRef_trEMBL"] = "Dataset of 133,507,323 protein sequences. Automatically annotated and not reviewed.";
$uniref_description ["UniRef_100"] = "Dataset of 164,828,188 protein sequences. Clusters of identical sequences and subfragments with 11 or more residues across multiple datasets.";
$uniref_description ["UniRef_90"] = "Dataset of 83,681,116 proteins sequences. Clusters of sequences having at least a sequence identity of 90% and an overlap with the longest sequence in the cluster of 80% across multiple datasets.";
$uniref_description ["UniRef_50"] = "Dataset of 31,036,088 protein sequences. Clusters of sequences having at least a sequence identity of 50% and an overlap with the longest sequence in the cluster of 80% across multiple datasets.";

$ensembl_release = 94;
$ensembl_desc = array();
$ensembl_desc ["ailuropoda melanoleuca"] = "19,343 coding and 3,141 non-coding RNAs";
$ensembl_desc ["anas platyrhynchos"] = "15,634 coding and 567 non-coding RNAs";
$ensembl_desc ["anolis carolinensis"] = "18,595 coding and 7,168 non-coding RNAs";
$ensembl_desc ["astyanax mexicanus"] = "23,042 coding and 2,208 non-coding RNAs";
$ensembl_desc ["bos taurus"] = "19,994 coding and 3,825 non-coding RNAs";
$ensembl_desc ["caenorhabditis elegans"] = "20,362 coding and 24,719 non-coding RNAs";
$ensembl_desc ["callithrix jacchus"] = "20,978 coding and 9,000 non-coding RNAs";
$ensembl_desc ["canis familiaris"] = "19,856 coding and 11,898 non-coding RNAs";
$ensembl_desc ["cavia porcellus"] = "18,673 coding and 5,963 non-coding RNAs";
$ensembl_desc ["chlorocebus sabaeus"] = "19,165 coding and 8,245 non-coding RNAs";
$ensembl_desc ["choloepus hoffmanni"] = "12,393 coding and 2,030 non-coding RNAs";
$ensembl_desc ["ciona intestinalis"] = "16,671 coding and 455 non-coding RNAs";
$ensembl_desc ["ciona savignyi"] = "11,616 coding and 340 non-coding RNAs";
$ensembl_desc ["danio rerio"] = "25,832 coding and 6,060 non-coding RNAs";
$ensembl_desc ["dasypus novemcinctus"] = "22,711 coding and 9,163 non-coding RNAs";
$ensembl_desc ["dipodomys ordii"] = "15,798 coding and 3,036 non-coding RNAs";
$ensembl_desc ["drosophila melanogaster"] = "13,918 coding and 3,384 non-coding RNAs";
$ensembl_desc ["echinops telfairi"] = "16,575 coding and 5,680 non-coding RNAs";
$ensembl_desc ["equus caballus"] = "20,449 coding and 2,142 non-coding RNAs";
$ensembl_desc ["erinaceus europaeus"] = "14,601 coding and 6,456 non-coding RNAs";
$ensembl_desc ["felis catus"] = "19,493 coding and 1,855 non-coding RNAs";
$ensembl_desc ["ficedula albicollis"] = "15,303 coding and 6,539 non-coding RNAs";
$ensembl_desc ["gadus morhua"] = "20,095 coding and 1,541 non-coding RNAs";
$ensembl_desc ["gallus gallus"] = "18,346 coding and 6,492 non-coding RNAs";
$ensembl_desc ["gasterosteus aculeatus"] = "20,787 coding and 1,617 non-coding RNAs";
$ensembl_desc ["gorilla gorilla"] = "20,962 coding and 6,701 non-coding RNAs";
$ensembl_desc ["homo sapiens"] = "20,310 coding and 22,529 non-coding RNAs";
$ensembl_desc ["ictidomys tridecemlineatus"] = "18,826 coding and 3,166 non-coding RNAs";
$ensembl_desc ["latimeria chalumnae"] = "19,569 coding and 2,918 non-coding RNAs";
$ensembl_desc ["lepisosteus oculatus"] = "18,341 coding and 4,932 non-coding RNAs";
$ensembl_desc ["loxodonta africana"] = "20,033 coding and 2,644 non-coding RNAs";
$ensembl_desc ["macaca mulatta"] = "21,099 coding and 11,001 non-coding RNAs";
$ensembl_desc ["meleagris gallopavo"] = "14,123 coding and 755 non-coding RNAs";
$ensembl_desc ["microcebus murinus"] = "18,103 coding and 10,226 non-coding RNAs";
$ensembl_desc ["monodelphis domestica"] = "21,327 coding and 8,320 non-coding RNAs";
$ensembl_desc ["mus musculus"] = "22,615 coding and 14,299 non-coding RNAs";
$ensembl_desc ["myotis lucifugus"] = "19,728 coding and 4,408 non-coding RNAs";
$ensembl_desc ["nomascus leucogenys"] = "18,575 coding and 7,172 non-coding RNAs";
$ensembl_desc ["notamacropus eugenii"] = "15,290 coding and 1,472 non-coding RNAs";
$ensembl_desc ["ochotona princeps"] = "16,006 coding and 5,732 non-coding RNAs";
$ensembl_desc ["oreochromis niloticus"] = "21,437 coding and 5,626 non-coding RNAs";
$ensembl_desc ["ornithorhynchus anatinus"] = "21,698 coding and 7,531 non-coding RNAs";
$ensembl_desc ["oryctolagus cuniculus"] = "19,293 coding and 3,375 non-coding RNAs";
$ensembl_desc ["oryzias latipes"] = "19,699 coding and 759 non-coding RNAs";
$ensembl_desc ["otolemur garnettii"] = "19,506 coding and 7,276 non-coding RNAs";
$ensembl_desc ["ovis aries"] = "20,921 coding and 5,843 non-coding RNAs";
$ensembl_desc ["pan troglodytes"] = "18,759 coding and 8,681 non-coding RNAs";
$ensembl_desc ["papio anubis"] = "19,210 coding and 9,272 non-coding RNAs";
$ensembl_desc ["pelodiscus sinensis"] = "18,189 coding and 1,042 non-coding RNAs";
$ensembl_desc ["petromyzon marinus"] = "10,415 coding and 2,652 non-coding RNAs";
$ensembl_desc ["poecilia formosa"] = "23,615 coding and 679 non-coding RNAs";
$ensembl_desc ["pongo abelii"] = "20,424 coding and 6,996 non-coding RNAs";
$ensembl_desc ["procavia capensis"] = "16,057 coding and 1,720 non-coding RNAs";
$ensembl_desc ["pteropus vampyrus"] = "16,990 coding and 4,171 non-coding RNAs";
$ensembl_desc ["rattus norvegicus"] = "22,250 coding and 8,934 non-coding RNAs";
$ensembl_desc ["saccharomyces cerevisiae"] = "6,692 coding and 413 non-coding RNAs";
$ensembl_desc ["sarcophilus harrisii"] = "18,788 coding and 1,490 non-coding RNAs";
$ensembl_desc ["sorex araneus"] = "13,187 coding and 4,558 non-coding RNAs";
$ensembl_desc ["sus scrofa"] = "21,630 coding and 3,124 non-coding RNAs";
$ensembl_desc ["taeniopygia guttata"] = "17,488 coding and 724 non-coding RNAs";
$ensembl_desc ["takifugu rubripes"] = "18,523 coding and 703 non-coding RNAs";
$ensembl_desc ["tetraodon nigroviridis"] = "19,602 coding and 813 non-coding RNAs";
$ensembl_desc ["tupaia belangeri"] = "15,471 coding and 3,073 non-coding RNAs";
$ensembl_desc ["tursiops truncatus"] = "16,550 coding and 3,790 non-coding RNAs";
$ensembl_desc ["vicugna pacos"] = "11,765 coding and 2,532 non-coding RNAs";
$ensembl_desc ["xenopus tropicalis"] = "18,442 coding and 1,306 non-coding RNAs";
$ensembl_desc ["xiphophorus maculatus"] = "20,379 coding and 372 non-coding RNAs";
?>

<label type=title>Import publicly available reference datasets</label>
<p style='text-align: justify; text-justify: inter-word;'>Transcriptomic and proteomic datasets publicly available from
    the NONCODE, UniRef, and Ensembl databases can be imported in Genotate to be used as homology references.
    For each dataset, the number of available sequences, the dataset description, and a link to the reference databases
    are provided. Datasets can be imported using the import buttons.</p>
<br>
<div class="div-border-title">
    NONCODE datasets (v 5.0)
    <a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="/index.php?page=tutorial"
       target="_blank" title="<?php echo $tooltip_text['NONCODE']; ?>">
        <img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
</div>
<div class="div-border" style="width:100%;margin-bottom:10px;">
    <table style='width: 100%;' class='manage_tables'>
        <thead>
        <tr>
            <td style='width: 35%;'>dataset</td>
            <td style='width: 5%;text-align:center;'>import</td>
            <td style='width: 55%;'>description</td>
            <td style='width: 5%;text-align:center;'>link</td>
        </tr>
        </thead>
        <?php
        foreach ($noncode_external_link as $species => $name) {
            echo "<form id='form_$species' action='http://www.noncode.org/browse.php' method='post' target='_blank'><input type='hidden' name='org' value='$name'></form>";
        }
        foreach ($noncode_desc as $species => $desc) {
            $file = $noncode_file [$species];
            $release = $noncode_release [$species];
            echo "<tr>";
            $dbname = "NONCODE_" . str_replace(" ", "_", strtolower($species));
            echo "<td>$dbname</td>";
            if (in_array($dbname, $blast_db_array)) {
                echo "	<td><button class='btn btn-success btn-sm' id='$dbname' ".$disabled_status.">ncRNA</button></td>";
            } else if (in_array($dbname, $computing_blast_db_array)) {
                echo "	<td><button class='btn btn-warning btn-sm' id='$dbname' ".$disabled_status.">ncRNA</button></td>";
            } else {
                echo "	<td><button class='btn btn-primary btn-sm' id='$dbname' onclick=\"synchronize_noncode('$dbname','$species','$release','$desc','$file');\" form='' ".$disabled_status.">ncRNA</button></td>";
            }
            echo "	<td>$desc</td>";
            echo "	<td><button class='btn btn-link btn-sm' type='submit' form='form_$species' style='width:30px;height:30px;padding:5px;' ";
            echo "><img src='/img/link.svg' style='margin-left:5px;margin-bottom: 2px;height: 20px;'></button></td>";
            echo "</tr>";

        }
        ?>
    </table>
</div>

<div class="div-border-title">
    UniRef datasets (release 2018_10)
    <a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="/index.php?page=tutorial"
       target="_blank" title="<?php echo $tooltip_text['UNIREF']; ?>">
        <img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
</div>
<div class="div-border" style="width:100%;margin-bottom:10px;">
    <table style='width: 100%;' class='manage_tables'>
        <thead>
        <tr>
            <td style='width: 35%;'>dataset</td>
            <td style='width: 6%;text-align:center;'>import</td>
            <td style='width: 54%;'>description</td>
            <td style='width: 5%;text-align:center;'>link</td>
        </tr>
        </thead>
        <tr>
            <td>UniRef_SwissProt</td>
            <?php
            if (in_array("UniRef_Swiss-Prot", $blast_db_array)) {
                echo "	<td><button class='btn btn-success btn-sm' id='UniRef_Swiss-Prot' form='' ".$disabled_status.">protein</button></td>";
            } else if (in_array("UniRef_Swiss-Prot", $computing_blast_db_array)) {
                echo "	<td><button class='btn btn-warning btn-sm' id='UniRef_Swiss-Prot' form='' ".$disabled_status.">protein</button></td>";
            } else {
                echo "	<td><button class='btn btn-primary btn-sm' id='UniRef_Swiss-Prot' onclick=\"synchronize_uniref('UniRef_Swiss-Prot','" . $uniref_species ["UniRef_Swiss"] . "','" . $uniref_release["UniRef_Swiss"] . "','" . $uniref_description ["UniRef_Swiss"] . "','" . $uniref_link ["UniRef_Swiss"] . "');\" form='' ".$disabled_status.">protein</button></td>";
            }
            ?>
            <td>Dataset of 558,681 protein sequences.<br>
                Manually annotated and reviewed
            </td>
            <td><a href='http://www.uniprot.org/downloads' target='_blank'><img src='/img/link.svg' style='margin-left:5px;margin-bottom: 2px;height: 20px;'></a>
            </td>
        </tr>

        <tr>
            <td>UniRef_trEMBL</td>
            <?php
            if (in_array("UniRef_trEMBL", $blast_db_array)) {
                echo "	<td><button class='btn btn-success btn-sm' id='UniRef_trEMBL' form='' ".$disabled_status.">protein</button></td>";
            } else if (in_array("UniRef_trEMBL", $computing_blast_db_array)) {
                echo "	<td><button class='btn btn-warning btn-sm' id='UniRef_trEMBL' form='' ".$disabled_status.">protein</button></td>";
            } else {
                echo "	<td><button class='btn btn-primary btn-sm' id='UniRef_trEMBL' onclick=\"synchronize_uniref('UniRef_trEMBL','" . $uniref_species ["UniRef_trEMBL"] . "','" . $uniref_release["UniRef_trEMBL"] . "','" . $uniref_description ["UniRef_trEMBL"] . "','" . $uniref_link ["UniRef_trEMBL"] . "');\" form='' ".$disabled_status.">protein</button></td>";
            }
            ?>
            <td>Dataset of 133,507,323 protein sequences.<br>
                Automatically annotated and not reviewed.
            </td>
            <td><a href='http://www.uniprot.org/downloads' target='_blank'><img src='/img/link.svg'
                                                                                style='margin-left:5px;margin-bottom: 2px;height: 20px;'></a>
            </td>
        </tr>


        <tr>
            <td>UniRef_100</td>
            <?php
            if (in_array("UniRef_100", $blast_db_array)) {
                echo "	<td><button class='btn btn-success btn-sm' id='UniRef_100' form='' ".$disabled_status.">protein</button></td>";
            } else if (in_array("UniRef_100", $computing_blast_db_array)) {
                echo "	<td><button class='btn btn-warning btn-sm' id='UniRef_100' form='' ".$disabled_status.">protein</button></td>";
            } else {
                echo "	<td><button class='btn btn-primary btn-sm' id='UniRef_100' onclick=\"synchronize_uniref('UniRef_100','" . $uniref_species ["UniRef_100"] . "','" . $uniref_release["UniRef_100"] . "','" . $uniref_description ["UniRef_100"] . "','" . $uniref_link ["UniRef_100"] . "');\" form='' ".$disabled_status.">protein</button></td>";
            }
            ?>
            <td>Dataset of 164,828,188 protein sequences.<br>
                Clusters of identical sequences and subfragments with 11 or more residues across multiple datasets.
            </td>
            <td><a href='http://www.uniprot.org/downloads' target='_blank'><img src='/img/link.svg'
                                                                                style='margin-left:5px;margin-bottom: 2px;height: 20px;'></a>
            </td>
        </tr>

        <tr>
            <td>UniRef_90</td>
            <?php
            if (in_array("UniRef_90", $blast_db_array)) {
                echo "	<td><button class='btn btn-success btn-sm' id='UniRef_90' form='' $disabled_status>protein</button></td>";
            } else if (in_array("UniRef_90", $computing_blast_db_array)) {
                echo "	<td><button class='btn btn-warning btn-sm' id='UniRef_90' form='' $disabled_status>protein</button></td>";
            } else {
                echo "	<td><button class='btn btn-primary btn-sm' id='UniRef_90' onclick=\"synchronize_uniref('UniRef_90','" . $uniref_species ["UniRef_90"] . "','" . $uniref_release["UniRef_90"] . "','" . $uniref_description ["UniRef_90"] . "','" . $uniref_link ["UniRef_90"] . "');\" form='' $disabled_status>protein</button></td>";
            }
            ?>
            <td>Dataset of 83,681,116 proteins sequences.<br>
                Clusters of sequences having at least a sequence identity of 90% and an overlap with the longest
                sequence in the cluster of 80% across multiple datasets.
            </td>
            <td><a href='http://www.uniprot.org/downloads' target='_blank'><img src='/img/link.svg'
                                                                                style='margin-left:5px;margin-bottom: 2px;height: 20px;'></a>
            </td>
        </tr>


        <tr>
            <td>UniRef_50</td>
            <?php
            if (in_array("UniRef_50", $blast_db_array)) {
                echo "	<td><button class='btn btn-success btn-sm' id='UniRef_50' form='' ".$disabled_status.">protein</button></td>";
            } else if (in_array("UniRef_50", $computing_blast_db_array)) {
                echo "	<td><button class='btn btn-warning btn-sm' id='UniRef_50' form='' ".$disabled_status.">protein</button></td>";
            } else {
                echo "	<td><button class='btn btn-primary btn-sm' id='UniRef_50' onclick=\"synchronize_uniref('UniRef_50','" . $uniref_species ["UniRef_50"] . "','" . $uniref_release["UniRef_50"] . "','" . $uniref_description ["UniRef_50"] . "','" . $uniref_link ["UniRef_50"] . "');\" form='' ".$disabled_status.">protein</button></td>";
            }
            ?>
            <td>Dataset of 31,036,088 protein sequences.<br>
                Clusters of sequences having at least a sequence identity of 50% and an overlap with the longest
                sequence in the cluster of 80% across multiple datasets.
            </td>
            <td><a href='http://www.uniprot.org/downloads' target='_blank'><img src='/img/link.svg' style='margin-left:5px;margin-bottom: 2px;height: 20px;'></a>
            </td>
        </tr>
    </table>
</div>

<div class="div-border-title">
    Ensembl datasets (Release 94)
    <a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top" href="../index.php" target="_blank" title="<?php echo $tooltip_text['ENSEMBL']; ?>"><img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
</div>
<div class="div-border" style="width:100%;margin-bottom:10px;">
    <form id='form_db' name='form_db' action="" method="post"></form>
    <table class='manage_tables' id='table' style='width: 100%;'>
        <thead>
        <tr>
            <td style='width: 35%;'>dataset</td>
            <td style='width: 22%;text-align:center;'>import</td>
            <td style='width: 35%;'>description</td>
            <td style='width: 5%;text-align:center;'>link</td>
        </tr>
        </thead>
        <?php
        foreach ($ensembl_desc as $species => $desc) {
            echo "<tr>";
            $dbname = "ENSEMBL_" . str_replace(" ", "_", $species);
            echo "<td>$dbname</td>";
            echo "<td>";
            $sequence_type = "cdna";
            $dbname_type = $dbname . "_" . $ensembl_release . "_" . $sequence_type;
            if (in_array($dbname_type, $blast_db_array)) {
                echo "<button id='$ensembl_release$species$sequence_type' class='btn btn-success btn-sm' style='margin:3px;' $disabled_status>cDNA</button>";
            } else if (in_array($dbname_type, $computing_blast_db_array)) {
                echo "<button id='$ensembl_release$species$sequence_type' class='btn btn-warning btn-sm' style='margin:3px;' $disabled_status>cDNA</button>";
            } else {
                echo "<button id='$ensembl_release$species$sequence_type' class='btn btn-primary btn-sm' style='margin:3px;' onclick=\"synchronize_ensembl('$dbname_type', '$ensembl_release', '$species', 'nucleic', '$sequence_type','$desc')\" $disabled_status>cDNA</button>";
            }
            $sequence_type = "cds";
            $dbname_type = $dbname . "_" . $ensembl_release . "_" . $sequence_type;
            if (in_array($dbname_type, $blast_db_array)) {
                echo "<button id='$ensembl_release$species$sequence_type' class='btn btn-success btn-sm' style='margin:3px;' $disabled_status>CDS</button>";
            } else if (in_array($dbname_type, $computing_blast_db_array)) {
                echo "<button id='$ensembl_release$species$sequence_type' class='btn btn-warning btn-sm' style='margin:3px;' $disabled_status>CDS</button>";
            } else {
                echo "<button id='$ensembl_release$species$sequence_type' class='btn btn-primary btn-sm' style='margin:3px;' onclick=\"synchronize_ensembl('$dbname_type', '$ensembl_release', '$species', 'nucleic', '$sequence_type','$desc')\" $disabled_status>CDS</button>";
            }
            $sequence_type = "pep";
            $dbname_type = $dbname . "_" . $ensembl_release . "_" . $sequence_type;
            if (in_array($dbname_type, $blast_db_array)) {
                echo "<button id='$ensembl_release$species$sequence_type' class='btn btn-success btn-sm' style='margin:3px;' $disabled_status>protein</button>";
            } else if (in_array($dbname_type, $computing_blast_db_array)) {
                echo "<button id='$ensembl_release$species$sequence_type' class='btn btn-warning btn-sm' style='margin:3px;' $disabled_status>protein</button>";
            } else {
                echo "<button id='$ensembl_release$species$sequence_type' class='btn btn-primary btn-sm' style='margin:3px;' onclick=\"synchronize_ensembl('$dbname_type', '$ensembl_release', '$species', 'proteic', '$sequence_type','$desc')\" $disabled_status>protein</button>";
            }
            $sequence_type = "ncrna";
            $dbname_type = $dbname . "_" . $ensembl_release . "_" . $sequence_type;
            if (in_array($dbname_type, $blast_db_array)) {
                echo "<button id='$ensembl_release$species$sequence_type' class='btn btn-success btn-sm' style='margin:3px;' $disabled_status>ncRNA</button>";
            } else if (in_array($dbname_type, $computing_blast_db_array)) {
                echo "<button id='$ensembl_release$species$sequence_type' class='btn btn-warning btn-sm' style='margin:3px;' $disabled_status>ncRNA</button>";
            } else {
                echo "<button id='$ensembl_release$species$sequence_type' class='btn btn-primary btn-sm' style='margin:3px;' onclick=\"synchronize_ensembl('$dbname_type', '$ensembl_release', '$species', 'nucleic', '$sequence_type','$desc')\" $disabled_status >ncRNA</button>";
            }
            echo "</td>";
            echo "<td>$desc</td>";
            echo "	<td><a href='http://www.ensembl.org/$species/Info/Annotation' target='_blank'><img src='/img/link.svg' style='margin-left:5px;margin-bottom: 2px;height: 20px;'></a></td>";
            echo "</tr>";

        }
        echo "</table>";
        ?>
</div>

<script>
    document.title = "Genotate.life - Admin - Import homology references";
</script>
