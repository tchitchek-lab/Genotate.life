function create_links() {

    $(document).ready(create_table());

    let ToC = "";
    let newLine, el, title, link;

    $(".anchor").each(function () {
        el = $(this);
        title = el.html();
        link = el.attr("id");
        let background = el.css('background-color');
        let color = el.css('color');

        newLine = "<button style='text-shadow:none;text-align:left;min-width:100px;width:100%;word-break:break-word;white-space: normal;background:" + background + ";color:" + color + "' class='btn btn-default btn-xs' onclick=\"scroll_to_div('" + link + "')\">" + title + "</button>";

        ToC += newLine;

    });

    $('#navbar-left').prepend(ToC);
}



function create_table() {
    const resizeDelay = 200;
    let doResize = true;
    const resizer = function () {
        if (doResize) {
            const heightSlider = $('#header').height();
            $('#content_scroll').css({height: $(window).height() - heightSlider});
            $('#navbar-left').css({height: $(window).height() - heightSlider - 30});
            const widthInner = $('#content').width();
            const margin = ($(window).width() - widthInner) / 2 - 10;
            const div_nbl = document.getElementById("navbar-left");
            div_nbl.style.width = margin + 'px';
            if (margin > 100) {
                div_nbl.style.display = 'block';
            } else {
                div_nbl.style.display = 'none';
            }
            doResize = false;
        }
    };
    setInterval(resizer, resizeDelay);
    resizer();
    $(window).resize(function () {
        doResize = true;
    });
}

function scroll_to_div(id) {
    let divPosition = $('#' + id).offset().top - $('#header').height();
    divPosition = $('#content_scroll').scrollTop() + divPosition;
	$('#content_scroll').animate({scrollTop: divPosition}, "slow");
}
