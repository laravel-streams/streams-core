var modal = $('.modal.remote.in');
var form = modal.find('form.modal-filter');
var input = form.find('input');
var list = modal.find('ul');
var items = list.find('li');
var selected = null;

// Don't submit on return.
form.on('submit', function () {
    return false;
});

input.focus();

input.on('keyup', function (e) {

    var value = $(this).val();

    // Filter first!
    items.each(function () {
        if ($(this).text().indexOf(value) >= 0) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });

    // Down arrow.
    if (e.which == 40) {
        if (selected) {

            if (selected.next(':visible').length) {
                items.find('a').removeClass('active');
                selected = selected.next(':visible');
                selected.find('a').addClass('active');
            }
        } else {
            selected = items.filter(':visible').first();
            selected.find('a').addClass('active');
        }
    } else if (e.which == 38) {
        if (selected) {

            if (selected.prev(':visible').length) {
                items.find('a').removeClass('active');
                selected = selected.prev(':visible');
                selected.find('a').addClass('active');
            }
        } else {
            selected = items.filter(':visible').last();
            selected.find('a').addClass('active');
        }
    } else if (e.which == 13) {
        if (selected) {

            window.location = selected.find('a').attr('href');

            modal.find('.modal-content').append('<div class="modal-loading"><div class="active loader"></div></div>');
        }
    }
});
