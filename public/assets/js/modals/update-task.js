$('#updateModalTask').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget);
    const taskId = button.data('tarea-id');
    const listId = button.data('tarea-lista-id');
    const taskTitulo = button.data('tarea-titulo');
    const taskDescripcion = button.data('tarea-descripcion');

    const modal = $(this);
    modal.find('input[name="id"]').val(taskId);
    modal.find('input[name="lista_id"]').val(listId);
    modal.find('input[name="titulo"]').val(taskTitulo);
    modal.find('#descriptionTask').text(taskDescripcion);
});