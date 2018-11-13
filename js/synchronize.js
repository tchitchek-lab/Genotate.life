function synchronize(name, release, species, type){
    var button = document.getElementById(release+species+type);
    if(release != "" && species != ""){
	    button.className = "btn btn-warning btn-sm";
	    var xhr = new XMLHttpRequest();
            button.setAttribute("onclick", null);
	    xhr.open('GET', '/includes/upload_ensembl.php?release='+release+'&species='+species+'&type='+type+'&name='+name);
	    xhr.addEventListener('readystatechange', function() {
	        if (xhr.readyState === XMLHttpRequest.DONE) {
	            button.className = "btn btn-success btn-sm";
	        }
	    });
	    xhr.send(null);
    }else{
	    alert("Please select a release and a species");
    }
}
function onchange_release(){
    var release = document.getElementById('release');
    if(release.name != ""){
    	var species = document.getElementById('table_'+release.name).style.display="none";
    }
    var species = document.getElementById('table_'+release.value).style.display="initial";
}
function onclick_release(){
    var release = document.getElementById('release');
    release.name = release.value;
}

function synchronize_uniref(name){
    if (confirm('The datasets loading will take time, do you want to synchronize this dataset ?')){
        var ftp = '';
        if (name == "UNIREF_swissprot"){
    		ftp = 'ftp://ftp.uniprot.org/pub/databases/uniprot/current_release/knowledgebase/complete/uniprot_sprot.fasta.gz';
        }
        if (name == "UNIREF_trEMBL"){
    		ftp = 'ftp://ftp.uniprot.org/pub/databases/uniprot/current_release/knowledgebase/complete/uniprot_trembl.fasta.gz';
    	}
        if (name == "UNIREF_50"){
    		ftp = 'ftp://ftp.uniprot.org/pub/databases/uniprot/uniref/uniref50/uniref50.fasta.gz';
    	}
        if (name == "UNIREF_90"){
    		ftp = 'ftp://ftp.uniprot.org/pub/databases/uniprot/uniref/uniref90/uniref90.fasta.gz';
    	}
        if (name == "UNIREF_100"){
    		ftp = 'ftp://ftp.uniprot.org/pub/databases/uniprot/uniref/uniref100/uniref100.fasta.gz';
    	}
        var type = 'proteic';
        var button = document.getElementById(name);
        if(ftp != ''){
    	    button.className = "btn btn-warning btn-sm";
    	    var xhr = new XMLHttpRequest();
                button.setAttribute("onclick", null);
    	    xhr.open('GET', '/includes/upload_reference.php?type='+type+'&ftp='+ftp+'&name='+name+'&seq_type=pep');
    	    xhr.addEventListener('readystatechange', function() {
    	        if (xhr.readyState === XMLHttpRequest.DONE) {
    	            button.className = "btn btn-success btn-sm";
    	        }
    	    });
    	    xhr.send(null);
        }
    }
}

function synchronize_noncode(dbname, filename){
    var ftp = 'http://www.noncode.org/datadownload/'+filename;
    var type = 'nucleic';
    var button = document.getElementById(dbname);
    if(ftp != ''){
	    button.className = "btn btn-warning btn-sm";
	    var xhr = new XMLHttpRequest();
            button.setAttribute("onclick", null);
	    xhr.open('GET', '/includes/upload_reference.php?type='+type+'&ftp='+ftp+'&name='+dbname+'&seq_type=ncrna');
	    xhr.addEventListener('readystatechange', function() {
	        if (xhr.readyState === XMLHttpRequest.DONE) {
	            button.className = "btn btn-success btn-sm";
	        }
	    });
	    xhr.send(null);
    }else{
	    alert('Please select a release and a species');
    }
}