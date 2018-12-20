function toggle_names(service) {
    const name = "div_names_" + service;
    const div = document.getElementById(name);
    let content = div.getElementsByClassName("btn");
    for (let iIndex = 0; iIndex < content.length; iIndex++) {
        content[iIndex].classList.toggle('active');
    }
}

function load_keywords(dataset, service) {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "/includes/search_keywords.php?dataset=" + dataset + "&service=" + service, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("#div_names_" + service);
            $("#div_names_" + service).html(xhr.responseText);
            $('[data-toggle="tooltip"]').tooltip();
        }
    };
    xhr.send(null);
}

function dataset_refresh(dataset) {
    const content = document.getElementsByClassName("div_keywords");
    for (let iIndex = 0; iIndex < content.length; iIndex++) {
        const div = content[iIndex];
        const id_str = div.id;
        const service = id_str.replace("div_names_", "");
        load_keywords(dataset, service);
    }
}

function keyword_refresh() {
    const searchkeyword = $('#annotation_keyword_filter').val().toLowerCase();
    $('.keyword').filter(function () {
        return $(this).attr('data-original-title').toLowerCase().indexOf(searchkeyword) === -1;
    }).hide();
    $('.keyword').filter(function () {
        return $(this).attr('data-original-title').toLowerCase().indexOf(searchkeyword) !== -1;
    }).show();
}
