<?php

?>
<main class="container">
    <section class="col-md-12 text-left">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Listado Usuarios</h1>
            <a href="?controller=Usuarios&method=add" class="btn btn-success">
                <i class="fas fa-plus"></i>
            </a>
        </div>

        <section class="col-md-12 table-responsive">

            <?php
            // Depuración: muestra el contenido de $UsuariosController
            echo '<pre>';
            var_dump($UsuariosController);
            echo '</pre>';
            ?>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre y Apellido</th>
                        <th>Documento</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($UsuariosController as $Usuarios) : ?>
                        <tr>
                            <td><?php echo $Usuarios['id'] ?></td>
                            <td><?php echo $Usuarios['nombre'] . ' ' . $Usuarios['apellido'] ?></td>
                            <td><?php echo $Usuarios['documento'] ?></td>
                            <td><?php echo $Usuarios['correo_electronico'] ?></td>
                            <td><?php echo $Usuarios['Rol'] ?></td>
                            <td>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <a href="?controller=Usuarios&method=edit&id=<?php echo $Usuarios['id'] ?>" class="btn btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="?controller=Usuarios&method=delete&id=<?php echo $Usuarios['id'] ?>"
                                        class="btn btn-danger"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </section>
    </section>
</main>

<style>
    body {
        background: linear-gradient(90deg, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 1) 0%, rgba(0, 100, 148, 1) 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
        background-color: #ffffff;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        max-width: 1200px;
        margin-top: 20px;
    }

    h1,
    h3 {
        color: #003366;
        font-weight: bold;
    }

    .btn {
        border-radius: 8px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        transition: all 0.2s ease;
    }

    .btn-primary {
        background-color: #0056b3;
        border: none;
    }

    .btn-primary:hover {
        background-color: #004494;
        transform: translateY(-2px);
    }

    .btn-success {
        background-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    table {
        margin-top: 20px;
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        vertical-align: middle !important;
        text-align: center;
        padding: 15px;
        border: 1px solid #007bff;
    }

    th {
        background-color: #007bff;
        color: #fff;
    }

    tr:hover {
        background-color: #cce5ff;
    }

    label {
        font-weight: bold;
        color: #495057;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #007bff;
        padding: 10px;
    }

    .modal-header {
        background-color: #007bff;
        color: white;
    }

    .modal-content {
        border-radius: 10px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
    }

    .modal-title {
        font-weight: bold;
    }

    .btn-close {
        background-color: white;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }
</style>