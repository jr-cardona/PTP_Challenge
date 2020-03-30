$('#importModal').on('show.bs.modal', function (e) {
    $('#model').attr('value', $(e.relatedTarget).data('model'));
    $('#redirect').attr('value', $(e.relatedTarget).data('redirect'));
    $('#import-model').attr('value', $(e.relatedTarget).data('import-model'));
});
