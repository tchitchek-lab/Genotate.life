function checkOrf() {
    var seq = document.getElementById("sequence_clean").value;
    var orf_min_size = document.getElementById("orf_min_size").value;
    var compute_reverse = document.getElementById("compute_reverse").checked;
    var start_position = -1;
    var start_codons = document.getElementById("start_codon").value.split(",");
    var stop_codons = document.getElementById("stop_codon").value.split(",");
    var seq_isvalid = false;
    for (var i = 0; i < seq.length - 2; i += 3) {
	var codon = seq.substring(i, i + 3);
	if (start_codons.includes(codon) && start_position == -1) {
	    start_position = i;
	}
	if (stop_codons.includes(codon) && start_position !== -1) {
	    var stop_position = i + 3;
	    var orf_size = stop_position - start_position;
	    if (orf_size > orf_min_size) {
		//console.info(start_position + "" + stop_position + "" + orf_seq.length);
		seq_isvalid = true;
	    }else{
		start_position = -1;
	    }
	}
    }
    if(compute_reverse){
	var start_position = -1;
	seq = seq.split('').reverse().join('');
	for (var i = 0; i < seq.length - 2; i += 3) {
	    var codon = seq.substring(i, i + 3);
	    if (start_codons.includes(codon) && start_position == -1) {
		start_position = i;
	    }
	    if (stop_codons.includes(codon) && start_position !== -1) {
		var stop_position = i + 3;
		var orf_size = stop_position - start_position;
		if (orf_size > orf_min_size) {
		    //console.info(start_position + "" + stop_position + "" + orf_seq.length);
		    seq_isvalid = true;
		}else{
		    start_position = -1;
		}
	    }
	}
    }
    return seq_isvalid;
}

