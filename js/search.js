function toggle_names(algorithm) {
    const name = "div_names_" + algorithm;
    const div = document.getElementById(name);
    let content = div.getElementsByClassName("btn");
    for (let iIndex = 0; iIndex < content.length; iIndex++) {
        content[iIndex].classList.toggle('active');
    }
}

function load_keywords(dataset, algorithm) {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "/includes/search_keywords.php?dataset=" + dataset + "&algorithm=" + algorithm, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log("#div_names_" + algorithm);
            $("#div_names_" + algorithm).html(xhr.responseText);
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
        const algorithm = id_str.replace("div_names_", "");
        load_keywords(dataset, algorithm);
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
