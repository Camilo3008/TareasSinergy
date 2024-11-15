<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de tareas</title>
    <!-- Incluye el CSS de Bootstrap 5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Incluye el CSS de DataTables con Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <!-- Incluye el CSS de SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1 class="my-4">Gestion de tareas</h1>
        </header>

        <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#crearTareaModal" role="button">Crear Tarea</a>
        <button id="marcarCompletadas" class="btn btn-success">Marcar Completadas</button>
        <button id="marcarPendientes" class="btn btn-warning">Marcar Pendientes</button>


        <div>
            <h1 class='text-center'>Lista de Tareas</h1>
            <div class='table-responsive'>
                <table id='tareasTable' class='table table-striped table-bordered'>
                    <thead class='thead-dark'>
                    <tr class='text-center'>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Completado</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Aquí se insertarán las tareas desde el archivo home.js-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <!-- Modal para Crear Tarea -->
    <div class="modal fade" id="crearTareaModal" tabindex="-1" aria-labelledby="crearTareaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearTareaModalLabel">Crear Tarea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="crearTareaForm">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                        </div>
<!--                         <div class="mb-3">
                            <label for="completado" class="form-label">Completado</label>
                            <select class="form-control" id="completado" name="completado" required>
                                <option value="0">Pendiente</option>
                                <option value="1">Completada</option>
                            </select>
                        </div> -->
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal para Editar Tarea -->
    <div class="modal fade" id="editarTareaModal" tabindex="-1" aria-labelledby="editarTareaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarTareaModalLabel">Editar Tarea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editarTareaForm">
                        <input type="hidden" id="editId" name="id">
                        <div class="mb-3">
                            <label for="editTitulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="editTitulo" name="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="editDescripcion" name="descripcion" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editCompletado" class="form-label">Completado</label>
                            <select class="form-control" id="editCompletado" name="completado" required>
                                <option value="0">Pendiente</option>
                                <option value="1">Completada</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>






<!-- Incluye el JS de jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Incluye el JS de DataTables -->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<!-- Incluye el JS de DataTables con Bootstrap 5 -->
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
<!-- Incluye el JS de Bootstrap 5.3.2 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Incluye el JS personalizado -->
<script src="/PruebaSynergy/SinergyCrudClientes/Views/js/home.js"></script>
<!-- Incluye el JS de SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

</body>
</html>