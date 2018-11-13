<link rel="stylesheet" type="text/css" media="all" href="../css/jquery.minicolors.css">
<script type="text/javascript" src="../js/jquery.minicolors.min.js"></script>

<script type="text/javascript">
$(function(){
  var colpick = $('.demo').each( function() {
    $(this).minicolors({
      control: $(this).attr('data-control') || 'hue',
      inline: $(this).attr('data-inline') === 'true',
      letterCase: 'lowercase',
      opacity: false,
      change: function(hex, opacity) {
        if(!hex) return;
        if(opacity) hex += ', ' + opacity;
        try {
          console.log(hex);
        } catch(e) {}
        $(this).select();
      },
      theme: 'bootstrap'
    });
  });
  var $inlinehex = $('#inlinecolorhex h3 small');
  $('#inlinecolors').minicolors({
    inline: true,
    theme: 'bootstrap',
    change: function(hex) {
      if(!hex) return;
      $inlinehex.html(hex);
    }
  });
});
</script>
<script type="text/javascript">
function update_service_color(input, service){
    var xhr = new XMLHttpRequest();
    var color = input.value.replace("#", "");
	xhr.open ("GET", "../includes/update_service_color.php?service="+service+"&color="+color, true);
	xhr.send(null);
}
</script>
<label type=title>Definition of annotation colors</label>
<p style='text-align: justify; text-justify: inter-word;'>The color associated to annotation service in the annotation viewers can be defined here.</p>
<br>
<style>
.minicolors {
}

.minicolors-swatch:hover {
	cursor: pointer;
	border: 2px solid black;
}
</style>
<div class="div-border-title">
	Annotation colors<a style='float: right; margin-right: 10px;' data-toggle="tooltip" data-placement="top" href="./index.php?page=tutorial" target="_blank" title="<?php echo $tooltip_text['annotation_colors']; ?>"> <img src="/img/tutorial.svg" style='margin-bottom: 2px; height: 20px; filter: invert(90%);'></a>
</div>
<div class="div-border" style="margin-bottom: 10px;">
<?php
$services_color = array ();
// fill $services_color
//include ("../includes/colors.php");
$request = "SELECT * from service";
$results = mysqli_query ( $connexion, $request ) or die ( "SQL Error:<br>$request<br>" . mysqli_error ( $connexion ) );
while ( $row = mysqli_fetch_array ( $results, MYSQLI_ASSOC ) ) {
	$service = $row ['name'];
	$service_color = $row ['color'];
	echo "<div class='div-border' style='width:279.3px;height:38px;'>";
	if ($USER_MODE == "restricted") {
		echo "<input class='form-control demo minicolors-input' type='text' onchange=\"update_service_color(this, '$service');\" id='input_$service' value='$service_color' style='text-transform: uppercase;width:120px;height:28px;margin-top:3px;' disable>";
	}else{
		echo "<input class='form-control demo minicolors-input' type='text' onchange=\"update_service_color(this, '$service');\" id='input_$service' value='$service_color' style='text-transform: uppercase;width:120px;height:28px;margin-top:3px;'>";
	}
	echo "<label style='padding-top:6px;margin-left:5px;'>$service</label>";
	echo "</div>";
}
?>
</div>
