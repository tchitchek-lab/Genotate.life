function checkName() {
    var form_valid = true;
    var database_name = document.getElementById("db_name").value;
    var database_names = document.getElementById("db_names").value.split(",");
    if($.inArray(database_name, database_names) != -1 || database_name == "") {
	document.getElementById("db_name").style.borderWidth = "medium";
	document.getElementById("db_name").style.borderColor = "red";
	form_valid = false;
    }else{
	document.getElementById("db_name").style.border = "1px solid lightgrey";
    }
    return form_valid;
}

function onchange_ftp(){
    filename = document.getElementById("ftp_input").value;
    filename = filename.replace(/\\/g,"/").split("/");
    filename = filename[filename.length - 1];
    filename = filename.substring(0, filename.lastIndexOf('.'));
    if (document.getElementById("db_name").value == ""){
	document.getElementById("db_name").value = filename;
    }
}

function check_email() {
    var form_valid = true;
    var email = document.getElementById("email").value;
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if(!re.test(email) && email != "") {
	document.getElementById("email").style.borderWidth = "medium";
	document.getElementById("email").style.borderColor = "red";
	form_valid = false;
    }else{
	document.getElementById("email").style.border = "1px solid lightgrey";
    }
    return form_valid;
}

function checkUpload() {
    var form_valid = true;
    var upload_type = $('input[name="upload_type"]:checked').val();
    if(upload_type=="file"){
	var file = document.getElementById("file");
	if(file.value == "") {
	    document.getElementById("file_button").style.borderWidth = "medium";
	    document.getElementById("file_button").style.borderColor = "red";
	    form_valid = false;
	}else{
	    document.getElementById("file_button").style.border = "1px solid lightgrey";
	}
    }else{
	var ftp_input = document.getElementById("ftp_input");
	if(ftp_input.value == "") {
	    ftp_input.style.borderWidth = "medium";
	    ftp_input.style.borderColor = "red";
	    form_valid = false;
	}else{
	    ftp_input.style.border = "1px solid lightgrey";
	}
    }
    return form_valid;
}


function checkEntries() {
    var form_valid = true;
    var errMsg = "";
    if(!checkUpload()){
	form_valid = false;
    }
    if(!checkName()){
	form_valid = false;
    }
    if(!check_email()){
	form_valid = false;
    }
    if(!form_valid){
	alert("Please complete or change the highlighted inputs.\n"+errMsg);
    }
    return form_valid;
}

function getFileName() {
    filename = document.getElementById("file").value;
    filename = filename.replace(/\\/g,"/").split("/");
    filename = filename[filename.length - 1];
    document.getElementById("file_button").value = filename;
    if (document.getElementById("db_name").value == ""){
	document.getElementById("db_name").value = filename.replace(".fasta", "").replace(".fa", "");
    }
}

function handleClick(element){
    if(element.id == "file_label"){
	document.getElementById("file_button").style.display="block";
	document.getElementById("ftp_input").style.display="none";
    }
    if(element.id == "ftp_label"){
	document.getElementById("file_button").style.display="none";
	document.getElementById("ftp_input").style.display="block";
    }
}