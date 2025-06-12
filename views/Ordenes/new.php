<div class="card w-75 m-auto">
    <div class="card-header container">
        <h2 class="m-auto">Crear Nueva Orden</h2>
    </div>
    <div class="card-body">
        <form id="ordenForm" action="?controller=Ordenes&method=save" method="post">
            
            <!-- Cliente -->
            <div class="mb-3">
                <label for="idCliente" class="form-label">Cliente</label>
                <select name="idCliente" id="idCliente" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($usuarios as $cliente): ?>
                        <option value="<?php echo $cliente->id ?>"><?php echo $cliente->nombre . ' ' . $cliente->apellido ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Fecha Orden -->
            <div class="mb-3">
                <label for="Fecha_Orden" class="form-label">Fecha Orden</label>
                <input type="date" class="form-control" name="Fecha_Orden" id="Fecha_Orden" required>
            </div>

            <!-- Total -->
            <div class="mb-3">
                <label for="Total_Total" class="form-label">Total</label>
                <input type="number" class="form-control" name="Total_Total" id="Total_Total" required>
            </div>

            <!-- Cantidad Producto -->
            <div class="mb-3">
                <label for="Cantidad_Producto" class="form-label">Cantidad Producto</label>
                <input type="number" class="form-control" name="Cantidad_Producto" id="Cantidad_Producto" required>
            </div>

            <!-- Fecha Entrega -->
            <div class="mb-3">
                <label for="Fecha_Entrega" class="form-label">Fecha Entrega</label>
                <input type="date" class="form-control" name="Fecha_Entrega" id="Fecha_Entrega" required>
            </div>

            <!-- Producto Terminado -->
            <div class="mb-3">
                <label for="idProductosTerminados" class="form-label">Producto Terminado</label>
                <select name="idProductosTerminados" id="idProductosTerminados" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($productosTerminados as $producto): ?>
                        <option value="<?php echo $producto->idProductos ?>"><?php echo $producto->Nombre_Producto ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Materia Prima -->
            <div class="mb-3">
                <label for="idMateriaPrima" class="form-label">Materia Prima</label>
                <select name="idMateriaPrima" id="idMateriaPrima" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($materiasPrimas as $materia): ?>
                        <option value="<?php echo $materia->idProducto ?>"><?php echo $materia->Nombre ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Estado -->
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($estados as $estado): ?>
                        <option value="<?php echo $estado->idEstados ?>"><?php echo $estado->Estados ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Botón -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary" id="submit">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- Validación con JavaScript -->
<script>
    document.getElementById("ordenForm").addEventListener("submit", function(event) {
        const today = new Date();
        const currentYear = today.getFullYear();
        const startOfYear = new Date(currentYear, 0, 1);
        const startOfYearString = startOfYear.toISOString().split('T')[0];

        const fechaOrden = document.getElementById("Fecha_Orden").value;
        const total = parseFloat(document.getElementById("Total_Total").value);
        const cantidadProducto = parseInt(document.getElementById("Cantidad_Producto").value);
        const fechaEntrega = document.getElementById("Fecha_Entrega").value;

        // Fecha de orden no mayor que hoy
        if (fechaOrden > today.toISOString().split('T')[0]) {
            alert("La fecha de orden no puede ser mayor a la fecha actual.");
            event.preventDefault();
            return false;
        }

        // Fecha de orden no menor al 1 de enero
        if (fechaOrden < startOfYearString) {
            alert("La fecha de orden no puede ser menor al 1 de enero del año actual.");
            event.preventDefault();
            return false;
        }

        // Total no negativo
        if (total < 0) {
            alert("El total no puede ser negativo.");
            event.preventDefault();
            return false;
        }

        // Cantidad producto no negativa
        if (cantidadProducto < 0) {
            alert("La cantidad de producto no puede ser negativa.");
            event.preventDefault();
            return false;
        }

        // Fecha entrega no más de 6 meses después
        const fechaOrdenDate = new Date(fechaOrden);
        const fechaEntregaDate = new Date(fechaEntrega);
        const seisMesesDespues = new Date(fechaOrdenDate);
        seisMesesDespues.setMonth(fechaOrdenDate.getMonth() + 6);

        if (fechaEntregaDate > seisMesesDespues) {
            alert("La fecha de entrega no puede ser más de 6 meses después de la fecha de orden.");
            event.preventDefault();
            return false;
        }

        // Fecha entrega no menor al 1 de enero
        if (fechaEntrega < startOfYearString) {
            alert("La fecha de entrega no puede ser menor al 1 de enero del año actual.");
            event.preventDefault();
            return false;
        }

        return true;
    });
</script>
