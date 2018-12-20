function manage_colors() {
    $(function () {
        $('.demo').each(function () {
            $(this).minicolors({
                control: $(this).attr('data-control') || 'hue',
                inline: $(this).attr('data-inline') === 'true',
                letterCase: 'lowercase',
                opacity: false,
                change: function (hex, opacity) {
                    if (!hex) return;
                    $(this).select();
                },
                theme: 'bootstrap'
            });
        });

        const $inlinehex = $('#inlinecolorhex h3 small');
        $('#inlinecolors').minicolors({
            inline: true,
            theme: 'bootstrap',
            change: function (hex) {
                if (!hex) return;
                $inlinehex.html(hex);
            }
        });
    });
}
