<?php

// Depuración: muestra el contenido de la variable
echo '<pre>';
var_dump($FacturasController);
echo '</pre>';
?>
<main class="container">
    <section class="col-md-12 text-left">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Comprobante de pago</h1>
            <a href="?controller=Facturas&method=add" class="btn btn-success">
                <i class="fas fa-plus"></i> <!-- Icono de agregar -->
            </a>
        </div>

        <section class="col-md-12 table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>idFacturas</th>
                        <th>Cantidad</th>
                        <th>Info producto</th>
                        <th>Fecha de emision</th>
                        <th>Precio total</th>
                        <th>Numero factura</th>
                        <th>Cliente</th>
                        <th>Lugar de factura</th>
                        <th>Estado de Factura</th>
                        <th>Fecha de Pago</th>
                        <th>Referencia de Pago</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($FacturasController as $Facturas): ?>
                        <tr>
                            <td><?php echo $Facturas->idFacturas ?></td>
                            <td><?php echo $Facturas->Cantidad ?></td>
                            <td><?php echo $Facturas->Nombre_Producto ?></td>
                            <td><?php echo $Facturas->Fecha_de_Emision ?></td>
                            <td><?php echo $Facturas->Precio_Total ?></td>
                            <td><?php echo $Facturas->Numero_Factura ?></td>
                            <td><?php echo $Facturas->nombre . ' ' . $Facturas->apellido ?></td>
                            <td><?php echo $Facturas->Direccion_Facturacion ?></td>
                            <td><?php echo $Facturas->EstadoNombre ?></td>
                            <td><?php echo $Facturas->Fecha_Pago ?></td>
                            <td><?php echo $Facturas->Referencia_Pago ?></td>
                            <td>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <a href="?controller=Facturas&method=edit&idFacturas=<?php echo $Facturas->idFacturas ?>"
                                        class="btn btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="?controller=Facturas&method=deleteOut&idFacturas=<?php echo $Facturas->idFacturas ?>"
                                        class="btn btn-danger"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este Comprobante De Pago?');">
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