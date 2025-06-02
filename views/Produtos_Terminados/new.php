<div class="card w-75 m-auto">
    <div class="card-header container">
        <h2 class="m-auto">Crear Producto Terminado</h2>
    </div>
    <form action="?controller=ProductosTerminados&method=saveProductoTerminado" method="post" id="formProductoTerminado">
        <div class="card-body">
            <input type="hidden" id="idProductos" name="idProductos" required>

            <!-- Nombre del Producto -->
            <div class="mb-3">
                <label class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" name="Nombre_Producto" id="nombreProducto" required>
            </div>

            <!-- Cantidad Disponible -->
            <div class="mb-3">
                <label class="form-label">Cantidad Disponible</label>
                <input type="number" class="form-control" name="Cantidad_Disponible" min="0" required>
            </div>

            <!-- Descripción -->
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" name="DescripcionPT" required></textarea>
            </div>

            <!-- Fecha de Entrada -->
            <div class="mb-3">
                <label class="form-label">Fecha de Entrada</label>
                <input type="date" class="form-control" name="Fecha_Entrada" required>
            </div>

            <!-- Fecha de Salida -->
            <div class="mb-3">
                <label class="form-label">Fecha de Salida</label>
                <input type="date" class="form-control" name="Fecha_Salida" required>
            </div>

            <!-- Materia Prima -->
            <div class="mb-3">
                <label class="form-label">Materia Prima</label>
                <select name="idmateria_prima" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($materiaPrima as $materia): ?>
                        <option value="<?php echo $materia->idProducto ?>"><?php echo $materia->Nombre ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Estado -->
            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select name="idEstado" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($estados as $estado): ?>
                        <option value="<?php echo $estado->idEstados ?>"><?php echo $estado->Estados ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <button class="btn btn-primary" id="submit">Crear</button>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('nombreProducto').addEventListener('input', function(e) {
        const input = e.target.value;
        const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]*$/;

        // Si el valor no coincide con el patrón, elimina el último carácter
        if (!soloLetras.test(input)) {
            e.target.value = input.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
        }
    });
    document.getElementById('formProductoTerminado').addEventListener('submit', function(e) {
        const cantidad = document.querySelector('input[name="Cantidad_Disponible"]').value;
        if (parseInt(cantidad) < 0) {
            e.preventDefault();
            alert('La cantidad disponible no puede ser negativa.');
            return;
        }

        const nombreProducto = document.querySelector('input[name="Nombre_Producto"]').value;
        const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;

        if (!soloLetras.test(nombreProducto)) {
            e.preventDefault();
            alert('El nombre del producto solo puede contener letras y espacios.');
            return;
        }

        const fechaEntrada = document.querySelector('input[name="Fecha_Entrada"]').value;
        const fechaActual = new Date().toISOString().split('T')[0];
        if (fechaEntrada < fechaActual) {
            e.preventDefault();
            alert('La fecha de entrada no puede ser menor a la fecha actual.');
            return;
        }

        const fechaSalida = document.querySelector('input[name="Fecha_Salida"]').value;
        const entrada = new Date(fechaEntrada);
        entrada.setMonth(entrada.getMonth() + 2);
        const fechaLimite = entrada.toISOString().split('T')[0];
        if (fechaSalida > fechaLimite) {
            e.preventDefault();
            alert('La fecha de salida no puede ser más de dos meses después de la fecha de entrada.');
            return;
        }
    });
</script>