function rename_annotation_dataset(dataset_id){
    var new_name = prompt("Enter a new name: ", "");
    if(/^[a-zA-Z0-9-_ ]*$/.test(new_name) == false) {
	alert('The dataset name contains illegal characters.');
	return false;
    }
    if(new_name != "" && new_name){
	var xhr = new XMLHttpRequest();
	xhr.open('GET', '/includes/update_annotation_dataset.php?action=rename&dataset_id='+dataset_id+'&new_name='+new_name);
	xhr.addEventListener('readystatechange', function() {
	    if (xhr.readyState === XMLHttpRequest.DONE) {
		location.reload();
	    }
	});
	xhr.send(null);
    }
}
function delete_annotation_dataset(dataset_id){
    if (confirm('Are you sure to delete this dataset?')){
	var xhr = new XMLHttpRequest();
	xhr.open('GET', '/includes/update_annotation_dataset.php?action=delete&dataset_id='+dataset_id);
	xhr.addEventListener('readystatechange', function() {
	    if (xhr.readyState === XMLHttpRequest.DONE) {
		location.reload();
	    }
	});
	xhr.send(null);
    }
}
function interrupt_annotation_dataset(dataset_id){
    if (confirm('Do you want to interrupt this dataset ?')){
	var xhr = new XMLHttpRequest();
	xhr.open('GET', '/includes/update_annotation_dataset.php?action=interrupt&dataset_id='+dataset_id);
	xhr.addEventListener('readystatechange', function() {
	    if (xhr.readyState === XMLHttpRequest.DONE) {
		location.reload();
	    }
	});
	xhr.send(null);
    }
}

function rename_reference_dataset(dataset_id){
    var new_name = prompt("Enter a new name: ", "");
    if(/^[a-zA-Z0-9-_ ]*$/.test(new_name) == false) {
	alert('The dataset name contains illegal characters.');
	return false;
    }
    if(new_name != "" && new_name){
	var xhr = new XMLHttpRequest();
	xhr.open('GET', '/includes/update_reference_dataset.php?action=rename&dataset_id='+dataset_id+'&new_name='+new_name);
	xhr.addEventListener('readystatechange', function() {
	    if (xhr.readyState === XMLHttpRequest.DONE) {
		location.reload();
	    }
	});
	xhr.send(null);
    }
}
function delete_reference_dataset(dataset_id){
    if (confirm('Are you sure to delete this dataset?')){
	var xhr = new XMLHttpRequest();
	xhr.open('GET', '/includes/update_reference_dataset.php?action=delete&dataset_id='+dataset_id);
	xhr.addEventListener('readystatechange', function() {
	    if (xhr.readyState === XMLHttpRequest.DONE) {
		location.reload();
	    }
	});
	xhr.send(null);
    }
}