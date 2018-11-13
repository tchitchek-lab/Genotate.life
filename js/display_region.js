function reloadphp_div(valuepage){
    document.getElementById('activepage').value = valuepage;
    document.getElementById('submit_search_form').click();
}
function download_svg(filename, elId) {
    var elHtml = document.getElementById(elId).innerHTML;
    var link = document.createElement('a');
    link.setAttribute('download', filename);
    link.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(elHtml));
    link.click(); 
}
function triggerDownload (filename,imgURI) {
    var evt = new MouseEvent('click', {
	view: window,
	bubbles: false,
	cancelable: true
    });

    var a = document.createElement('a');
    a.setAttribute('download', filename);
    a.setAttribute('href', imgURI);
    a.setAttribute('target', '_blank');

    a.dispatchEvent(evt);
}
function download_png(filename, svgid) {
    var svg = document.getElementById(svgid);
    var canvas = document.getElementById('canvas');
    canvas.width = svg.width.baseVal.value;
    canvas.height = svg.height.baseVal.value;
    var ctx = canvas.getContext('2d');
    var data = (new XMLSerializer()).serializeToString(svg);
    var DOMURL = window.URL || window.webkitURL || window;

    var img = new Image();
    var svgBlob = new Blob([data], {type: 'image/svg+xml;charset=utf-8'});
    var url = DOMURL.createObjectURL(svgBlob);

    img.onload = function () {
	ctx.drawImage(img, 0, 0);
	DOMURL.revokeObjectURL(url);

	var imgURI = canvas
	.toDataURL('image/png')
	.replace('image/png', 'image/octet-stream');

	triggerDownload(filename,imgURI);
    };

    img.src = url;
}

function sortTable(table_name, col, asc)
{
    tbody = document.getElementById(table_name);
    var rows = tbody.rows;
    var rlen = rows.length;
    var arr = new Array();
    var i, j, cells, clen;
    // fill the array with values from the table
    for(i = 0; i < rlen; i++)
    {
	cells = rows[i].cells;
	clen = cells.length;
	arr[i] = new Array();
	for(j = 0; j < clen; j++) { arr[i][j] = cells[j].innerHTML; }
    }
    // sort the array by the specified column number (col) and order (asc)
    arr.sort(function(a, b)
	    {
	var retval=0;
	var fA=parseFloat(a[col]);
	var fB=parseFloat(b[col]);
	if(a[col] != b[col])
	{
	    if((fA==a[col]) && (fB==b[col]) ){ retval=( fA > fB ) ? asc : -1*asc; } //numerical
	    else { retval=(a[col] > b[col]) ? asc : -1*asc;}
	}
	return retval;      
	    });
    for(var rowidx=0;rowidx<rlen;rowidx++)
    {
	for(var colidx=0;colidx<arr[rowidx].length;colidx++){ 
	    tbody.rows[rowidx].cells[colidx].innerHTML=arr[rowidx][colidx]; 
	}
    }
}

function viewer(region_id, width, height){
    //var width = window.innerWidth
    //|| document.documentElement.clientWidth
    //|| document.body.clientWidth;
//
    //var height = window.innerHeight
    //|| document.documentElement.clientHeight
    //|| document.body.clientHeight;
    window.open("/includes/display_region.php?viewer=1&region_id="+region_id+"&width="+width, "_blank", 'height='+height+', width='+width);
}

function refresh_svg(region_id){
    $.post('/includes/display_region_svg.php',
	    $('#update_svg_'+region_id).serialize(),
	    function(data,status){
	$('#svg_div_'+region_id).html('');
	$('#svg_div_'+region_id).append(data);
    }
    );
}

function onchange_range(region_id,size){
    if(size<150){
	return false;
    }
    var range_lower = document.getElementById('range_lower_'+region_id);
    var range_upper = document.getElementById('range_upper_'+region_id);
    var range_slider = document.getElementById('range_slider_'+region_id);
    var value_upper = range_upper.value*1-99;
    var value_lower = range_lower.value*1+99;
    range_lower.max = value_upper;
    range_upper.min = value_lower;
    var percent_lower=((value_upper)/size*100);
    var percent_upper=((size-value_lower+1)/size*100);
    var percent_slider = ((value_upper*1 + value_lower*1 - 100)/2)/size*100;
    percent_lower = percent_lower * 97 / 100;
    percent_upper = percent_upper * 97 / 100;
    if(percent_upper < 2.5){
	percent_upper = 2.5;
	percent_slider = 88;
    }
    if(percent_slider > 88){
	percent_slider = 88;
    }
    range_lower.style.width = percent_lower+'%';
    range_upper.style.width = percent_upper+'%';
    range_lower.style.marginRight = (100-percent_lower)+'%';
    range_upper.style.marginLeft  = (100-percent_upper)+'%';
    range_slider.style.marginLeft  = percent_slider+'%';
    document.getElementById('amount_lower_'+region_id).value = range_lower.value;
    document.getElementById('amount_upper_'+region_id).value = range_upper.value;
    if(range_slider.value != 0){
        range_slider.value = 0;
    }
    $('#button_'+region_id).click();
}

