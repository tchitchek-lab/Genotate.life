function toggle_names(service){
    var name = "div_names_"+service;
    var div = document.getElementById(name);
    content = div.getElementsByClassName("btn");
    for (var iIndex = 0; iIndex < content.length; iIndex++){
	content[iIndex].classList.toggle('active');
    };
}
function load_keywords(dataset, service, user_id){
    var xhr = new XMLHttpRequest();
    xhr.open ("GET", "/includes/search_keywords.php?dataset="+dataset+"&service="+service+"&user_id="+user_id, true);
    xhr.onreadystatechange = function() {
    if(xhr.readyState == 4 && xhr.status == 200) {
        var div = document.getElementById("div_names_"+service);
        div.innerHTML = xhr.responseText;
        $('[data-toggle="tooltip"]').tooltip();
    }
    }
    xhr.send(null);
}
function dataset_refresh(dataset){
  console.log('dataset_refresh');
    var xhr = new XMLHttpRequest();
    xhr.open ("GET", "/includes/check_any_keywords.php?dataset="+dataset+"&user_id="+user_id, true);
    xhr.onreadystatechange = function() {
      if(xhr.readyState == 4 && xhr.status == 200) {
          console.log('dataset_refresh r'+xhr.responseText);
          if(xhr.responseText == 'ok'){
            $('#annotations_filters').show();
            var content = document.getElementsByClassName("div_keywords");
            for (var iIndex = 0; iIndex < content.length; iIndex++){
              var div = content[iIndex];
              var id_str = div.id;
              var service = id_str.replace("div_names_", "");
              var user_id = $('#user_id').val();
              load_keywords(dataset, service, user_id);
            }
          }else{
            console.log('no annotations');
            $('#annotations_filters').hide();
          }
      }
    }
    xhr.send(null);
}
function keyword_refresh(){
    var searchkeyword = $('#annotation_keyword_filter').val().toLowerCase();
    $('.keyword').filter(function(){
	return $(this).attr('data-original-title').toLowerCase().indexOf(searchkeyword) == -1;
    }).hide();
    $('.keyword').filter(function(){
	return $(this).attr('data-original-title').toLowerCase().indexOf(searchkeyword) != -1;
    }).show();
}
function toggle_filters(){
    var button = document.getElementById("toggle_filters_div");
    var div = document.getElementById("filters_div");
    if (div.style.display == 'none'){
	div.style.display = 'inline-block';
	button.src="/img/minus.svg"
    }else{
	div.style.display = 'none';
	button.src="/img/plus.svg"
    }
}