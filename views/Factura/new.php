<div class="card w-75 m-auto">
    <div class="card-header container">
        <h2 class="m-auto">Crear Comprobante de pago</h2>
    </div>

   <div class="card-body">
    <form action="?controller=Facturas&method=save" method="post" onsubmit="return validarFormulario()">
        <div class="mb-3">
            <label for="Cantidad" class="form-label">Cantidad</label>
            <input type="number" id="Cantidad" class="form-control" name="Cantidad" required>
        </div>
        <div class="mb-3">
            <label for="Informacion_del_Producto" class="form-label">Información del producto</label>
            <select name="Informacion_del_Producto" id="Informacion_del_Producto" class="form-control" required>
                <option value="">Selección...</option>
                <?php foreach($productosTerminados as $producto): ?>
                    <option value="<?php echo $producto->idProductos; ?>"><?php echo $producto->Nombre_Producto; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="Fecha_de_Emision" class="form-label">Fecha de emisión</label>
            <input type="date" id="Fecha_de_Emision" class="form-control" name="Fecha_de_Emision" required>
        </div>
        <div class="mb-3">
            <label for="Precio_Total" class="form-label">Precio total</label>
            <input type="number" id="Precio_Total" class="form-control" name="Precio_Total" required>
        </div>
        <div class="mb-3">
            <label for="Numero_Factura" class="form-label">Número Factura</label>
            <input type="number" id="Numero_Factura" class="form-control" name="Numero_Factura" required>
        </div>
        <div class="mb-3">
            <label for="Direccion_Facturacion" class="form-label">Lugar de Facturación</label>
            <select name="Direccion_Facturacion" id="Direccion_Facturacion" class="form-control" required>
                <option value="">Selección...</option>
                <option value="Carrera 7c #90">Carrera 7c #90</option>
                <!-- Puedes agregar más opciones aquí si es necesario -->
            </select>
        </div>
        <div class="mb-3">
            <label for="idCliente" class="form-label">Cliente</label>
            <select name="idCliente" id="idCliente" class="form-control" required>
                <option value="">Selección...</option>
                <?php foreach($clientes as $cliente): ?>
                    <option value="<?php echo $cliente->id; ?>"><?php echo $cliente->Nombre_completo; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="Estado_Factura" class="form-label">Estado</label>
            <select name="Estado_Factura" id="Estado_Factura" class="form-control" required>
                <option value="">Selección...</option>
                <?php foreach($estados as $estado): ?>
                    <option value="<?php echo $estado->idEstados; ?>"><?php echo $estado->Estados; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="Fecha_Pago" class="form-label">Fecha de pago</label>
            <input type="date" id="Fecha_Pago" class="form-control" name="Fecha_Pago" required>
        </div>
        <div class="mb-3">
            <label for="Referencia_Pago" class="form-label">Referencia de pago</label>
            <input type="text" id="Referencia_Pago" class="form-control" name="Referencia_Pago" required>
        </div>
    </form>
</div>

            <div class="form-group">
                <button class="btn btn-primary" id="submit">Guardar</button>
            </div>
        </form>
    </div>
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
