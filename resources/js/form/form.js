$(function () {

    // Focus on the first input.
    $('form.form').find('input:visible').first().focus();
    
    // Save entry on "ctrl + s" and "ctrl + shift + s" shortcuts
    var actions = document.querySelector('form.form').elements.action;
    window.addEventListener('keydown', function(ev) {
        if (ev.altKey === false && ev.ctrlKey === true && ev.keyCode === 83){
            var i = 0;
            if (ev.key === 'S') { // shift
                i = 1;
            }
            ev.preventDefault();
            actions.item(i).click();
        }
    });
});