function move_left(region_id,size,step){
    if(size<150){
	return false;
    }
    var range_lower = document.getElementById('range_lower_'+region_id);
    var range_upper = document.getElementById('range_upper_'+region_id);
    var value_lower = range_lower.value;
    var value_upper = range_upper.value;
    range_lower.value = value_lower*1-(step*1);
    range_upper.value = value_upper*1-(step*1);
    onchange_range(region_id,size);
}

function move_right(region_id,size,step){
    if(size<150){
	return false;
    }
    var range_lower = document.getElementById('range_lower_'+region_id);
    var range_upper = document.getElementById('range_upper_'+region_id);
    var value_lower = range_lower.value;
    var value_upper = range_upper.value;
    range_lower.value = value_lower*1+(step*1);
    range_upper.value = value_upper*1+(step*1);
    onchange_range(region_id,size);
}

function slide_region(region_id,size,direction){
    if(size<150){
	return false;
    }
    var range_lower = document.getElementById('range_lower_'+region_id);
    var range_upper = document.getElementById('range_upper_'+region_id);
    var value_lower = range_lower.value;
    var value_upper = range_upper.value;
    var step = 0.1*(value_upper - value_lower);
    if (step > (0.01*size)){
	step = 0.01*size;
    }
    if(direction*1 < 0){
	range_lower.value = value_lower*1-step;
	range_upper.value = value_upper*1-step;
    }
    if(direction*1 > 0){
	range_lower.value = value_lower*1+step;
	range_upper.value = value_upper*1+step;
    }
    onchange_range(region_id,size);
}

function isEventSupported(eventName) {
    var el = document.createElement('div');
    eventName = 'on' + eventName;
    var isSupported = (eventName in el);
    if (!isSupported) {
	el.setAttribute(eventName, 'return;');
	isSupported = typeof el[eventName] == 'function';
    }
    el = null;
    return isSupported;
}

function preventDefault(e) {
    e = e || window.event;
    if (e.preventDefault)
	e.preventDefault();
    e.returnValue = false;  
}

function wheel_svg_zoom(region_id,size){
    if(size<150){
	return false;
    }
    var wheelEvent = isEventSupported('mousewheel') ? 'mousewheel' : 'wheel';
    $('#svg_div_content_'+region_id).on(wheelEvent, function(e) {
	preventDefault(e);
	var oEvent = e.originalEvent,
	delta = oEvent.deltaY || oEvent.wheelDelta;
	var range_lower = document.getElementById('range_lower_'+region_id);
	var range_upper = document.getElementById('range_upper_'+region_id);
	var value_lower = range_lower.value;
	var value_upper = range_upper.value;
	if (delta < 0) {
	    var svg_div = $('#svg_div_content_'+region_id);
	    var x = value_lower*1 + ((e.pageX - svg_div.offset().left) + svg_div.scrollLeft()) / svg_div.width() * (value_upper-value_lower);
	    range_lower.value = value_lower*1+(0.1*Math.abs(value_lower-x));
	    range_upper.value = value_upper*1-(0.1*Math.abs(value_upper-x));
	    document.getElementById('amount_lower_'+region_id).value = range_lower.value;
	    document.getElementById('amount_upper_'+region_id).value = range_upper.value;
	    onchange_range(region_id,size);
	} else {
	    range_lower.value = value_lower*1-(0.1*(value_upper-value_lower));
	    range_upper.value = value_upper*1+(0.1*(value_upper-value_lower));
	    document.getElementById('amount_lower_'+region_id).value = range_lower.value;
	    document.getElementById('amount_upper_'+region_id).value = range_upper.value;
	    onchange_range(region_id,size);
	}
    });
}

