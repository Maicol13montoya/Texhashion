<div class="card w-75 m-auto">
    <div class="card-header container">
        <h2 class="m-auto">Crear Nuevo Producto</h2>
    </div>

    <div class="card-body">
        <form action="?controller=MateriaPriema&method=save" method="post" onsubmit="return validarFormulario()">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="Nombre" pattern="[A-Za-z\s]+" title="Solo se permiten letras y espacios" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea type="text" class="form-control" name="Descripcion" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Fecha Ingreso</label>
                <input type="date" class="form-control" name="Fecha_Ingreso" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Precio Unidad</label>
                <input type="number" class="form-control" name="Precio_Unidad" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Cantidad Stock</label>
                <input type="number" class="form-control" name="Cantidad_Stock" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Proveedor</label>
                <select name="id_Proveedor" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($usuarios as $proveedor): ?>
                        <option value="<?php echo $proveedor->id ?>"><?php echo $proveedor->nombre . ' ' . $proveedor->apellido ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Categoría</label>
                <select name="categoria" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo $categoria->idCategoria ?>"><?php echo $categoria->Categoria ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Unidad de Medida</label>
                <select name="Unidad_Medida" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($unidad_medidas as $uni_med): ?>
                        <option value="<?php echo $uni_med->MedidaID ?>"><?php echo $uni_med->Uni_Med ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha Actualización</label>
                <input type="date" class="form-control" name="Fecha_Actualizacion" required>
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
    // Impedir ingreso de números y caracteres no válidos en el campo Nombre
    document.getElementById('nombreProducto').addEventListener('input', function(e) {
        let valor = e.target.value;
        // Solo letras mayúsculas, minúsculas, tildes y espacios
        e.target.value = valor.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
    });

    // Obtener las fechas de ingreso y actualización
    var fechaIngreso = document.querySelector('[name="Fecha_Ingreso"]').value;
    var fechaActualizacion = document.querySelector('[name="Fecha_Actualizacion"]').value;

    // Obtener la fecha actual en formato yyyy-mm-dd
    var fechaActual = new Date().toISOString().split('T')[0]; // Solo la parte de la fecha, sin hora

    // Validación para la fecha de ingreso no mayor que la fecha actual
    if (fechaIngreso > fechaActual) {
        alert("La fecha de ingreso no puede ser mayor que la fecha actual.");
        return false;
    }

    // Validación para la fecha de actualización no menor a la fecha actual
    if (fechaActualizacion < fechaActual) {
        alert("La fecha de actualización no puede ser menor a la fecha actual.");
        return false;
    }

    // Validación para precios y cantidades no sean negativos
    var precioUnidad = parseFloat(document.querySelector('[name="Precio_Unidad"]').value);
    var cantidadStock = parseInt(document.querySelector('[name="Cantidad_Stock"]').value);

    if (precioUnidad < 0) {
        alert("El precio de unidad no puede ser negativo.");
        return false;
    }
    if (cantidadStock < 0) {
        alert("La cantidad en stock no puede ser negativa.");
        return false;
    }

    return true; // Permite el envío del formulario
</script>