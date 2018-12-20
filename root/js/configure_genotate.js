function update_genotate_config()
{
    const xhr = new XMLHttpRequest();
    xhr.open ("POST", "/root/includes/update_genotate_config.php", true);
	xhr.onreadystatechange = function() {
	    if(xhr.readyState === 4 && xhr.status === 200) {
			window.location.reload();
	    }
	};
    const oFormElement = document.getElementById("form_genotate_config");
    xhr.send (new FormData (oFormElement));
}

function update_genotateweb_config()
{

    const xhr = new XMLHttpRequest();
    xhr.open ("POST", "/root/includes/update_genotateweb_config.php", true);
	xhr.onreadystatechange = function() {
	    if(xhr.readyState === 4 && xhr.status === 200) {
			window.location.reload();
	    }
	};
    const oFormElement = document.getElementById("form_genotateweb_config");
    xhr.send (new FormData (oFormElement));
}

function update_service_color(input, service) {
    const xhr = new XMLHttpRequest();
    const color = input.value.replace("#", "");
    xhr.open("GET", "/root/includes/update_colors.php?service=" + service + "&color=" + color, true);
    xhr.send(null);
}
