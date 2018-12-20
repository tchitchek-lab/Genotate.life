<script src="/js/annotate.js?v=39654943" xmlns:right></script>

<form action="" enctype="multipart/form-data" id="annotform" name="annotform" method="post">
    <input type='hidden' name='myseq' id='myseq' value='1'>
    <label data-toggle='buttons' class='btn btn-default btn-sm' for='debug' style='display: none;'><input
                type='checkbox' id='debug' name='debug' style='display: none;'>debug</label>

    <div style='width: 420px; margin: 0;padding: 0 5px 5px 0;height: 300px;'>
        <div class="div-border-title">
            Transcript sequence
            <a style='float:right;margin-right:10px;' data-toggle="tooltip" data-placement="top"
               href="/index.php?page=tutorial" target="_blank"
               title="<?php echo $tooltip_text['transcript_panel']; ?>">
                <img src="/img/tutorial.svg" style='margin-bottom: 2px;height: 20px; filter: invert(90%);'></a>
        </div>
        <div class='div-border' style='padding:5px;height: 260px;'>
            <div style="width: 100%;">

                <?php
                $file_path = $_SERVER['DOCUMENT_ROOT'] . "./fasta_examples/sequence_1.fasta";
                if (file_exists($file_path)) {
                    $seq1 = file_get_contents($file_path);
                    echo "<input type='hidden' value='$seq1' id='seq1'>";
                }
                $file_path = $_SERVER['DOCUMENT_ROOT'] . "/fasta_examples/sequence_2.fasta";
                if (file_exists($file_path)) {
                    $seq2 = file_get_contents($file_path);
                    echo "<input type='hidden' value='$seq2' id='seq2'>";
                }
                $file_path = $_SERVER['DOCUMENT_ROOT'] . "/fasta_examples/sequence_3.fasta";
                if (file_exists($file_path)) {
                    $seq3 = file_get_contents($file_path);
                    echo "<input type='hidden' value='$seq3' id='seq3'>";
                }
                ?>

                <textarea data-toggle="tooltip" data-placement="top"
                          title="<?php echo $tooltip_text['transcript_sequence_input']; ?>" id="sequence"
                          name="sequence" maxlength="20000" onchange="onchangeSequence()"
                          onkeyup='onchangeSequence()'
                          style="white-space: nowrap;width: 100%; height: 115px; text-align: left; resize: none;"></textarea>
                <button class='btn btn-sm btn-secondary' style='border:1px solid lightgrey;margin-bottom:2px;'
                        onclick="setExemple(1);" form='' data-toggle="tooltip" data-placement="right"
                        title="<?php echo $tooltip_text['example_sequence_1']; ?>">sequence exemple 1
                </button>
                <script>
                    setExemple(2);
                </script>
                <button class='btn btn-sm btn-secondary' style='border:1px solid lightgrey;margin-bottom:2px;'
                        onclick="setExemple(2);" form='' data-toggle="tooltip" data-placement="top"
                        title="<?php echo $tooltip_text['example_sequence_2']; ?>">sequence exemple 2
                </button>
                <button class='btn btn-sm btn-secondary' style='border:1px solid lightgrey;margin-bottom:2px;'
                        onclick="setExemple(3);" form='' data-toggle="tooltip" data-placement="top"
                        title="<?php echo $tooltip_text['example_sequence_3']; ?>">sequence exemple 3
                </button>

                <input type="text" id="sequence_clean" title="sequence_clean" name="sequence_clean" value="" readonly
                       style="display: none;"/>
                <input type="text" id="description" title="description" name="description" value="" readonly
                       style="display: none;"/>
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
                           type="text" id="email" name="email" value="" onkeyup='check_email()'
                           onchange='check_email()' style="width: 100%; height: 2em; text-align: left;">
                </div>
            </div>
        </div>
    </div>

    <?php
    include($_SERVER['DOCUMENT_ROOT'] . "/includes/create_orf_annotations.php");
    ?>

</form>
<br>

<script>
    $('#annotform > div:nth-child(5) > div.div-border > div > div:nth-child(1) > div.btn-group > button').click()
    $('#functional_services_container > div:nth-child(1) > div.btn-group > button').click()
    //$('#annotform > div:nth-child(5) > div.div-border .btn').click()


</script>

<button onclick="exec_genotate_single();" style="width: 100%; font-size: 1.3em;" class="btn btn-secondary active">
    Annotate transcript
</button>

<script>
    document.title = "Genotate.life - Annotate single transcript";
</script>