function onchangeSequence() {
    var sequence = document.getElementById("sequence").value;
    var seq_isvalid = true;
    var regex1 = /^([ATGCNatgcn\s\n\r]+)$/g;
    var regex2 = /^>(.+)[\s\n\r]+([ATGCNatgcn\s\n\r]+)$/g;
    var matches = [];
    if(sequence.match(regex1)) {
		matches = regex1.exec(sequence);
		document.getElementById("sequence").value = ">id description\n"+document.getElementById("sequence").value;
		document.getElementById("sequence_clean").value = matches[1].replace(/[\s\n\r]/g,"").toUpperCase();
    }else if(sequence.match(regex2)){
		matches = regex2.exec(sequence);
		document.getElementById("description").value = matches[1].replace(/['\"|]/g,"_");
		document.getElementById("sequence_clean").value = matches[2].replace(/[\s\n\r]/g,"").toUpperCase();
    }else {
		document.getElementById("sequence_clean").value = "";
		seq_isvalid = false;
    }
	
	if(sequence.length>19999){
			seq_isvalid = false
	}
	
    if(!seq_isvalid){
		document.getElementById("sequence").style.borderWidth = "medium";
		document.getElementById("sequence").style.borderColor = "red";
    }else{
		document.getElementById("sequence").style.border = "1px solid lightgrey";
    }
    return seq_isvalid;
}

function checkSequence() {
    var sequence = document.getElementById("sequence").value;
    var seq_isvalid = true;
    var regex1 = /^([ATGCNatgcn\s\n\r]+)$/g;
    var regex2 = /^>([^\s]+).*[\s\n\r]+([ATGCNatgcn\s\n\r]+)$/g;
    var matches = [];
    if(sequence.match(regex1)) {
	matches = regex1.exec(sequence);
	document.getElementById("sequence_clean").value = matches[1].replace(/[\s\n\r]/g,"").toUpperCase();
    }else if(sequence.match(regex2)){
	matches = regex2.exec(sequence);
	document.getElementById("sequence_clean").value = matches[2].replace(/[\s\n\r]/g,"").toUpperCase();
    }else {
	document.getElementById("sequence_clean").value = "";
	seq_isvalid = false;
    }
    if(!seq_isvalid){
	document.getElementById("sequence").style.borderWidth = "medium";
	document.getElementById("sequence").style.borderColor = "red";
    }else{
	document.getElementById("sequence").style.border = "1px solid lightgrey";
    }
    return seq_isvalid;
}

function checkName() {
    var form_valid = true;
    var database_name = document.getElementById("db_name").value;
    var database_names = document.getElementById("db_names").value.split(",");
    if(/^[a-zA-Z0-9-_ ]*$/.test(database_name) == false) {
	document.getElementById("db_name").style.borderWidth = "medium";
	document.getElementById("db_name").style.borderColor = "red";
	form_valid = false;
    }else if($.inArray(database_name, database_names) != -1) {
	document.getElementById("db_name").style.borderWidth = "medium";
	document.getElementById("db_name").style.borderColor = "red";
	form_valid = false;
    }else{
	document.getElementById("db_name").style.border = "1px solid lightgrey";
    }
    return form_valid;
}

function check_start_codon() {
    var start_codon = document.getElementById("start_codon").value.toUpperCase().split(",");
    var codon_isvalid = true;
    for (var i = 0 ; i < start_codon.length ; i++) {
	var codon = start_codon[i];
	if(!codon.match(/^[ATGC][ATGC][ATGC]$/)) {
	    codon_isvalid = false;
	}
    }
    if(!codon_isvalid){
	document.getElementById("start_codon").style.borderWidth = "medium";
	document.getElementById("start_codon").style.borderColor = "red";
    }else{
	document.getElementById("start_codon").style.border = "1px solid lightgrey";
    }
    return codon_isvalid;
}

function check_stop_codon() {
    var start_codon = document.getElementById("stop_codon").value.toUpperCase().split(",");
    var codon_isvalid = true;
    for (var i = 0 ; i < start_codon.length ; i++) {
	var codon = start_codon[i];
	if(!codon.match(/^[ATGC][ATGC][ATGC]$/)) {
	    codon_isvalid = false;
	}
    }
    if(!codon_isvalid){
	document.getElementById("stop_codon").style.borderWidth = "medium";
	document.getElementById("stop_codon").style.borderColor = "red";
    }else{
	document.getElementById("stop_codon").style.border = "1px solid lightgrey";
    }
    return codon_isvalid;
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

function checkEntries() {
    var form_valid = true;
    var errMsg = "";
    var file = document.getElementById("file");
    if(file.value == "") {
	document.getElementById("file_button").style.borderWidth = "medium";
	document.getElementById("file_button").style.borderColor = "red";
	form_valid = false;
    }else{
	document.getElementById("file_button").style.border = "1px solid lightgrey";
    }
    if(!checkName()){
	form_valid = false;
    }
    if(!check_start_codon()){
	form_valid = false;
    }
    if(!check_stop_codon()){
	form_valid = false;
    }
    if(!check_email()){
	form_valid = false;
    }

    if(!form_valid){
	alert("Please complete or change the highlighted inputs.");
    }
    return form_valid;
}

function checkEntries_myseq(){
    var form_valid = true;
    var errMsg = "";
    if(!checkSequence()){
	form_valid = false;
    }
    var database_name = document.getElementById("db_name").value;
    if(database_name != ""){
	if(!checkName()){
	    form_valid = false;
	}
    }
    if(!check_start_codon()){
	form_valid = false;
    }
    if(!check_stop_codon()){
	form_valid = false;
    }
    if(!check_email()){
	form_valid = false;
    }
    if(!form_valid){
	alert("Please complete or change the highlighted inputs.\n");
    }
    return form_valid;
}

function getFileName() {
    filename = document.getElementById("file").value;
    filename = filename.split("\\");
    filename = filename[filename.length - 1];
    document.getElementById("file_button").value = filename;
    document.getElementById("db_name").value = filename.replace(".fasta", "");
}

function setExemple(id){
    if (id==1){
	seq = document.getElementById("seq1").value;
    }
    if (id==2){
	seq = document.getElementById("seq2").value;
    }
    if (id==3){
	seq = document.getElementById("seq3").value;
    }
    document.getElementById("sequence").value = seq;
    onchangeSequence();
}

//function select_all_services(){
//    var isactive = document.getElementById('label_select_all_services').classList.contains("active");
//    if(isactive){
//	$( ".func_annot" ).removeClass( "active" );
//	$( ".func_annot_checkbox" ).removeAttr('checked');
//	$( ".func_annot_checkbox" ).attr('unchecked', '');
//    }else{
//	$( ".func_annot" ).removeClass( "active" ).addClass( "active" );
//	$( ".func_annot_checkbox" ).removeAttr('unchecked');
//	$( ".func_annot_checkbox" ).attr('checked', '');
//    }
//}

