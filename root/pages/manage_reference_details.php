<?php

$analysis_id = $_GET ['analysis_id'];

$request = "SELECT * FROM reference WHERE reference_id='$analysis_id' ORDER BY name";
$results = mysqli_query($connexion, $request) or die ("SQL Error:<br>$request<br>" . mysqli_error($connexion));
$row = mysqli_fetch_array($results, MYSQLI_ASSOC);

if ($row == null) {
    echo '<div class="alert alert-warning" style="width:100%">';
    echo "Unknown dataset id";
    echo '</div>';
    return;
}
?>

<div class="div-border-title" style='margin-top:10px;'>
    Homology reference informations <a style='float: right;margin-right: 10px;' data-toggle="tooltip"
                                       data-placement="top" href="/index.php?page=tutorial" target="_blank"
                                       title="<?php echo $tooltip_text['reference_details']; ?>"> <img
                src="/img/tutorial.svg" style='margin-bottom: 2px; height: 20px; filter: invert(90%);'></a>
</div>
<div class="div-border" style="margin-bottom: 10px;">
    <div style="width: 100%; padding: 5px;">
        <div class="form-group" style="width: 100%;">
            <label for='reference_id'>reference id</label>
            <input readonly type="text" title="name" id="reference_id" name="reference_id"
                   value="<?php echo $row['reference_id']; ?>"
                   style="width: 100%; height: 2em; text-align: left;background-color:rgba(229,229,229, 0.2);">
        </div>
        <div class="form-group" style="width: 100%;">
            <label for='name'>reference name</label>
            <input readonly type="text" title="name" id="name" name="name" value="<?php echo $row['name']; ?>"
                   style="width: 100%; height: 2em; text-align: left;background-color:rgba(229,229,229, 0.2);">
        </div>
        <div style="width: 100%;">
            <label for='creation_date'>creation date</label>
            <input readonly type="text" title="creation_date" value="<?php echo $row['creation_date']; ?>"
                   style="width: 100%; height: 2em; text-align: left;background-color:rgba(229,229,229, 0.2);">
        </div>
        <div class="form-group" style="width: 100%;">
            <label for='type'>type</label>
            <input readonly type="text" id="type" name="type" value="<?php echo $row['type']; ?>"
                   style="width: 100%; height: 2em; text-align: left;background-color:rgba(229,229,229, 0.2);">
        </div>
        <div class="form-group" style="width: 100%;">
            <label for='species'>species</label>
            <input readonly type="text" id="species" name="species" value="<?php echo $row['species']; ?>"
                   style="width: 100%; height: 2em; text-align: left;background-color:rgba(229,229,229, 0.2);">
        </div>
        <div class="form-group" style="width: 100%;">
            <label for='version'>release version</label>
            <input readonly type="text" id="version" name="version" value="<?php echo $row['version']; ?>"
                   style="width: 100%; height: 2em; text-align: left;background-color:rgba(229,229,229, 0.2);">
        </div>
        <div class="form-group" style="width: 100%;">
            <label for='description'>description</label>
            <textarea readonly id="description" name="description"
                      style="width: 100%; height: 7em; text-align: left; resize: none;background-color:rgba(229,229,229, 0.2);"><?php echo $row['description']; ?></textarea>
        </div>
    </div>
</div>

<script>
    document.title = "Genotate.life - Admin - Manage reference details";
</script>
