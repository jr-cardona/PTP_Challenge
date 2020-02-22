$('#confirmDeleteModal').on('show.bs.modal', function (e) {
    $('#deleteForm').attr('action', $(e.relatedTarget).data('route'));
    $('#message').html($(e.relatedTarget).data('message'));
});
