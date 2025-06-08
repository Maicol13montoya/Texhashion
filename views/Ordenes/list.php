<?php
?>
<main class="container">
    <section class="col-md-12 text-left">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <!-- Botones de Agregar Orden y Notificaciones -->
            <h1>Listado de Órdenes</h1>
            <div style="display: flex; align-items: center;">
                <!-- Botón de agregar orden -->
                <a href="?controller=Ordenes&method=add" class="btn btn-success">
                    <i class="fas fa-plus"></i>
                </a>

                <!-- Icono de notificación -->
                <div style="position: relative; margin-left: 15px;">
                    <a href="#" id="notification-icon" class="btn btn-light">
                        <i class="fas fa-bell" style="font-size: 24px;"></i>
                        <!-- Contador de notificaciones -->
                        <?php if (!empty($arrNotificaciones)): ?>
                            <span id="notification-count" class="badge badge-danger" style="position: absolute; top: -5px; right: -5px; font-size: 12px;"><?php echo count($arrNotificaciones); ?></span>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Notificaciones de las órdenes próximas a cumplirse -->
        <?php if (!empty($arrNotificaciones)): ?>
            <section class="col-md-12 mt-4" id="notification-list" style="display: none;">
                <h3>Notificaciones de Órdenes Próximas a Cumplirse</h3>
                <ul class="list-group">
                    <?php foreach ($arrNotificaciones as $notificacion): ?>
                        <li class="list-group-item list-group-item-warning">
                            <strong>Orden #<?php echo $notificacion['idOrden']; ?>:</strong> <?php echo $notificacion['mensaje']; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        <?php endif; ?>

        <!-- Listado de Órdenes -->
        <section class="col-md-12 table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID Orden</th>
                        <th>Cliente</th>
                        <th>Fecha Orden</th>
                        <th>Total</th>
                        <th>Cantidad Producto</th>
                        <th>Fecha Entrega</th>
                        <th>Producto Terminado</th>
                        <th>Materia Prima</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($OrdenesController as $orden) : ?>
                        <tr>
                            <td><?php echo $orden['idOrden'] ?></td>
                            <td><?php echo $orden['nombre'] . ' ' . $orden['apellido'] ?></td>
                            <td><?php echo $orden['Fecha_Orden'] ?></td>
                            <td><?php echo $orden['Total_Total'] ?></td>
                            <td><?php echo $orden['Cantidad_Producto'] ?></td>
                            <td><?php echo $orden['Fecha_Entrega'] ?></td>
                            <td><?php echo $orden['Nombre_Producto'] ?></td>
                            <td><?php echo $orden['Nombre'] ?></td>
                            <td><?php echo $orden['Estados'] ?></td>
                            <td>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <a href="?controller=Ordenes&method=edit&idOrden=<?php echo $orden['idOrden'] ?>" class="btn btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="?controller=Ordenes&method=delete&idOrden=<?php echo $orden['idOrden'] ?>" class="btn btn-danger"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar la orden #<?php echo $orden['idOrden'] ?>?');">
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

    .form-control {
        border-radius: 8px;
        border: 1px solid #007bff;
        padding: 10px;
    }

    #calendar-container {
        margin-top: 30px;
    }

    #calendar {
        background-color: white;
        border-radius: 25px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .fc-event {
        border-radius: 8px;
        padding: 8px;
        text-align: center;
    }

    .fc-event:hover {
        background-color: #f39c12 !important;
        cursor: pointer;
    }

    .fc-toolbar {
        background-color: #007bff;
        color: white;
    }

    .fc-day {
        background-color: white;
        color: #333;
    }

    .fc-day.fc-day-today {
        background-color: #ffec99;
    }
</style>