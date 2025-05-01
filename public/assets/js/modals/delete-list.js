$('#deleteModalList').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget);
    const listId = button.data('list-id');
    const listNombre = button.data('list-nombre');
    const listUserId = button.data('list-user-id');

    const modal = $(this);
    modal.find('input[name="id"]').val(listId);
    modal.find('input[name="nombre"]').val(listNombre);
    modal.find('input[name="usuario"]').val(listUserId);
});