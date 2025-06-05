<div class="card w-75 m-auto">
    <div class="card-header container">
        <h2 class="m-auto">Editar Producto</h2>
    </div>
    <form action="?controller=MateriaPrima&method=update" method="post" onsubmit="return validarFormulario()">
        <div class="card-body">
            <input type="hidden" id="idProducto" name="idProducto" value="<?php echo $data[0]->idProducto ?>">

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="Nombre" value="<?php echo $data[0]->Nombre ?>" required
                    oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea type="text" class="form-control" name="Descripcion" required><?php echo $data[0]->Descripcion ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha Ingreso</label>
                <input type="date" class="form-control" name="Fecha_Ingreso" value="<?php echo $data[0]->Fecha_Ingreso ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Precio Unidad</label>
                <div class="mb-3">
                    <label class="form-label">Proveedor</label>
                    <select name="id_Proveedor" class="form-control" required>
                        <option value="">Seleccione...</option>
                        <?php foreach ($proveedores as $proveedor) { ?>
                            <option value="<?php echo $proveedor->id ?>" <?php echo $proveedor->id == $data[0]->id_Proveedor ? 'selected' : '' ?>>
                                <?php echo $proveedor->nombre . ' ' . $proveedor->apellido ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Categoría</label>
                    <select name="categoria" class="form-control" required>
                        <option value="">Seleccione...</option>
                        <?php foreach ($categorias as $categoria) { ?>
                            <option value="<?php echo $categoria->idCategoria ?>" <?php echo $categoria->idCategoria == $data[0]->Categoria ? 'selected' : '' ?>>
                                <?php echo $categoria->Categoria ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Unidad de Medida</label>
                    <select name="Unidad_Medida" class="form-control" required>
                        <option value="">Seleccione...</option>
                        <?php foreach ($unidadMedidas as $uni_med) { ?>
                            <option value="<?php echo $uni_med->MedidaID ?>" <?php echo $uni_med->MedidaID == $data[0]->Unidad_Medida ? 'selected' : '' ?>>
                                <?php echo $uni_med->Uni_Med ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Fecha Actualización</label>
                    <input type="date" class="form-control" name="Fecha_Actualizacion" value="<?php echo $data[0]->Fecha_Actualizacion ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-control" required>
                        <option value="">Seleccione...</option>
                        <?php foreach ($estados as $estado) { ?>
                            <option value="<?php echo $estado->idEstados ?>" <?php echo $estado->idEstados == $data[0]->Estado ? 'selected' : '' ?>>
                                <?php echo $estado->Estados ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" id="submit">Actualizar</button>
                </div>
            </div>
    </form>
</div>

<script>
    function validarFormulario() {
        // Obtener las fechas
        var fechaIngreso = document.querySelector('[name="Fecha_Ingreso"]').value;
        var fechaActualizacion = document.querySelector('[name="Fecha_Actualizacion"]').value;
        var fechaActual = new Date().toISOString().split('T')[0];

        // Validación de fechas
        if (fechaIngreso > fechaActual) {
            alert("La fecha de ingreso no puede ser mayor que la fecha actual.");
            return false;
        }

        if (fechaActualizacion < fechaActual) {
            alert("La fecha de actualización no puede ser menor a la fecha actual.");
            return false;
        }

        // Validación de campos numéricos
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

        // Validación del nombre (sólo letras y espacios)
        var nombre = document.querySelector('[name="Nombre"]').value;
        var regexNombre = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;

        if (!regexNombre.test(nombre)) {
            alert("El campo Nombre solo debe contener letras y espacios.");
            return false;
        }

        return true;
    }
</script>