<script src="/js/annotate.js?v=39654943" xmlns:right></script>

<form action="" enctype="multipart/form-data" id="annotform" name="annotform" method="post"
      onsubmit="return checkEntries();">
    <input type='hidden' name='myseq' id='myseq' value='0'>
    <label type=title>Annotate multiple transcripts</label>
    <label data-toggle='buttons' class='btn btn-default btn-sm' for='debug' style='display: none;'><input
                type='checkbox' id='debug' name='debug' style='display: none;'>debug</label>
    <p style='text-align: justify;text-justify: inter-word;'>
        For all provided transcript sequences, Genotate first detects all the possible Open Reading Frames (ORF). The sequence of each detected ORF is then translated to obtain the sequence of the associated encoded protein. Using public reference databases and bioinformatics algorithms, Genotate predicts homology and functional annotations for each ORF sequence and associated protein. On the one hand, Genotate predicts homology annotations based on transcriptomic and proteomic references. On the other hand, Genotate predicts functional annotations on the associated protein based on several algorithms and databases (such as conserved domains, protein family, primary and secondary structure, ...).
    </p>


    <div style='width: 420px; margin: 0;padding: 0 5px 5px 0;height: 300px;'>
        <div class="div-border-title">
            Transcript sequences
            <a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top"
               href="/index.php?page=tutorial" target="_blank"
               title="<?php echo $tooltip_text['transcripts_panel']; ?>">
                <img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
        </div>
        <div class="div-border" style='padding:5px;height: 260px;'>
            <div class="form-group row" style="width: 100%;">
                <input data-toggle="tooltip" data-placement="top"
                       title="<?php echo $tooltip_text['transcript_sequence_file']; ?>" type="button"
                       class='btn btn-default' id="file_button" value="select a fasta file"
                       onclick="document.getElementById('file').click();"
                       style="border: 1px solid grey; font-size: 16px; height: 55px; width: 100%;">
                <input type="file" style="display: none;" id="file" name="file" ACCEPT=".fasta"
                       onchange="getFileName()">
            </div>
            <div>
                <div class="form-group row" style="width: 100%;">
                    <label for='db_name'>analysis name</label>
                    <input data-toggle="tooltip" data-placement="top"
                           title="<?php echo $tooltip_text['annotation_name']; ?>" type="text" id="db_name"
                           name="db_name" value="" onchange='checkName()' onkeyup='checkName()'
                           style="width: 100%; height: 2em; text-align: left;">
                </div>
                <div class="form-group" style="width: 100%;">
                    <label for='email'>email notification</label>
                    <input data-toggle="tooltip" data-placement="top" title="<?php echo $tooltip_text['email']; ?>"
                           type="text" id="email" name="email" value="" onchange='check_email()' onkeyup='check_email()'
                           style="width: 100%; height: 2em; text-align: left;">
                </div>
                <div class="form-group" style="width: 100%;">
                    <label for='description'>analysis description</label>
                    <textarea data-toggle="tooltip" data-placement="top"
                              title="<?php echo $tooltip_text['annotation_description']; ?>"
                              id="description" name="description"
                              style="white-space: nowrap;width: 100%; height: 60px; text-align: left; resize: none;"></textarea>
                </div>
            </div>
        </div>
    </div>

    <?php
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/create_orf_annotations.php");
    ?>

</form>
<br>

<button onclick="$('#progress_container').show();exec_genotate_multiple();" style="width: 100%; font-size: 1.3em;"
        class="btn btn-secondary active">
    Annotate transcripts
</button>

<div style='display:none;width:100%;' id='progress_container'>
    <div class="div-border-title" style='margin-top:10px;'>
        Upload progress
    </div>
    <div class='div-border progress' style='margin: 0; padding: 0; height: 30px;width:100%;'>
        <div class='progress-bar progress-bar-striped bg-success' role='progressbar' style='width: 0;padding:0; '
             aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'></div>
    </div>
</div>

<script>
    document.title = "Genotate.life - Annotate multiple transcripts";
</script>
