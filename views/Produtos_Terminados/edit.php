<div class="card w-75 m-auto">
    <div class="card-header container">
        <h2 class="m-auto">Actualizar Producto Terminado</h2>
    </div>
    <form action="?controller=ProductosTerminados&method=update" method="post" id="formProductoTerminado">
        <div class="card-body">
            <input type="hidden" id="idProductos" name="idProductos" value="<?php echo $data[0]->idProductos ?>">
            
            <!-- Nombre del Producto -->
            <div class="mb-3">
                <label class="form-label" for="nombreProducto">Nombre del Producto</label>
                <input type="text" class="form-control" name="Nombre_Producto" id="nombreProducto" 
                       value="<?php echo $data[0]->Nombre_Producto ?>" required>
            </div>
            
            <!-- Cantidad Disponible -->
            <div class="mb-3">
                <label class="form-label" for="cantidadDisponible">Cantidad Disponible</label>
                <input type="number" class="form-control" name="Cantidad_Disponible" id="cantidadDisponible" 
                       value="<?php echo $data[0]->Cantidad_Disponible ?>" min="0" required>
            </div>
            
            <!-- Descripción -->
            <div class="mb-3">
                <label class="form-label" for="descripcion">Descripción</label>
                <textarea class="form-control" name="DescripcionPT" id="descripcion" required><?php echo $data[0]->DescripcionPT ?></textarea>
            </div>
            
            <!-- Fecha de Entrada -->
            <div class="mb-3">
                <label class="form-label" for="fechaEntrada">Fecha de Entrada</label>
                <input type="date" class="form-control" name="Fecha_Entrada" id="fechaEntrada" 
                       value="<?php echo $data[0]->Fecha_Entrada ?>" required>
            </div>
            
            <!-- Fecha de Salida -->
            <div class="mb-3">
                <label class="form-label" for="fechaSalida">Fecha de Salida</label>
                <input type="date" class="form-control" name="Fecha_Salida" id="fechaSalida" 
                       value="<?php echo $data[0]->Fecha_Salida ?>" required>
            </div>
            
            <!-- Materia Prima -->
            <div class="mb-3">
                <label class="form-label" for="idmateria_prima">Materia Prima</label>
                <select name="idmateria_prima" class="form-control" id="idmateria_prima" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($materiaPrima as $materia): 
                        $selected = ($materia->idProducto == $data[0]->idmateria_prima) ? 'selected' : '';
                    ?>
                        <option value="<?php echo $materia->idProducto ?>" <?php echo $selected ?>>
                            <?php echo $materia->Nombre ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Estado -->
            <div class="mb-3">
                <label class="form-label" for="idEstado">Estado</label>
                <select name="idEstado" class="form-control" id="idEstado" required>
                    <option value="">Seleccione...</option>
                    <?php foreach ($estados as $estado): 
                        $selected = ($estado->idEstados == $data[0]->idEstado) ? 'selected' : '';
                    ?>
                        <option value="<?php echo $estado->idEstados ?>" <?php echo $selected ?>>
                            <?php echo $estado->Estados ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Botón Actualizar -->
            <div class="form-group text-center">
                <button class="btn btn-primary" id="submit">Actualizar</button>
            </div>
        </div>
    </form>
</div>

<!-- JavaScript de validación -->
<script>
    // Validación en tiempo real del nombre
    document.getElementById('nombreProducto').addEventListener('input', function(e) {
        const input = e.target.value;
        const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]*$/;
        if (!soloLetras.test(input)) {
            e.target.value = input.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '');
        }
    });

    document.getElementById('formProductoTerminado').addEventListener('submit', function(e) {
        const cantidad = document.getElementById('cantidadDisponible').value;
        const nombre = document.getElementById('nombreProducto').value.trim();
        const fechaEntrada = document.getElementById('fechaEntrada').value;
        const fechaSalida = document.getElementById('fechaSalida').value;

        const hoy = new Date().toISOString().split('T')[0];
        const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;

        if (parseInt(cantidad) < 0) {
            e.preventDefault();
            alert('La cantidad disponible no puede ser negativa.');
            return;
        }

        if (!soloLetras.test(nombre)) {
            e.preventDefault();
            alert('El nombre del producto solo puede contener letras y espacios.');
            return;
        }

        if (fechaEntrada < hoy) {
            e.preventDefault();
            alert('La fecha de entrada no puede ser menor a la fecha actual.');
            return;
        }

        const entrada = new Date(fechaEntrada);
        entrada.setMonth(entrada.getMonth() + 2);
        const fechaLimite = entrada.toISOString().split('T')[0];

        if (fechaSalida > fechaLimite) {
            e.preventDefault();
            alert('La fecha de salida no puede ser más de dos meses después de la fecha de entrada.');
        }
    });
</script>
