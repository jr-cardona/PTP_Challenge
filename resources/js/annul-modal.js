$('#confirmAnnulmentModal').on('show.bs.modal', function (e) {
    $('#annulForm').attr('action', $(e.relatedTarget).data('route'));
});
