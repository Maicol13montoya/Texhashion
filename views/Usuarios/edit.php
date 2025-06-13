<div class="card w-75 m-auto">
    <div class="card-header container">
        <h2 class="m-auto">Actualizar Nuevo Usuario</h2>
    </div>
    <div class="card-body">
        <form action="?controller=Usuarios&method=update" method="post" onsubmit="return validarFormulario()">
            <input type="hidden" id="id" name="id" value="<?php echo $data[0]->id ?>">

            <div class="col mb-4">
                <div class="row">
                    <div class="col">
                        <label for="nombre" class="form-label">Nombres</label>
                        <input type="text" id="nombre" class="form-control" name="nombre" value="<?php echo $data[0]->nombre ?>" required>
                    </div>
                    <div class="col">
                        <label for="apellido" class="form-label">Apellidos</label>
                        <input type="text" id="apellido" class="form-control" name="apellido" value="<?php echo $data[0]->apellido ?>" required>
                    </div>
                </div>
            </div>

            <div class="col mb-4">
                <div class="row">
                    <div class="col">
                        <label for="tipo_doc" class="form-label">Tipo Documento</label>
                        <select name="tipo_doc" id="tipo_doc" class="form-control" required>
                            <option value="">Seleccione...</option>
                            <?php foreach ($tipos_doc as $tipo_doc): ?>
                                <option value="<?php echo $tipo_doc->IdDocumento ?>" <?php echo ($tipo_doc->IdDocumento == $data[0]->tipo_documento) ? 'selected' : ''; ?>>
                                    <?php echo $tipo_doc->TipoDocumento ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="documento" class="form-label">Documento</label>
                        <input type="number" id="documento" class="form-control" name="documento" value="<?php echo $data[0]->documento ?>" required>
                    </div>
                </div>
            </div>

            <div class="col mb-4">
                <div class="row">
                    <div class="col">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" id="correo" class="form-control" name="correo" value="<?php echo $data[0]->correo_electronico ?>" required>
                    </div>
                    <div class="col">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" id="direccion" class="form-control" name="direccion" value="<?php echo $data[0]->direccion ?>" required>
                    </div>
                </div>
            </div>

            <div class="col mb-4">
                <div class="row">
                    <div class="col">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="number" id="telefono" class="form-control" name="telefono" value="<?php echo $data[0]->telefono ?>" required>
                    </div>
                    <div class="col">
                        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" id="fecha_nacimiento" class="form-control" name="fecha_nacimiento" value="<?php echo $data[0]->fecha_nacimiento ?>" required>
                    </div>
                </div>
            </div>

            <div class="col mb-4">
                <div class="row">
                    <div class="col">
                        <label for="rol" class="form-label">Rol</label>
                        <select name="rol" id="rol" class="form-control" required>
                            <option value="">Seleccione...</option>
                            <?php foreach ($roles as $rol): ?>
                                <option value="<?php echo $rol->idRol ?>" <?php echo ($rol->idRol == $data[0]->rol) ? 'selected' : ''; ?>>
                                    <?php echo $rol->Rol ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group d-flex justify-content-center">
                <button class="btn btn-primary" id="submit">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function soloLetras(e) {
        const valor = e.target.value;
        e.target.value = valor.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
    }

    window.addEventListener('DOMContentLoaded', () => {
        document.querySelector('[name="nombre"]').addEventListener('input', soloLetras);
        document.querySelector('[name="apellido"]').addEventListener('input', soloLetras);
    });

    function validarFormulario() {
        const nombre = document.querySelector('[name="nombre"]').value.trim();
        const apellido = document.querySelector('[name="apellido"]').value.trim();
        const nombreRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;

        if (!nombreRegex.test(nombre)) {
            alert("El nombre solo debe contener letras.");
            return false;
        }
        if (!nombreRegex.test(apellido)) {
            alert("El apellido solo debe contener letras.");
            return false;
        }

        const telefono = document.querySelector('[name="telefono"]').value;
        if (telefono.length !== 10) {
            alert("El número de teléfono debe tener exactamente 10 dígitos.");
            return false;
        }

        const fechaNacimiento = new Date(document.querySelector('[name="fecha_nacimiento"]').value);
        const fechaActual = new Date();
        let edad = fechaActual.getFullYear() - fechaNacimiento.getFullYear();
        const mes = fechaActual.getMonth() - fechaNacimiento.getMonth();

        if (mes < 0 || (mes === 0 && fechaActual.getDate() < fechaNacimiento.getDate())) {
            edad--;
        }

        if (edad < 18) {
            alert("Debe ser mayor de 18 años.");
            return false;
        }

        return true;
    }
</script>
