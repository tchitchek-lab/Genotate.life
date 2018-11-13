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