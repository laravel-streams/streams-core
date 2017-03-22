$(function () {
    var $window = $(window);
    var $form = $('form.form');
    var $controls = $form.children('.controls');
    var controlsHeight = $controls.height();
    var doFixed = function ($el) {
        $el.addClass('fixed-bottom');
        $el.css({ width: $form.width() + 'px' });
        $el.prev().css({ marginBottom: 'calc(' + controlsHeight + 'px + 1.5rem)' });
    };
    var doUnfixed = function ($el) {
        $el.removeClass('fixed-bottom');
        $el.css({ width: 'inherit' });
        $el.prev().css({ marginBottom: '1.5rem' });
    };
    var isAtBottom = function () {
        var scrollTop = document.body.scrollTop;
        var documentHeight = document.body.scrollHeight;
        var windowHeight = window.innerHeight;

        if (scrollTop + windowHeight - documentHeight + controlsHeight > 0) {
            return true;
        }
        return false;
    };
    var checkFixed = function (ev) {
        if (window.innerWidth < 992 || isAtBottom()) {
            doUnfixed($controls);
        } else {
            doFixed($controls);
        }
    };

    // Focus on the first input.
    $form.find('input:visible').first().focus();

    // Fixed controls
    checkFixed();
    $window.on('resize', checkFixed);
    $window.on('scroll', checkFixed);
});
