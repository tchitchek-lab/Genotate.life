function checkName() {
    let form_valid = true;
    const database_name = document.getElementById("db_name").value;
    const database_names = document.getElementById("db_names").value.split(",");
    if ($.inArray(database_name, database_names) !== -1 || database_name === "") {
        document.getElementById("db_name").style.borderWidth = "medium";
        document.getElementById("db_name").style.borderColor = "red";
        form_valid = false;
    } else {
        document.getElementById("db_name").style.border = "1px solid lightgrey";
    }
    return form_valid;
}

function onchange_ftp() {
    let filename = document.getElementById("ftp_input").value;
    filename = filename.replace(/\\/g, "/").split("/");
    filename = filename[filename.length - 1];
    filename = filename.substring(0, filename.lastIndexOf('.'));
    if (document.getElementById("db_name").value === "") {
        document.getElementById("db_name").value = filename;
    }
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

function checkUpload() {
    let form_valid = true;
    const upload_type = $('input[name="upload_type"]:checked').val();
    if (upload_type === "file") {
        const file = document.getElementById("file");
        if (file.value === "") {
            document.getElementById("file_button").style.borderWidth = "medium";
            document.getElementById("file_button").style.borderColor = "red";
            form_valid = false;
        } else {
            document.getElementById("file_button").style.border = "1px solid lightgrey";
        }
    } else {
        const ftp_input = document.getElementById("ftp_input");
        if (ftp_input.value === "") {
            ftp_input.style.borderWidth = "medium";
            ftp_input.style.borderColor = "red";
            form_valid = false;
        } else {
            ftp_input.style.border = "1px solid lightgrey";
        }
    }
    return form_valid;
}

function checkEntries() {
    let form_valid = true;
    const errMsg = "";
    if (!checkUpload()) {
        form_valid = false;
    }
    if (!checkName()) {
        form_valid = false;
    }
    if (!check_email()) {
        form_valid = false;
    }
    if (!form_valid) {
        alert("Please complete or change the highlighted inputs.\n" + errMsg);
    }
    return form_valid;
}

function getFileName() {
    let filename = document.getElementById("file").value;
    filename = filename.replace(/\\/g, "/").split("/");
    filename = filename[filename.length - 1];
    document.getElementById("file_button").value = filename;
    if (document.getElementById("db_name").value === "") {
        document.getElementById("db_name").value = filename.replace(".fasta", "").replace(".fa", "");
    }
}

function handleClick(element) {
    if (element.id === "file_label") {
        document.getElementById("file_button").style.display = "block";
        document.getElementById("ftp_input").style.display = "none";
    }
    if (element.id === "ftp_label") {
        document.getElementById("file_button").style.display = "none";
        document.getElementById("ftp_input").style.display = "block";
    }
}

function upload_reference() {

    if (!checkEntries()) {
        return false;
    }

    const progressbar = $('.progress-bar');
    const percentVal = '0%';
    progressbar.width(percentVal);
    progressbar.html(percentVal);

    const xhr = new XMLHttpRequest();
    const upload_type = $('input[name="upload_type"]:checked').val();

    if (upload_type === "file") {
        xhr.upload.addEventListener("progress", function (event) {
            let percent = (event.loaded / event.total) * 100;
            percent = Math.floor(percent);
            const progressbar = $('.progress-bar');
            const percentVal = percent + '%';
            progressbar.width(percentVal);
            progressbar.html(percentVal);
            if (percent === 100) {
                document.location.href = "/root/index.php?page=manage_references";
            }
        });
    } else {
        setInterval(ftp_progress(), 2000);
    }

    xhr.open("POST", "/root/includes/create_reference.php", true);

    const oFormElement = document.getElementById("form");
    xhr.send(new FormData(oFormElement));


}

function ftp_progress() {

    const link = document.getElementById("ftp_input").value;
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "/root/includes/get_ftp_percentage.php?link=" + link, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let percent = xhr.responseText;
            percent = Math.floor(percent);
            const progressbar = $('.progress-bar');
            const percentVal = percent + '%';
            progressbar.width(percentVal);
            progressbar.html(percentVal);
            if (percent === 100) {
                document.location.href = "/root/index.php?page=manage_references";
            }
        }
    };
    xhr.send(null);
}
