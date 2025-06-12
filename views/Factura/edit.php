<div class="card w-75 m-auto">
    <div class="card-header text-center">
        <h2>Actualizar Comprobante de Pago</h2>
    </div>
    <form action="?controller=Facturas&method=update" method="post" onsubmit="return validarFormulario()">
        <div class="card-body">
            <input type="hidden" id="idFacturas" name="idFacturas" value="<?php echo $datos[0]->idFacturas; ?>">

            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" id="cantidad" name="Cantidad" class="form-control" value="<?php echo $datos[0]->Cantidad; ?>" required>
            </div>

            <div class="mb-3">
                <label for="Informacion_del_Producto" class="form-label">Producto Terminado</label>
                <select name="Informacion_Producto" id="Informacion_del_Producto" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($productosTerminados as $producto) {
                        $selected = ($producto->idProductos == $datos[0]->idProductosTerminados) ? 'selected' : '';
                        echo "<option value=\"$producto->idProductos\" $selected>$producto->Nombre_Producto</option>";
                    } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="Fecha_de_Emision" class="form-label">Fecha de emisión</label>
                <input type="date" id="Fecha_de_Emision" name="Fecha_de_Emision" class="form-control" value="<?php echo $datos[0]->Fecha_de_Emision; ?>" required>
            </div>

            <div class="mb-3">
                <label for="Precio_Total" class="form-label">Precio total</label>
                <input type="number" id="Precio_Total" name="Precio_Total" class="form-control" value="<?php echo $datos[0]->Precio_Total; ?>" required>
            </div>

            <div class="mb-3">
                <label for="numeroFactura" class="form-label">Número de Factura</label>
                <input type="number" id="numeroFactura" name="Numero_Factura" class="form-control" value="<?php echo $datos[0]->Numero_Factura; ?>" required>
            </div>

            <div class="mb-3">
                <label for="Direccion_Facturacion" class="form-label">Lugar de Facturación</label>
                <select name="Direccion_Facturacion" id="Direccion_Facturacion" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <option value="Carrera 7c #90" <?php echo ($datos[0]->Direccion_Facturacion == 'Carrera 7c #90') ? 'selected' : ''; ?>>Carrera 7c #90</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="idCliente" class="form-label">Cliente</label>
                <select name="idCliente" id="idCliente" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($usuarios as $proveedor) {
                        $selected = ($proveedor->id == $datos[0]->idCliente) ? 'selected' : '';
                        echo "<option value=\"$proveedor->id\" $selected>$proveedor->Nombre_Completo</option>";
                    } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="Estado_Factura" class="form-label">Estado</label>
                <select name="Estado_Factura" id="Estado_Factura" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($estados as $estado) {
                        $selected = ($estado->idEstados == $datos[0]->Estado_Factura) ? 'selected' : '';
                        echo "<option value=\"$estado->idEstados\" $selected>$estado->Estados</option>";
                    } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="Fecha_Pago" class="form-label">Fecha de Pago</label>
                <input type="date" id="Fecha_Pago" name="Fecha_Pago" class="form-control" value="<?php echo $datos[0]->Fecha_Pago; ?>" required>
            </div>

            <div class="mb-3">
                <label for="Referencia_Pago" class="form-label">Referencia de Factura</label>
                <input type="text" id="Referencia_Pago" name="Referencia_Pago" class="form-control" value="<?php echo $datos[0]->Referencia_Pago; ?>" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </div>
    </form>
</div>

<script>
    function validarFormulario() {
        const fechaActual = new Date().toISOString().split('T')[0];
        const cantidad = document.querySelector('[name="Cantidad"]').value;
        const precioTotal = document.querySelector('[name="Precio_Total"]').value;
        const fechaPago = document.querySelector('[name="Fecha_Pago"]').value;

        if (cantidad < 0) {
            alert("La cantidad no puede ser negativa.");
            return false;
        }

        if (precioTotal < 0) {
            alert("El precio total no puede ser negativo.");
            return false;
        }

        if (fechaPago > fechaActual) {
            alert("La fecha de pago no puede ser mayor a la fecha actual.");
            return false;
        }

        return true;
    }
</script>
