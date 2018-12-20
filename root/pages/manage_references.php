<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/config_file.php");
?>

<script src="/root/js/manage_references.js?v=612656" xmlns:right></script>

<?php
$disabled_status = "";
if (USER_MODE == "restricted") {
    $disabled_status = "disabled";
}
?>

<label type=title>Manage homology references</label>
<p style='text-align: justify; text-justify: inter-word;'>Homology annotations management interface lists the reference
    database with their computation current status, information, sequences, and the possibility to rename or delete them.
    The details can be displayed with the release, the species, the
    sequence type, and the description.</p>
<br>

<div class="div-border-title">
    Homology references <a style='float: right; margin-right: 10px;' data-toggle="tooltip" data-placement="top"
                           href="/index.php?page=tutorial" target="_blank"
                           title="<?php echo $tooltip_text['manage_references']; ?>"> <img src="/img/tutorial.svg"
                                                                                           style='margin-bottom: 2px; height: 20px; filter: invert(90%);'></a>
</div>
<div class="div-border">

    <table class='manage_tables' style='width: 100%;'>
        <thead>
        <tr>
            <td>dataset name</td>
            <td style='width:10%;text-align:center;'>type</td>
            <td style='width:10%;text-align:center;'>number of sequences</td>
            <td style='width:190px;text-align:center;'>possible actions</td>
            <td style='width:10%;text-align:center;'>status</td>
        </tr>
        </thead>

        <?php
        $request = "SELECT * FROM reference ORDER BY name";
        $results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
        while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
            $analysis_id = $row ['reference_id'];
            $name = $row ['name'];
            $dl_name =  $name.".fasta";
            $file_name = $analysis_id . ".fasta";
            $type = $row['type'];
            $size = $row ['size'];
            $state = $row ['status'];
            echo "<form name='fasta_$analysis_id' id='fasta_$analysis_id' action='/root/includes/download_files.php' method='post' target=\"_blank\">";
            echo "<input type='hidden' name='file_name' value='$dl_name'>";
            echo "<input type='hidden' name='analysis_id' value='$file_name'>";
            echo "<input type='hidden' name='type' value='reference'>";
            echo "</form>";
            echo "<tr>";
            echo "<td style='word-break: break-all;'>{$name}</td>";
            echo "<td style='text-align:center;'>{$type}</td>";
            echo "<td style='text-align:right'>" . number_format($size, 0, '.', ',') . "</td>";
            echo "<td>";
            if ($row ['status'] == "computing") {
                echo "<button style='width:90px;' class='btn btn-md btn-primary' form=\"fasta_$analysis_id\" disabled>download</button>";
            }else{
                echo "<button style='width:90px;' class='btn btn-md btn-primary' form=\"fasta_$analysis_id\">download</button>";
            }
            echo "<a href='/root/index.php?page=manage_reference_details&analysis_id=$analysis_id'><button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='get details about the homology reference dataset' class='btn btn-md btn-primary'>";
            echo "<span class='glyphicon glyphicon-question-sign' aria-hidden='true'></span></button></a>";
            if ($row ['status'] == "computing") {
                echo "<button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='rename the homology reference dataset' class='btn btn-md btn-primary' onclick='rename_reference_dataset($analysis_id)' disabled><span class='glyphicon glyphicon-pencil'></span></button></a>";
            }else{
                echo "<button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='rename the homology reference dataset' class='btn btn-md btn-primary' onclick='rename_reference_dataset($analysis_id)' $disabled_status><span class='glyphicon glyphicon-pencil'></span></button></a>";
            }

            if ($row ['status'] == "computing") {
                echo "<button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='delete the homology reference dataset' class='btn btn-md btn-danger' onclick='delete_reference_dataset($analysis_id)' $disabled_status><span class='glyphicon glyphicon-off'></span></button></a>";
            }else{
                echo "<button style='width:30px;height:30px;padding:5px;' data-toggle='tooltip' data-placement='top' title='delete the homology reference dataset' class='btn btn-md btn-danger' onclick='delete_reference_dataset($analysis_id)' $disabled_status><span class='glyphicon glyphicon-remove'></span></button></a>";
            }

            echo "</td>";
            echo "<td style='text-align:right;'>";
            if ($state != "complete") {
                echo "<div class='progress' style='margin:0;padding:0;height:30px;width: 100%;'>";
                echo "<div class='progress-bar progress-bar-striped bg-info' role='progressbar' style='padding:5px;width: 0;' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'>0%</div>";
                echo "</div>";
            } else {
                echo "<div class='progress' style='margin:0;padding:0;height:30px;width: 100%;'>";
                echo "<div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='padding:5px;width: 100%;' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>100%</div>";
                echo "</div>";
            }
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>

</div>

<script>
    document.title = "Genotate.life - Admin - Manage homology references";
</script>
