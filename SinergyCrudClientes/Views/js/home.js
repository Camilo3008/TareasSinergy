
function listarTareas(){

    fetch('http://localhost/PruebaSynergy/SinergyCrudClientes/Tareas/getTareasALL')
        .then(response =>{
            
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.text();
        })
        .then(text =>{
            try{
                const data = JSON.parse(text);
                console.log(data.length)
                if(data.length > 0){
                    let tableBody = '';
                    data.forEach(tarea =>{
                        const completado = tarea.completado == '1' ? "Completada":"Pendiente"
                        tableBody +=`
                            <tr>
                                <td><input type="checkbox" class="task-checkbox" data-id="${tarea.id_tareas }"></td>
                                <td>${tarea.id_tareas }</td>
                                <td>${tarea.titulo}</td>
                                <td>${tarea.descripcion}</td>
                                <td>${completado}</td>
                                <td>${tarea.fecha_registro}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm editar-tarea" data-id="${tarea.id_tareas }">Editar</button>
                                    <button class="btn btn-danger btn-sm eliminar-tarea" data-id="${tarea.id_tareas }">Eliminar</button>
                                </td>
                            </tr>
                        `
                    })

                    document.querySelector('#tareasTable tbody').innerHTML = tableBody;
                    $('#tareasTable').DataTable({
                        "order": [[1, "desc"]],
                        "language": {
                            "url": "Views/js/es_es.json"
                        }
                    });

                    /* Actualizar */
                    document.querySelectorAll('.editar-tarea').forEach(button => {
                        button.addEventListener('click', function() {
                            const id = this.dataset.id;
                            editarTarea(id);
                        });
                    });


                    /* Eliminar*/
                    document.querySelectorAll('.eliminar-tarea').forEach(button => {
                        button.addEventListener('click', function() {
                            const id = this.dataset.id;
                            eliminarTarea(id);
                        });
                    });


                    /* Checkbox */
                    document.getElementById('selectAll').addEventListener('change', function() {
                        document.querySelectorAll('.task-checkbox').forEach(checkbox => {
                            checkbox.checked = this.checked;
                        });
                    });

                    document.getElementById('marcarCompletadas').addEventListener('click', function() {
                        marcarTareas(true);
                    });

                    document.getElementById('marcarPendientes').addEventListener('click', function() {
                        marcarTareas(false);
                    });


                } else {
                    Swal.fire('No hay tareas registradas');
                }


            }catch(error){
                console.error('Error parsing JSON:', error);
                Swal.fire('Error', 'Error parsing JSON: ' + error, 'error');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            Swal.fire('Error', 'Fetch error: ' + error, 'error');
        });
}

document.addEventListener('DOMContentLoaded', function() {
    listarTareas();

    document.getElementById('crearTareaForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const titulo = document.getElementById('titulo').value;
        const descripcion = document.getElementById('descripcion').value;
        //const completado = document.getElementById('completado').value;

        fetch('http://localhost/PruebaSynergy/SinergyCrudClientes/Tareas/registrarTarea', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ titulo, descripcion })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    Swal.fire('Éxito', 'Tarea creada correctamente.', 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', 'Error al crear la tarea.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Error al crear la tarea.', 'error');
            });
    });


    /* editar tarea */


    document.getElementById('editarTareaForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const id = document.getElementById('editId').value;
        const titulo = document.getElementById('editTitulo').value;
        const descripcion = document.getElementById('editDescripcion').value;
        const completado = document.getElementById('editCompletado').value;

        fetch(`http://localhost/PruebaSynergy/SinergyCrudClientes/Tareas/actualizarTareas?id=${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ titulo, descripcion, completado })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    Swal.fire('Éxito', 'Tarea actualizada correctamente.', 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', 'Error al actualizar la tarea.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Error al actualizar la tarea.', 'error');
            });
    });


    setInterval(function(){
        location.reload();
    }, 60000);
})



function eliminarTarea(id) {
    fetch(`http://localhost/PruebaSynergy/SinergyCrudClientes/Tareas/eliminarTareas?id=${id}`, {
        method: 'DELETE'
    })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                
                Swal.fire('Éxito', 'Tarea eliminada correctamente.', 'success').then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error', 'Error al eliminar la tarea.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Error al eliminar la tarea.', 'error');
        });
}


function editarTarea(id) {
    fetch(`http://localhost/PruebaSynergy/SinergyCrudClientes/Tareas/getTarea?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                const tarea = data.data;
                document.getElementById('editId').value = tarea[0].id_tareas;
                document.getElementById('editTitulo').value = tarea[0].titulo;
                document.getElementById('editDescripcion').value = tarea[0].descripcion;
                document.getElementById('editCompletado').value = tarea[0].completado;
                const editModal = new bootstrap.Modal(document.getElementById('editarTareaModal'));
                editModal.show();
            } else {
                Swal.fire('Error', 'Error al obtener los datos de la tarea.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Error al obtener los datos de la tarea.', 'error');
        });
}


function marcarTareas(completadoEst){

    let completado = completadoEst ? 1 : 0;

    const checkboxes = document.querySelectorAll('.task-checkbox:checked');
    const ids = Array.from(checkboxes).map(checkbox => checkbox.dataset.id);

    if (ids.length === 0) {
        Swal.fire('Advertencia', 'No se seleccionaron tareas.', 'warning');
        return;
    }

    fetch('http://localhost/PruebaSynergy/SinergyCrudClientes/Tareas/actualizarEstTarea', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ ids, completado })
    })
        .then(response => response.text())
        .then(text => {
            console.log("Response text:", text); // Log the response text
            const data = JSON.parse(text);
            if (data.status) {
                Swal.fire('Éxito', 'Tareas actualizadas correctamente.', 'success').then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error', 'Error al actualizar las tareas.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Error al actualizar las tareas.', 'error');
        });
}
