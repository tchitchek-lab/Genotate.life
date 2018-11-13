function database_reset(){
    if (confirm('Do you want to reset the database ?')){
        var db_name = document.getElementById("database").value;
    	if(db_name != ""){
    		var xhr = new XMLHttpRequest();
    		alert('reset the database');
    		xhr.open('GET', '/includes/database.php?action=reset&db_name='+db_name);
    		xhr.addEventListener('readystatechange', function() {
    			if (xhr.readyState === XMLHttpRequest.DONE) {
    			    alert("done");
    			}
    		});
    			xhr.send(null);
    	}
    }
}
function database_create(){
    if (confirm('Do you want to create the database ?')){
        var db_name = document.getElementById("database").value;
    	if(db_name != ""){
    		var xhr = new XMLHttpRequest();
    		alert('create the database');
    		xhr.open('GET', '/includes/database.php?action=create&db_name='+db_name);
    		xhr.addEventListener('readystatechange', function() {
    			if (xhr.readyState === XMLHttpRequest.DONE) {
    			    alert("done");
    			}
    		});
    			xhr.send(null);
    	}
    }
}