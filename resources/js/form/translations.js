// Reference https://developer.mozilla.org/en-US/docs/Web/API/Web_Storage_API/Using_the_Web_Storage_API
var storageAvailable = function (type) {

    try {
        var
            storage = window[type],
            x = '__storage_test__';

        storage.setItem(x, x);
        storage.removeItem(x);

        return true;
    }
    catch (e) {

        return e instanceof DOMException && (
                // everything except Firefox
            e.code === 22 ||
            // Firefox
            e.code === 1014 ||
            // test name field too, because code might not be present
            // everything except Firefox
            e.name === 'QuotaExceededError' ||
            // Firefox
            e.name === 'NS_ERROR_DOM_QUOTA_REACHED') &&
            // acknowledge QuotaExceededError only if there's something already stored
            storage.length !== 0;
    }
};

// Construction below, is the shorthand of $(document).ready() already.
$(function () {

    $('body').on('click', '[data-toggle="lang"]', function (e) {

        e.preventDefault();

        var selected = $(this);
        var locale = selected.attr('lang');
        var form = selected.closest('form');

        var toggles = form.find('[data-toggle="lang"][lang="' + locale + '"]');
        var triggers = form.find('[data-toggle="lang"]');
        var group = triggers.closest('.btn-group');
        var toggle = group.find('.dropdown-toggle');
        var dropdown = group.find('.dropdown-menu');

        toggle.text(selected.text());

        dropdown.find('a').removeClass('active');
        selected.addClass('active');

        form.find('.form-group[lang]').addClass('hidden');
        form.find('.form-group[lang="' + locale + '"]').removeClass('hidden');

        toggles.addClass('active');

        if (storageAvailable('localStorage')) {
            localStorage.setItem('formTranslations', locale);
        }
    });

    if (storageAvailable('localStorage') && !!localStorage.getItem('formTranslations')) {
        $('[data-toggle="lang"][lang="' + localStorage.getItem('formTranslations') + '"]').first().click();
    }
});
