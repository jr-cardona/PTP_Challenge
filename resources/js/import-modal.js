$('#importModal').on('show.bs.modal', function (e) {
    $('#model').attr('value', $(e.relatedTarget).data('model'));
    $('#redirect').attr('value', $(e.relatedTarget).data('redirect'));
    $('#import_model').attr('value', $(e.relatedTarget).data('import_model'));
});
