<div class="card w-75 m-auto">
    <div class="card-header container">
        <h2 class="m-auto">Crear Producto Terminado</h2>
    </div>
    <form action="?controller=ProductosTerminados&method=saveProductoTerminado" method="post" id="formProductoTerminado">
        <div class="card-body">
            <input type="hidden" id="idProductos" name="idProductos" required>

            <!-- Nombre del Producto -->
            <div class="mb-3">
                <label for="nombreProducto" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" name="Nombre_Producto" id="nombreProducto" required>
            </div>

            <!-- Cantidad Disponible -->
            <div class="mb-3">
                <label for="cantidadDisponible" class="form-label">Cantidad Disponible</label>
                <input type="number" class="form-control" name="Cantidad_Disponible" id="cantidadDisponible" min="0" required>
            </div>

            <!-- Descripción -->
            <div class="mb-3">
                <label for="descripcionPT" class="form-label">Descripción</label>
                <textarea class="form-control" name="DescripcionPT" id="descripcionPT" required></textarea>
            </div>

            <!-- Fecha de Entrada -->
            <div class="mb-3">
                <label for="fechaEntrada" class="form-label">Fecha de Entrada</label>
                <input type="date" class="form-control" name="Fecha_Entrada" id="fechaEntrada" required>
            </div>

            <!-- Fecha de Salida -->
            <div class="mb-3">
                <label for="fechaSalida" class="form-label">Fecha de Salida</label>
                <input type="date" class="form-control" name="Fecha_Salida" id="fechaSalida" required>
            </div>

            <!-- Materia Prima -->
            <div class="mb-3">
                <label for="materiaPrima" class="form-label">Materia Prima</label>
                <select name="idmateria_prima" id="materiaPrima" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($materiaPrima as $materia): ?>
                        <option value="<?php echo $materia->idProducto ?>"><?php echo $materia->Nombre ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Estado -->
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="idEstado" id="estado" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($estados as $estado): ?>
                        <option value="<?php echo $estado->idEstados ?>"><?php echo $estado->Estados ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Botón -->
            <div class="form-group">
                <button class="btn btn-primary" id="submit">Crear</button>
            </div>
        </div>
    </form>
</div>

<!-- Validaciones en JavaScript -->
<script>
    // Validación en tiempo real del nombre del producto (solo letras y espacios)
    document.getElementById('nombreProducto').addEventListener('input', function(e) {
        const input = e.target.value;
        const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]*$/;
        if (!soloLetras.test(input)) {
            e.target.value = input.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
        }
    });

    // Validaciones al enviar el formulario
    document.getElementById('formProductoTerminado').addEventListener('submit', function(e) {
        const cantidad = document.getElementById('cantidadDisponible').value;
        if (parseInt(cantidad) < 0) {
            e.preventDefault();
            alert('La cantidad disponible no puede ser negativa.');
            return;
        }

        const nombreProducto = document.getElementById('nombreProducto').value;
        const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
        if (!soloLetras.test(nombreProducto)) {
            e.preventDefault();
            alert('El nombre del producto solo puede contener letras y espacios.');
            return;
        }

        const fechaEntrada = document.getElementById('fechaEntrada').value;
        const fechaSalida = document.getElementById('fechaSalida').value;

        const hoy = new Date();
        hoy.setHours(0, 0, 0, 0);
        const fechaEntradaObj = new Date(fechaEntrada);
        fechaEntradaObj.setHours(0, 0, 0, 0);

        if (fechaEntradaObj < hoy) {
            e.preventDefault();
            alert('La fecha de entrada no puede ser menor a la fecha actual.');
            return;
        }

        const salida = new Date(fechaSalida);
        salida.setHours(0, 0, 0, 0);

        if (salida < fechaEntradaObj) {
            e.preventDefault();
            alert('La fecha de salida no puede ser menor que la fecha de entrada.');
            return;
        }

        const limite = new Date(fechaEntradaObj);
        limite.setMonth(limite.getMonth() + 2);

        if (salida > limite) {
            e.preventDefault();
            alert('La fecha de salida no puede ser más de dos meses después de la fecha de entrada.');
            return;
        }

        const materiaPrima = document.getElementById('materiaPrima').value;
        if (materiaPrima === "") {
            e.preventDefault();
            alert('Debe seleccionar una materia prima.');
            return;
        }

        const estado = document.getElementById('estado').value;
        if (estado === "") {
            e.preventDefault();
            alert('Debe seleccionar un estado.');
            return;
        }
    });
</script>
