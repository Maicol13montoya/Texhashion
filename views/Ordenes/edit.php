--------<div class="card w-75 m-auto">
    <div class="card-header container">
        <h2 class="m-auto">Editar Orden</h2>
    </div>

    <div class="card-body">
        <form id="ordenForm" action="?controller=Ordenes&method=update" method="post">
            <input type="hidden" id="idOrden" name="idOrden" value="<?php echo $data[0]->idOrden ?>">

            <div class="mb-3">
                <label class="form-label">Cliente</label>
                <select name="idCliente" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($usuarios as $cliente) {
                        $selected = ($cliente->id == $data[0]->idCliente) ? 'selected' : '';
                    ?>
                        <option value="<?php echo $cliente->id ?>" <?php echo $selected; ?>>
                            <?php echo $cliente->nombre . ' ' . $cliente->apellido ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha Orden</label>
                <input type="date" class="form-control" name="Fecha_Orden" value="<?php echo $data[0]->Fecha_Orden ?> " required>
                <div id="fechaOrdenError" class="text-danger" style="display:none;">La fecha de orden no puede ser mayor a la fecha actual.</div>
                <div id="fechaOrdenMinError" class="text-danger" style="display:none;">La fecha de orden no puede ser menor al 1 de enero del año actual.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Total</label>
                <input type="number" class="form-control" name="Total_Total" value="<?php echo $data[0]->Total_Total ?>" required>
                <div id="totalError" class="text-danger" style="display:none;">El total no puede ser negativo.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Cantidad Producto</label>
                <input type="number" class="form-control" name="Cantidad_Producto" value="<?php echo $data[0]->Cantidad_Producto ?>" required>
                <div id="cantidadError" class="text-danger" style="display:none;">La cantidad de producto no puede ser negativa.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha Entrega</label>
                <input type="date" class="form-control" name="Fecha_Entrega" value="<?php echo $data[0]->Fecha_Entrega ?>" required>
                <div id="fechaEntregaError" class="text-danger" style="display:none;">La fecha de entrega no puede ser más de 6 meses después de la fecha de orden.</div>
                <div id="fechaEntregaMinError" class="text-danger" style="display:none;">La fecha de entrega no puede ser menor al 1 de enero del año actual.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Producto Terminado</label>
                <select name="idProductosTerminados" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($productosTerminados as $producto) {
                        $selected = ($producto->idProductos == $data[0]->idProductosTerminados) ? 'selected' : '';
                    ?>
                        <option value="<?php echo $producto->idProductos ?>" <?php echo $selected; ?>>
                            <?php echo $producto->Nombre_Producto ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Materia Prima</label>
                <select name="idMateriaPrima" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($materiasPrimas as $materia) {
                        $selected = ($materia->id == $data[0]->idMateriaPrima) ? 'selected' : '';
                    ?>
                        <option value="<?php echo $materia->idProducto ?>" <?php echo $selected; ?>>
                            <?php echo $materia->Nombre ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($estados as $estado) {
                        $selected = ($estado->idEstados == $data[0]->Estado) ? 'selected' : '';
                    ?>
                        <option value="<?php echo $estado->idEstados ?>" <?php echo $selected; ?>>
                            <?php echo $estado->Estados ?>
                        </option>
                    <?php } ?>
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

        // Limpiar errores previos
        document.getElementById("fechaOrdenError").style.display = "none";
        document.getElementById("fechaOrdenMinError").style.display = "none";
        document.getElementById("totalError").style.display = "none";
        document.getElementById("cantidadError").style.display = "none";
        document.getElementById("fechaEntregaError").style.display = "none";
        document.getElementById("fechaEntregaMinError").style.display = "none";

        // Validación 1: La fecha de orden no puede ser mayor a la fecha actual
        if (fechaOrden > today.toISOString().split('T')[0]) {
            document.getElementById("fechaOrdenError").style.display = "block";
            event.preventDefault();
            return false;
        }

        // Validación 2: La fecha de orden no puede ser menor al 1 de enero del año actual
        if (fechaOrden < startOfYearString) {
            document.getElementById("fechaOrdenMinError").style.display = "block";
            event.preventDefault();
            return false;
        }

        // Validación 3: El total no puede ser negativo
        if (total < 0) {
            document.getElementById("totalError").style.display = "block";
            event.preventDefault();
            return false;
        }

        // Validación 4: La cantidad de producto no puede ser negativa
        if (cantidadProducto < 0) {
            document.getElementById("cantidadError").style.display = "block";
            event.preventDefault();
            return false;
        }
        if (fechaOrden < startOfYearString) {
            alert("La fecha de orden no puede ser menor al 1 de enero del año actual.");
            event.preventDefault(); // Detener el envío del formulario
            return false;
        }


        // Validación 5: La fecha de entrega no puede ser más de 6 meses después de la fecha de orden
        const fechaOrdenDate = new Date(fechaOrden);
        const fechaEntregaDate = new Date(fechaEntrega);
        const seisMesesDespues = new Date(fechaOrdenDate.setMonth(fechaOrdenDate.getMonth() + 6));

        if (fechaEntregaDate > seisMesesDespues) {
            document.getElementById("fechaEntregaError").style.display = "block";
            event.preventDefault();
            return false;
        }

        // Validación 6: La fecha de entrega no puede ser menor al 1 de enero del año actual
        if (fechaEntrega < startOfYearString) {
            document.getElementById("fechaEntregaMinError").style.display = "block";
            event.preventDefault();
            return false;
        }

        return true; // Permite el envío del formulario si todas las validaciones son correctas
    });
</script>