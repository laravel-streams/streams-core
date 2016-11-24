var modal = $('.modal.remote.in');
var form = modal.find('form.modal-filter');
var input = form.find('input');
var list = modal.find('ul');
var items = list.find('li');

// Don't submit on return.
form.on('submit', function() {
    return false;
});

input.focus();

input.on('keyup', function(e) {

    var value = $(this).val();

    items.each(function() {
        if ($(this).text().indexOf(value) >= 0) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
});
