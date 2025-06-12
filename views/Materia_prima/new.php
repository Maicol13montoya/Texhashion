<div class="card w-75 m-auto">
    <div class="card-header container">
        <h2 class="m-auto">Crear Nuevo Producto</h2>
    </div>
    <div class="card-body">
        <form action="?controller=MateriaPrima&method=save" method="post" onsubmit="return validarFormulario()">
            <div class="mb-3">
                <label for="nombreProducto" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombreProducto" name="Nombre" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="Solo se permiten letras y espacios" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="Descripcion" required></textarea>
            </div>
            <div class="mb-3">
                <label for="fechaIngreso" class="form-label">Fecha Ingreso</label>
                <input type="date" class="form-control" id="fechaIngreso" name="Fecha_Ingreso" required>
            </div>
            <div class="mb-3">
                <label for="precioUnidad" class="form-label">Precio Unidad</label>
                <input type="number" class="form-control" id="precioUnidad" name="Precio_Unidad" required>
            </div>
            <div class="mb-3">
                <label for="cantidadStock" class="form-label">Cantidad Stock</label>
                <input type="number" class="form-control" id="cantidadStock" name="Cantidad_Stock" required>
            </div>
            <div class="mb-3">
                <label for="id_Proveedor" class="form-label">Proveedor</label>
                <select id="id_Proveedor" name="id_Proveedor" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($usuarios as $proveedor): ?>
                        <option value="<?php echo $proveedor->id ?>"><?php echo $proveedor->nombre . ' ' . $proveedor->apellido ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <select id="categoria" name="categoria" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo $categoria->idCategoria ?>"><?php echo $categoria->Categoria ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="unidadMedida" class="form-label">Unidad de Medida</label>
                <select id="unidadMedida" name="Unidad_Medida" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($unidad_medidas as $uni_med): ?>
                        <option value="<?php echo $uni_med->MedidaID ?>"><?php echo $uni_med->Uni_Med ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="fechaActualizacion" class="form-label">Fecha Actualización</label>
                <input type="date" class="form-control" id="fechaActualizacion" name="Fecha_Actualizacion" required>
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select id="estado" name="estado" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($estados as $estado): ?>
                        <option value="<?php echo $estado->idEstados ?>"><?php echo $estado->Estados ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Solo permitir letras en el campo de nombre
    document.getElementById('nombreProducto').addEventListener('input', function (e) {
        e.target.value = e.target.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
    });

    function validarFormulario() {
        const fechaIngreso = document.getElementById('fechaIngreso').value;
        const fechaActualizacion = document.getElementById('fechaActualizacion').value;
        const fechaActual = new Date().toISOString().split('T')[0];

        const precioUnidad = parseFloat(document.getElementById('precioUnidad').value);
        const cantidadStock = parseInt(document.getElementById('cantidadStock').value);

        if (fechaIngreso > fechaActual) {
            alert("La fecha de ingreso no puede ser mayor que la fecha actual.");
            return false;
        }

        if (fechaActualizacion < fechaActual) {
            alert("La fecha de actualización no puede ser menor que la fecha actual.");
            return false;
        }

        if (isNaN(precioUnidad) || precioUnidad < 0) {
            alert("El precio de unidad no puede ser negativo o vacío.");
            return false;
        }

        if (isNaN(cantidadStock) || cantidadStock < 0) {
            alert("La cantidad en stock no puede ser negativa o vacía.");
            return false;
        }

        return true;
    }
</script>
