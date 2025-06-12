<div class="card w-75 m-auto">
    <div class="card-header container">
        <h2 class="m-auto">Editar Producto</h2>
    </div>
    <form action="?controller=MateriaPriema&method=update" method="post" onsubmit="return validarFormulario()">
        <div class="card-body">
            <input type="hidden" id="idProducto" name="idProducto" value="<?php echo $data[0]->idProducto ?>">
            
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" id="nombre" class="form-control" name="Nombre" 
                       value="<?php echo $data[0]->Nombre ?>" required
                       oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea id="descripcion" class="form-control" name="Descripcion" required><?php echo $data[0]->Descripcion ?></textarea>
            </div>

            <div class="mb-3">
                <label for="fecha_ingreso" class="form-label">Fecha ENTRADA</label>
                <input type="date" id="fecha_ingreso" class="form-control" name="Fecha_Ingreso" 
                       value="<?php echo $data[0]->Fecha_Ingreso ?>" required>
            </div>

            <div class="mb-3">
                <label for="precio_unidad" class="form-label">Precio Unidad</label>
                <input type="number" id="precio_unidad" step="0.01" class="form-control" name="Precio_Unidad" 
                       value="<?php echo $data[0]->Precio_Unidad ?>" required>
            </div>

            <div class="mb-3">
                <label for="cantidad_stock" class="form-label">Cantidad en Stock</label>
                <input type="number" id="cantidad_stock" class="form-control" name="Cantidad_Stock" 
                       value="<?php echo $data[0]->Cantidad_Stock ?>" required>
            </div>

            <div class="mb-3">
                <label for="id_proveedor" class="form-label">Proveedor</label>
                <select name="id_Proveedor" id="id_proveedor" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($proveedores as $proveedor) { ?>
                        <option value="<?php echo $proveedor->id ?>" <?php echo $proveedor->id == $data[0]->id_Proveedor ? 'selected' : '' ?>>
                            <?php echo $proveedor->nombre . ' ' . $proveedor->apellido ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categorías</label>
                <select name="categoria" id="categoria" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($categorias as $categoria) { ?>
                        <option value="<?php echo $categoria->idCategoria ?>" <?php echo $categoria->idCategoria == $data[0]->Categoria ? 'selected' : '' ?>>
                            <?php echo $categoria->Categoria ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="unidad_medida" class="form-label">Unidad de Medida</label>
                <select name="Unidad_Medida" id="unidad_medida" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($unidadMedidas as $uni_med) { ?>
                        <option value="<?php echo $uni_med->MedidaID ?>" <?php echo $uni_med->MedidaID == $data[0]->Unidad_Medida ? 'selected' : '' ?>>
                            <?php echo $uni_med->Uni_Med ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha_actualizacion" class="form-label">Fecha Actualización</label>
                <input type="date" id="fecha_actualizacion" class="form-control" name="Fecha_Actualizacion" 
                       value="<?php echo $data[0]->Fecha_Actualizacion ?>" required>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select name="estado" id="estado" class="form-control" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($estados as $estado) { ?>
                        <option value="<?php echo $estado->idEstados ?>" <?php echo $estado->idEstados == $data[0]->Estado ? 'selected' : '' ?>>
                            <?php echo $estado->Estados ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" id="submit">Actualizar</button>
            </div>
        </div>
    </form>
</div>

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
