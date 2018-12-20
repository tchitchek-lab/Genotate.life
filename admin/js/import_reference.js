function synchronize_noncode(name, species, release, description, link) {

    const type = 'nucleic';

    const button = document.getElementById(name);
    button.className = "btn btn-warning btn-sm";
    button.setAttribute("onclick", null);

    const xhr = new XMLHttpRequest();
    const get = '/admin/includes/import_reference.php?name=' + name + '&type=' + type + '&species=' + species + '&release=' + release + '&description=' + description + '&ftp=' + link;

    xhr.open('GET', get);
    xhr.addEventListener('readystatechange', function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            button.className = "btn btn-success btn-sm";
        }
    });

    xhr.send(null);

}

function synchronize_uniref(name, species, release, description, link) {

    if (!confirm('The import of this reference will take time, are you sure to import this reference?'))
        return;

    const type = 'proteic';

    const button = document.getElementById(name);
    button.className = "btn btn-warning btn-sm";
    button.setAttribute("onclick", null);

    const xhr = new XMLHttpRequest();
    const get = '/admin/includes/import_reference.php?name=' + name + '&type=' + type + '&species=' + species + '&release=' + release + '&description=' + description + '&ftp=' + link;

    xhr.open('GET', get);
    xhr.addEventListener('readystatechange', function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            button.className = "btn btn-success btn-sm";
        }
    });

    xhr.send(null);

}

function synchronize_ensembl(name, release, species, type, sequence_type, description) {

    const button = document.getElementById(release + species + sequence_type);
    button.className = "btn btn-warning btn-sm";
    button.setAttribute("onclick", null);

    const link = "ftp://ftp.ensembl.org/pub/release-"+release+"/fasta/"+species.replace(" ","_")+"/"+sequence_type+"/";

    const xhr = new XMLHttpRequest();
    const get = '/admin/includes/import_reference.php?name=' + name + '&type=' + type + '&species=' + species + '&release=' + release + '&description=' + description + '&ftp=' + link;

    xhr.open('GET', get);
    xhr.addEventListener('readystatechange', function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            button.className = "btn btn-success btn-sm";
        }
    });

    xhr.open('GET', get);
    xhr.send(null);

}

