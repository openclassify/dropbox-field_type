(function (window, document) {

    let fields = Array.prototype.slice.call(
        document.querySelectorAll('select[data-provides="visiosoft.field_type.dropbox"].search')
    );

    fields.forEach(function (field) {
        new Choices(field, {
            shouldSort: false,
        });
    });
})(window, document);
