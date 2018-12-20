<script src="/admin/js/create_reference.js" xmlns:right></script>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/includes/get_dbnames.php");
?>

<?php
$disabled_status = "";
if (USER_MODE == "restricted") {
    $disabled_status = "disabled";
}
?>


<label type=title>Create an homology reference</label>
<p style='text-align: justify; text-justify: inter-word;'>Homology annotation reference datasets can be created using
    this interface. Homology annotation reference dataset can be defined at the nucleic or proteic level by providing
    either a fasta file or a link to a fasta file.</p>
<form action="" enctype="multipart/form-data" id="form" name="form" method="post" onsubmit="return checkEntries();">
    <div class="div-border-title">
        Homology reference information
        <label data-toggle='buttons' class='btn btn-default btn-sm' for='debug' style='display: none;'><input
                    type='checkbox' id='debug' name='debug' style='display: none;'>debug</label>
        <a style='float: right; margin-right: 10px;' data-toggle="tooltip" data-placement="top" href="../index.php"
           target="_blank" title="<?php echo $tooltip_text['create_reference']; ?>"> <img src="/img/tutorial.svg"
                                                                                          style='margin-bottom: 2px; height: 20px; filter: invert(90%);'></a>
    </div>
    <div class="div-border">

        <?php
        get_blast_db($connexion);
        ?>

        <div style='width: 50%; padding: 5px; margin: 0;'>
            <input class="btn btn-default" data-toggle="tooltip" data-placement="top"
                   title="<?php echo $tooltip_text['reference_file']; ?>" type="button" id="file_button"
                   value="Select a fasta file" onclick="document.getElementById('file').click();"
                   style="border: 1px solid black; font-size: 16px; height: 55px;width: 100%;">
            <input type="file" style="display: none;" id="file" name="file" value="" ACCEPT=".fasta,.fa"
                   onchange="getFileName()">
            <input data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['reference_ftp']; ?>"
                   type="text" id="ftp_input" name="ftp" value="" placeholder="FTP link" onchange="onchange_ftp();"
                   style="width: 100%; height: 45px;margin-top:5px;margin-bottom:5px; text-align: left; border: 1px solid black; display: none;">
            <div class="btn-group" data-toggle="buttons" style="width: 100%; margin-top: 5px; margin-bottom: 5px;">
                <label id='file_label' style="width: 50%;" onclick="handleClick(this);" class="btn btn-default active"
                       data-toggle="tooltip" data-placement="top"
                       title="<?php echo $tooltip_text['create_reference_file']; ?>">
                    file
                    <input id='file_radio' value='file' type='radio' name='upload_type' style='display: none' checked>
                </label>
                <label id='ftp_label' style="width: 50%;" onclick="handleClick(this);" class="btn btn-default"
                       data-toggle="tooltip" data-placement="top"
                       title="<?php echo $tooltip_text['create_reference_link']; ?>">
                    FTP link
                    <input id='ftp_radio' value='ftp' type='radio' name='upload_type' style='display: none'>
                </label>
            </div>
            <div class="btn-group" data-toggle="buttons" style="width: 100%; margin-bottom: 5px;">
                <label style="width: 50%" class="btn btn-default active" data-toggle="tooltip" data-placement="top"
                       title="<?php echo $tooltip_text['create_reference_nucleic']; ?>">
                    nucleic
                    <input id='nucleic' value='nucleic' type='radio' name='type' style='display: none' checked>
                </label>
                <label style="width: 50%;" class="btn btn-default" data-toggle="tooltip" data-placement="top"
                       title="<?php echo $tooltip_text['create_reference_proteic']; ?>">
                    proteic
                    <input class="btn btn-default" id='proteic' value='proteic' type='radio' name='type'>
                </label>
            </div>
            <div style="width: 100%;">
                <label for='db_name'>reference name</label>
                <input data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['reference_name']; ?>"
                       type="text" id="db_name" name="db_name" value="" onchange='checkName()'
                       style="width: 100%; height: 2em; text-align: left;">
            </div>
            <div class="form-group" style="width: 100%;">
                <label for='email'>email notification</label>
                <input data-toggle="tooltip" data-placement="top"
                       title="<?php echo $tooltip_text['reference_email']; ?>" type="text" id="email" name="email"
                       value="" onchange='check_email()' style="width: 100%; height: 2em; text-align: left;">
            </div>
        </div>
        <div style='width: 50%; padding: 5px; margin: 0;'>
            <div style="width: 100%;">
                <label for='species'>species</label>
                <input data-toggle="tooltip" data-placement="top"
                       title="<?php echo $tooltip_text['reference_species']; ?>" type="text" id="species" name="species"
                       value="" style="width: 100%; height: 2em; text-align: left;">
            </div>
            <div style="width: 100%;">
                <label for='species'>release</label>
                <input data-toggle="tooltip" data-placement="top"
                       title="<?php echo $tooltip_text['reference_release']; ?>" type="text" id="release" name="release"
                       value="" style="width: 100%; height: 2em; text-align: left;">
            </div>
            <div class="form-group" style="width: 100%;">
                <label for='description'>description</label>
                <textarea data-toggle="tooltip" data-placement="top"
                          title="<?php echo $tooltip_text['reference_description']; ?>" id="description"
                          name="description"
                          style="width: 100%; height: 105px; text-align: left; resize: none;"></textarea>
            </div>
        </div>
    </div>
</form>
<button name="button" onclick="upload_reference()" style="margin-top: 5px; width: 100%; font-size: 1.3em;"
        class="btn btn-secondary active" <?php echo $disabled_status; ?> >Create homology
    reference dataset
</button>

<div class='progress' style='margin: 0; padding: 0; height: 30px;width:100%;'>
    <div class='progress-bar progress-bar-striped bg-success' role='progressbar'
         style="width: 0;padding:0; aria-valuenow='0'; aria-valuemin='0'; aria-valuemax='100'">
    </div>
</div>

<script>
    document.title = "Genotate.life - Admin - Create homology reference";
</script>

