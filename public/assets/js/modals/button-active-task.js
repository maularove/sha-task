document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.complement-checkbox');

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const taskId = this.closest('li').dataset.tareaId;
            const newState = this.checked ? 1 : 0;

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/shatask/listas/tarea-save';

            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'id';
            idInput.value = taskId;
            form.appendChild(idInput);

            const estadoInput = document.createElement('input');
            estadoInput.type = 'hidden';
            estadoInput.name = 'estado';
            estadoInput.value = newState;
            form.appendChild(estadoInput);

            document.body.appendChild(form);
            form.submit();
        });
    });
});