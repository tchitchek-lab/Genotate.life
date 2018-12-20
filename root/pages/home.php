<link rel="stylesheet" type="text/css" href="/css/genotate.css">

<div style="display: block;float: none;margin: auto;text-align: center">
    <label class="title_genotate">Genotate</label>
    <br>
    <label style='font-size: 20px;'>
        annotating and exploring transcript sequences
    </label>
</div>

<br>
<p style='font-size: 16px; text-align: justify; text-justify: inter-word;'>The administration interface of the Genotate platform allows the: (i) management of the annotation results datasets; (ii) the management
    of the homology reference datasets; and (iii) the configuration of multiple parameters of the annotation pipeline.
</p>
<br>

<div class="div-border-title" style='width: 100%;'>Genotate administration functionalities</div>
<div class="div-border" style='width: 100%;'>
    <div style='width: 100%; margin-top: 2px;'>
        <div style='min-width: 209px; width:50%;padding: 2px;' data-toggle="tooltip" data-placement="bottom"
             title="<?php echo $tooltip_text['tt_home_admin_manage_results']; ?>">
            <a href="/root/index.php?page=manage_annotations" class='btn btn-primary'>
                <img src="/img/database.svg" style='height: 30px; filter: invert(90%);'>
                <br> <br> Manage annotation results
            </a>
        </div>
        <div style='min-width: 209px; width:50%;padding: 2px;' data-toggle="tooltip" data-placement="bottom"
             title="<?php echo $tooltip_text['tt_home_admin_manage_references']; ?>">
            <a href="/root/index.php?page=manage_references" class='btn btn-primary'>
                <img src="/img/database.svg" style='height: 30px; filter: invert(90%);'>
                <br> <br> Manage homology references
            </a>
        </div>
        <div style='min-width: 209px; width:50%;padding: 2px;' data-toggle="tooltip" data-placement="bottom"
             title="<?php echo $tooltip_text['tt_home_admin_create_references']; ?>">
            <a href="/root/index.php?page=create_reference" class='btn btn-primary'>
                <img src="/img/upload.svg" style='height: 30px; filter: invert(90%);'>
                <br> <br> Create homology reference
            </a>
        </div>
        <div style='min-width: 209px; width:50%;padding: 2px;' data-toggle="tooltip" data-placement="bottom"
             title="<?php echo $tooltip_text['tt_home_admin_import_references']; ?>">
            <a href="/root/index.php?page=import_references" class='btn btn-primary'>
                <img src="/img/sync.svg" style='height: 30px; filter: invert(90%);'>
                <br> <br> Import homology references
            </a>
        </div>
        <div style='min-width: 209px; width:50%;padding: 2px;' data-toggle="tooltip" data-placement="bottom"
             title="<?php echo $tooltip_text['tt_home_admin_configure_database']; ?>">
            <a href="/root/index.php?page=configure_database" class='btn btn-primary'>
                <img src="/img/config.svg" style='height: 30px; filter: invert(90%);'>
                <br> <br> Database configuration
            </a>
        </div>
        <div style='min-width: 209px; width:50%;padding: 2px;' data-toggle="tooltip" data-placement="bottom"
             title="<?php echo $tooltip_text['tt_home_admin_configure_platform']; ?>">
            <a href="/root/index.php?page=configure_platform" class='btn btn-primary'>
                <img src="/img/config.svg" style='height: 30px; filter: invert(90%);'>
                <br> <br>Platform configuration
            </a>
        </div>
    </div>
</div>

<script>
    document.title = "Genotate.life - Admin - Import homology references";
</script>

