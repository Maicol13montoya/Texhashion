<div class="card w-75 m-auto">
    <div class="card-header container">
        <h2 class="m-auto">Editar Producto</h2>
    </div>
   <form action="?controller=MateriaPriema&method=update" method="post" onsubmit="return validarFormulario()">
    <div class="card-body">
        <input type="hidden" id="idProducto" name="idProducto" value="<?php echo $datos[0]->idProducto; ?>">

        <div class="mb-3">
            <label for="Nombre" class="form-label">Nombre</label>
            <input type="text" id="Nombre" class="form-control" name="Nombre"
                value="<?php echo $datos[0]->Nombre; ?>" required
                oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
        </div>

        <div class="mb-3">
            <label for="Descripcion" class="form-label">Descripción</label>
            <textarea id="Descripcion" class="form-control" name="Descripcion" required><?php echo $datos[0]->Descripcion; ?></textarea>
        </div>

        <div class="mb-3">
            <label for="Fecha_Ingreso" class="form-label">Fecha de entrada</label>
            <input type="date" id="Fecha_Ingreso" class="form-control" name="Fecha_Ingreso"
                value="<?php echo $datos[0]->Fecha_Ingreso; ?>" required>
        </div>

        <div class="mb-3">
            <label for="Precio_Unidad" class="form-label">Precio Unidad</label>
            <input type="number" step="0.01" id="Precio_Unidad" class="form-control" name="Precio_Unidad"
                value="<?php echo $datos[0]->Precio_Unidad; ?>" required>
        </div>

        <div class="mb-3">
            <label for="Cantidad_Stock" class="form-label">Cantidad en stock</label>
            <input type="number" id="Cantidad_Stock" class="form-control" name="Cantidad_Stock"
                value="<?php echo $datos[0]->Cantidad_Stock; ?>" required>
        </div>

        <div class="mb-3">
            <label for="id_Proveedor" class="form-label">Proveedor</label>
            <select name="id_Proveedor" id="id_Proveedor" class="form-control" required>
                <option value="">Selección...</option>
                <?php foreach ($proveedores as $proveedor) { ?>
                    <option value="<?php echo $proveedor->id; ?>"
                        <?php echo $proveedor->id == $datos[0]->id_Proveedor ? 'selected' : ''; ?>>
                        <?php echo $proveedor->nombre . ' ' . $proveedor->apellido; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="categoria" class="form-label">Categorías</label>
            <select name="categoria" id="categoria" class="form-control" required>
                <option value="">Selección...</option>
                <?php foreach ($categorias as $categoria) { ?>
                    <option value="<?php echo $categoria->idCategoria; ?>"
                        <?php echo $categoria->idCategoria == $datos[0]->Categoria ? 'selected' : ''; ?>>
                        <?php echo $categoria->Categoria; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="Unidad_Medida" class="form-label">Unidad de Medida</label>
            <select name="Unidad_Medida" id="Unidad_Medida" class="form-control" required>
                <option value="">Selección...</option>
                <?php foreach ($unidadMedidas as $uni_med) { ?>
                    <option value="<?php echo $uni_med->MedidaID; ?>"
                        <?php echo $uni_med->MedidaID == $datos[0]->Unidad_Medida ? 'selected' : ''; ?>>
                        <?php echo $uni_med->Uni_Med; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="Fecha_Actualizacion" class="form-label">Fecha Actualización</label>
            <input type="date" id="Fecha_Actualizacion" class="form-control" name="Fecha_Actualizacion"
                value="<?php echo $datos[0]->Fecha_Actualizacion; ?>" required>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" id="estado" class="form-control" required>
                <option value="">Selección...</option>
                <?php foreach ($estados as $estado) { ?>
                    <option value="<?php echo $estado->idEstados; ?>"
                        <?php echo $estado->idEstados == $datos[0]->estado ? 'selected' : ''; ?>>
                        <?php echo $estado->Estados; ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
    </div>
</form>

<script>
    function validarFormulario() {
        var fechaIngreso = document.querySelector('[name="Fecha_Ingreso"]').value;
        var fechaActualizacion = document.querySelector('[name="Fecha_Actualizacion"]').value;
        var fechaActual = new Date().toISOString().split('T')[0];

        if (fechaIngreso > fechaActual) {
            alert("La fecha de ingreso no puede ser mayor que la fecha actual.");
            return false;
        }
        if (fechaActualizacion < fechaActual) {
            alert("La fecha de actualización no puede ser menor a la fecha actual.");
            return false;
        }

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

        var nombre = document.querySelector('[name="Nombre"]').value;
        var regexNombre = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
        if (!regexNombre.test(nombre)) {
            alert("El campo Nombre solo debe contener letras y espacios.");
            return false;
        }

        return true;
    }
</script>
