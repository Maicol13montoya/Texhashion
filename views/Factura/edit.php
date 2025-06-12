<div class="card w-75 m-auto">
    <div class="card-header container">
        <h2 class="m-auto">Actualizar Comprobante de pago</h2>
    </div>
    <form action="?controller=Facturas&method=update" method="post" onsubmit="return validarFormulario()">
        <div class="card-body">
            <input type="hidden" id="idFacturas" name="idFacturas" value="<?php echo $data[0]->idFacturas ?>">

           <div class="mb-3">
  <label for="cantidad" class="form-label">Cantidad</label>
  <input type="number" id="cantidad" name="cantidad" class="form-control">
</div>


            <div class="mb-3">
                <label class="form-label">Producto Terminado</label>
                <select name="Informacion_del_Producto" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($productosTerminados as $producto) {
                        if ($producto->idProductos == $data[0]->idProductosTerminados) {
                    ?>
                            <option selected value="<?php echo $producto->idProductos ?>"><?php echo $producto->Nombre_Producto ?></option>
                        <?php } else {   ?>
                            <option value="<?php echo $producto->idProductos ?>"><?php echo $producto->Nombre_Producto ?></option>
                    <?php   }
                    } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha Emision</label>
                <input type="date" class="form-control" name="Fecha_de_Emision" value="<?php echo $data[0]->Fecha_de_Emision ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Precio Total</label>
                <input type="number" class="form-control" name="Precio_Total" value="<?php echo $data[0]->Precio_Total ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Numero Factura</label>
                <input type=" number" class="form-control" name="Numero_Factura" id="numeroFactura" value="<?php echo $data[0]->Numero_Factura ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Lugar De Facturación</label>
                <select name="Direccion_Facturacion" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <option value="Carrera 7c #90" <?php echo $data[0]->Direccion_Facturacion == 'Carrera 7c #90' ? 'selected' : '' ?>>Carrera 7c #90</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Cliente</label>
                <select name="idCliente" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($usuarios as $proveedor) {
                        if ($proveedor->id == $data[0]->idCliente) {
                    ?>
                            <option selected value="<?php echo $proveedor->id ?>">
                                <?php echo $proveedor->NombreCompleto ?>
                            </option>
                        <?php } else { ?>
                            <option value="<?php echo $proveedor->id ?>">
                                <?php echo $proveedor->NombreCompleto ?>
                            </option>
                    <?php }
                    } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select name="Estado_Factura" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($estados as $estado) {
                        if ($estado->idEstados == $data[0]->Estado_Factura) {
                    ?>
                            <option selected value="<?php echo $estado->idEstados ?>"><?php echo $estado->Estados ?></option>
                        <?php } else {
                        ?>
                            <option value="<?php echo $estado->idEstados ?>"><?php echo $estado->Estados ?></option>
                    <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha de pago</label>
                <input type="date" class="form-control" name="Fecha_Pago" value="<?php echo $data[0]->Fecha_Pago ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Referencia de factura</label>
                <input type="text" class="form-control" name="Referencia_Pago" value="<?php echo $data[0]->Referencia_Pago ?>" required>
            </div>

            <div class="form-group">
                <button class="btn btn-primary" id="submit">Actualizar</button>
            </div>
        </div>
    </form>
</div>
<script>
    function validarFormulario() {
        // Obtener la fecha actual en formato yyyy-mm-dd
        var fechaActual = new Date().toISOString().split('T')[0]; // Solo la parte de la fecha, sin hora

        // Validación para la cantidad no sea negativa
        var cantidad = document.querySelector('[name="Cantidad"]').value;
        if (cantidad < 0) {
            alert("La cantidad no puede ser negativa.");
            return false;
        }


        // Validación para el precio no sea negativo
        var precioTotal = document.querySelector('[name="Precio_Total"]').value;
        if (precioTotal < 0) {
            alert("El precio total no puede ser negativo.");
            return false;
        }

        // Validación para la fecha de pago no mayor que la fecha actual
        var fechaPago = document.querySelector('[name="Fecha_Pago"]').value;
        if (fechaPago > fechaActual) {
            alert("La fecha de pago no puede ser mayor a la fecha actual.");
            return false;
        }

        return true; // Permite el envío del formulario
    }
</script>
