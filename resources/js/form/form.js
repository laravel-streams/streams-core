$(function () {

    // Focus on the first input.
    $('form.form').find('input:visible').first().focus();
    
    // Save entry on "ctrl + s" and "ctrl + shift + s" shortcuts
    var actions = document.querySelector('form.form').elements.action;

    var isCapslock = function(e) {
        e = (e) ? e : window.event;

        var charCode = false;

        if (e.which) {
            charCode = e.which;
        } else if (e.keyCode) {
            charCode = e.keyCode;
        }

        var shifton = false;

        if (e.shiftKey) {
            shifton = e.shiftKey;
        } else if (e.modifiers) {
            shifton = !!(e.modifiers & 4);
        }

        if (charCode >= 97 && charCode <= 122 && shifton) {
            return true;
        }

        if (charCode >= 65 && charCode <= 90 && !shifton) {
            return true;
        }

        return false;
    };

    window.addEventListener('keydown', function(ev) {
        
        if (ev.altKey === false && ev.ctrlKey === true && ev.keyCode === 83){

            var i = 0;

            if ((!isCapslock(ev) && ev.key === 'S') ||
                (isCapslock(ev) && ev.key === 's')) {
                i = 1;
            }

            ev.preventDefault();
        
            actions.item(i).click();
        }
    });
});
