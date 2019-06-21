$(document).on('ajaxComplete ready', function () {

    // Initialize dropbox pickers
    $('input[data-provides="visiosoft.field_type.dropbox"]:not([data-initialized])').each(function () {

        $(this).attr('data-initialized', '');

        var input = $(this);
        var field = input.data('field_name');
        var wrapper = input.closest('.form-group');
        var modal = $('#' + field + '-modal');

        modal.on('click', '[data-entry]', function (e) {

            e.preventDefault();

            wrapper.find('.selected').load(REQUEST_ROOT_PATH + '/streams/dropbox-field_type/selected/' + $(this).data('key') + '?uploaded=' + $(this).data('entry'), function () {
                modal.modal('hide');
            });

            $('[name="' + field + '"]').val($(this).data('entry'));

            $(wrapper).find('[data-dismiss="dropbox"]').removeClass('hidden');
        });

        $(wrapper).on('click', '[data-dismiss="dropbox"]', function (e) {

            e.preventDefault();

            $('[name="' + field + '"]').val('');

            wrapper.find('.selected').html('');

            $(this).addClass('hidden');
        });
    });
});
