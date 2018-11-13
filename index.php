<?php
include ("header.php");
include './users/includes/initialize_db.php';
include ("navigation.php");
?>

<script>
	document.title = "Genotate.life - Home";
</script>

			<div id="content_scroll">
				<script>
					//AUTO RESIZE CONTENT SCROLLABLE DIV
					$(document).ready(function() {   
						var resizeDelay = 200;
						var doResize = true;
						var resizer = function () {
							if (doResize) {
								var heightSlider = $('#header').height();
								$('#content_scroll').css({ height : $(window).height() - heightSlider });
								var widthInner = $('#content').width();
								var margin = ($(window).width() - widthInner)/2;
								doResize = false;
							}
						};
						var resizerInterval = setInterval(resizer, resizeDelay);
						resizer();
						$(window).resize(function() {
							doResize = true;
						});
					});
				</script>
				<div id="content" style='float: none;display:block;max-width:60em;margin-top: 0px;margin-right: auto;margin-bottom: 0px;margin-left: auto;'>
					<div id="content-top-margin" style='width:100%;height:0px;padding:15px;'></div>
					<?php
					if ($page == "") {
						include ("./pages/home.php");
					} else {
						include("./pages/$page.php");
					}
					?>
					<div id="content-bottom-margin" style='width:100%;padding-top:15px;padding-bottom:15px;'>
						Genotate is supported by the IDMIT infrastructure and funded by the ANR.
						<br><a href="http://www.idmitcenter.fr/">IDMIT</a> is part of the French Alternative Energies and Atomic Energy Commission (CEA) | <a href="http://www.genotate.life/index.php?page=gpl3">Terms of use (GPL license)</a>
					</div>
				</div>
				<script>
					$(function () {
						$('[data-toggle="tooltip"]').tooltip({trigger : 'hover'});
					})
				</script>
			</div>
			</body>
		</html>
