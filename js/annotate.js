function onchangeSequence() {
    const sequence = document.getElementById("sequence").value;
    let seq_isvalid = true;
    const regex1 = /^([ATGCNatgcn\s\n\r]+)$/g;
    const regex2 = /^>(.+)[\s\n\r]+([ATGCNatgcn\s\n\r]+)$/g;
    let matches = [];
    if (sequence.match(regex1)) {
        matches = regex1.exec(sequence);
        document.getElementById("sequence").value = ">id description\n" + document.getElementById("sequence").value;
        document.getElementById("sequence_clean").value = matches[1].replace(/[\s\n\r]/g, "").toUpperCase();
    } else if (sequence.match(regex2)) {
        matches = regex2.exec(sequence);
        document.getElementById("description").value = matches[1].replace(/['\"|]/g, "_");
        document.getElementById("sequence_clean").value = matches[2].replace(/[\s\n\r]/g, "").toUpperCase();
    } else {
        document.getElementById("sequence_clean").value = "";
        seq_isvalid = false;
    }

    if (sequence.length > 19999) {
        seq_isvalid = false
    }

    if (!seq_isvalid) {
        document.getElementById("sequence").style.borderWidth = "medium";
        document.getElementById("sequence").style.borderColor = "red";
    } else {
        document.getElementById("sequence").style.border = "1px solid lightgrey";
    }
    return seq_isvalid;
}

function checkSequence() {
    const sequence = document.getElementById("sequence").value;
    let seq_isvalid = true;
    const regex1 = /^([ATGCNatgcn\s\n\r]+)$/g;
    const regex2 = /^>([^\s]+).*[\s\n\r]+([ATGCNatgcn\s\n\r]+)$/g;
    let matches = [];
    if (sequence.match(regex1)) {
        matches = regex1.exec(sequence);
        document.getElementById("sequence_clean").value = matches[1].replace(/[\s\n\r]/g, "").toUpperCase();
    } else if (sequence.match(regex2)) {
        matches = regex2.exec(sequence);
        document.getElementById("sequence_clean").value = matches[2].replace(/[\s\n\r]/g, "").toUpperCase();
    } else {
        document.getElementById("sequence_clean").value = "";
        seq_isvalid = false;
    }
    if (!seq_isvalid) {
        document.getElementById("sequence").style.borderWidth = "medium";
        document.getElementById("sequence").style.borderColor = "red";
    } else {
        document.getElementById("sequence").style.border = "1px solid lightgrey";
    }
    return seq_isvalid;
}

function check_start_codon() {
    const start_codon = document.getElementById("start_codon").value.toUpperCase().split(",");
    let codon_isvalid = true;
    for (let i = 0; i < start_codon.length; i++) {
        const codon = start_codon[i];
        if (!codon.match(/^[ATGC][ATGC][ATGC]$/)) {
            codon_isvalid = false;
        }
    }
    if (!codon_isvalid) {
        document.getElementById("start_codon").style.borderWidth = "medium";
        document.getElementById("start_codon").style.borderColor = "red";
    } else {
        document.getElementById("start_codon").style.border = "1px solid lightgrey";
    }
    return codon_isvalid;
}

function check_stop_codon() {
    const start_codon = document.getElementById("stop_codon").value.toUpperCase().split(",");
    let codon_isvalid = true;
    for (let i = 0; i < start_codon.length; i++) {
        const codon = start_codon[i];
        if (!codon.match(/^[ATGC][ATGC][ATGC]$/)) {
            codon_isvalid = false;
        }
    }
    if (!codon_isvalid) {
        document.getElementById("stop_codon").style.borderWidth = "medium";
        document.getElementById("stop_codon").style.borderColor = "red";
    } else {
        document.getElementById("stop_codon").style.border = "1px solid lightgrey";
    }
    return codon_isvalid;
}

function check_email() {
    let form_valid = true;
    const email = document.getElementById("email").value;
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!re.test(email) && email !== "") {
        document.getElementById("email").style.borderWidth = "medium";
        document.getElementById("email").style.borderColor = "red";
        form_valid = false;
    } else {
        document.getElementById("email").style.border = "1px solid lightgrey";
    }
    return form_valid;
}

function checkEntries() {
    let form_valid = true;
    const file = document.getElementById("file");
    if (file.value === "") {
        document.getElementById("file_button").style.borderWidth = "medium";
        document.getElementById("file_button").style.borderColor = "red";
        form_valid = false;
    } else {
        document.getElementById("file_button").style.border = "1px solid lightgrey";
    }
    if (!check_start_codon()) {
        form_valid = false;
    }
    if (!check_stop_codon()) {
        form_valid = false;
    }
    if (!check_email()) {
        form_valid = false;
    }

    if (!form_valid) {
        alert("Please complete or change the highlighted inputs.");
    }
    return form_valid;
}

function checkEntries_myseq() {
    let form_valid = true;
    if (!checkSequence()) {
        form_valid = false;
    }
    if (!check_start_codon()) {
        form_valid = false;
    }
    if (!check_stop_codon()) {
        form_valid = false;
    }
    if (!check_email()) {
        form_valid = false;
    }
    if (!form_valid) {
        alert("Please complete or change the highlighted inputs.\n");
    }
    return form_valid;
}

function getFileName() {
    let filename = document.getElementById("file").value;
    filename = filename.split("\\");
    filename = filename[filename.length - 1];
    document.getElementById("file_button").value = filename;
    document.getElementById("db_name").value = filename.replace(".fasta", "");
}

function setExemple(id) {
    let seq = "";
    if (id === 1) {
        seq = document.getElementById("seq1").value;
    }
    if (id === 2) {
        seq = document.getElementById("seq2").value;
    }
    if (id === 3) {
        seq = document.getElementById("seq3").value;
    }
    document.getElementById("sequence").value = seq;
    onchangeSequence();
}

function exec_genotate_single() {

    if (!checkEntries_myseq()) {
        return false;
    }

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/includes/annotate_transcripts.php", true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            window.location.replace("/index.php?page=view_annotations&encoded_id=" + xhr.responseText);
        }
    };
    let oFormElement = document.getElementById("annotform");
    xhr.send(new FormData(oFormElement));
}

function exec_genotate_multiple() {
    if (!checkEntries()) {
        return false;
    }

    const xhr = new XMLHttpRequest();
    xhr.upload.addEventListener("progress", function (event) {
        let percent = (event.loaded / event.total) * 100;
        percent = Math.floor(percent);
        const progressbar = $('.progress-bar');
        const percentVal = percent + '%';
        progressbar.width(percentVal);
        progressbar.html(percentVal);
    });

    xhr.open("POST", "/includes/annotate_transcripts.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            window.location.replace("/index.php?page=view_annotations&encoded_id=" + xhr.responseText);
        }
    };
    let oFormElement = document.getElementById("annotform");
    xhr.send(new FormData(oFormElement));
}
