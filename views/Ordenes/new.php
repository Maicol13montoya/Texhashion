<div class="card w-75 m-auto">
    <div class="card-header container">
        <h2 class="m-auto">Crear Nueva Orden</h2>
    </div>

    <div class="card-body">
        <form id="ordenForm" action="?controller=Ordenes&method=save" method="post">
            <div class="mb-3">
                <label class="form-label">Cliente</label>
                <select name="idCliente" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($usuarios as $cliente): ?>
                        <option value="<?php echo $cliente->id ?>"><?php echo $cliente->nombre . ' ' . $cliente->apellido ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha Orden</label>
                <input type="date" class="form-control" name="Fecha_Orden" id="Fecha_Orden" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Total</label>
                <input type="number" class="form-control" name="Total_Total" id="Total_Total" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Cantidad Producto</label>
                <input type="number" class="form-control" name="Cantidad_Producto" id="Cantidad_Producto" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha Entrega</label>
                <input type="date" class="form-control" name="Fecha_Entrega" id="Fecha_Entrega" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Producto Terminado</label>
                <select name="idProductosTerminados" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($productosTerminados as $producto): ?>
                        <option value="<?php echo $producto->idProductos ?>"><?php echo $producto->Nombre_Producto ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Materia Prima</label>
                <select name="idMateriaPrima" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($materiasPrimas as $materia): ?>
                        <option value="<?php echo $materia->idProducto ?>"><?php echo $materia->Nombre ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($estados as $estado): ?>
                        <option value="<?php echo $estado->idEstados ?>"><?php echo $estado->Estados ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <button class="btn btn-primary" id="submit">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById("ordenForm").addEventListener("submit", function(event) {
        // Obtener la fecha actual y el año actual
        const today = new Date();
        const currentYear = today.getFullYear();

        // Definir el primer día del año actual
        const startOfYear = new Date(currentYear, 0, 1); // 1 de enero del año actual
        const startOfYearString = startOfYear.toISOString().split('T')[0]; // Formato YYYY-MM-DD

        // Obtener los valores de los campos del formulario
        const fechaOrden = document.getElementById("Fecha_Orden").value;
        const total = parseFloat(document.getElementById("Total_Total").value);
        const cantidadProducto = parseInt(document.getElementById("Cantidad_Producto").value);
        const fechaEntrega = document.getElementById("Fecha_Entrega").value;

        // Validación 1: La fecha de orden no puede ser mayor a la fecha actual
        if (fechaOrden > today.toISOString().split('T')[0]) {
            alert("La fecha de orden no puede ser mayor a la fecha actual.");
            event.preventDefault(); // Detener el envío del formulario
            return false;
        }

        // Validación 2: La fecha de orden no puede ser menor al 1 de enero del año actual
        if (fechaOrden < startOfYearString) {
            alert("La fecha de orden no puede ser menor al 1 de enero del año actual.");
            event.preventDefault(); // Detener el envío del formulario
            return false;
        }

        // Validación 3: El total no puede ser negativo
        if (total < 0) {
            alert("El total no puede ser negativo.");
            event.preventDefault(); // Detener el envío del formulario
            return false;
        }

        // Validación 4: La cantidad de producto no puede ser negativa
        if (cantidadProducto < 0) {
            alert("La cantidad de producto no puede ser negativa.");
            event.preventDefault(); // Detener el envío del formulario
            return false;
        }

        // Validación 5: La fecha de entrega no puede ser más de 6 meses después de la fecha de orden
        const fechaOrdenDate = new Date(fechaOrden);
        const fechaEntregaDate = new Date(fechaEntrega);
        const seisMesesDespues = new Date(fechaOrdenDate.setMonth(fechaOrdenDate.getMonth() + 6));

        if (fechaEntregaDate > seisMesesDespues) {
            alert("La fecha de entrega no puede ser más de 6 meses después de la fecha de orden.");
            event.preventDefault(); // Detener el envío del formulario
            return false;
        }

        // Validación 6: La fecha de entrega no puede ser menor al 1 de enero del año actual
        if (fechaEntrega < startOfYearString) {
            alert("La fecha de entrega no puede ser menor al 1 de enero del año actual.");
            event.preventDefault(); // Detener el envío del formulario
            return false;
        }

        return true; // Permite el envío del formulario si todas las validaciones son correctas
    });
</script>
