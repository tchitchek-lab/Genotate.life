function rename_reference_dataset(analysis_id) {
    const new_name = prompt("Enter a new name: ", "");
    if (/^[a-zA-Z0-9-_ ]*$/.test(new_name) === false) {
        alert('The dataset name contains illegal characters.');
        return false;
    }
    if (new_name !== "" && new_name) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/admin/includes/update_references.php?action=rename&analysis_id=' + analysis_id + '&new_name=' + new_name);
        xhr.addEventListener('readystatechange', function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                location.reload();
            }
        });
        xhr.send(null);
    }
}

function delete_reference_dataset(analysis_id) {
    if (confirm('Are you sure to delete this dataset?')) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/admin/includes/update_references.php?action=delete&analysis_id=' + analysis_id);
        xhr.addEventListener('readystatechange', function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                location.reload();
            }
        });
        xhr.send(null);
    }
}
