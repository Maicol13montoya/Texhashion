<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand d-flex justify-content-center align-items-center" href="{{ URL::to('/') }}">
            <img src="assets/img/TexFashion.png" class="w-10" alt="TexFashion" style="width: 80%">
        </a>
        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Menu
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="?controller=home">
                    <span class="iconify" data-icon="solar:home-bold-duotone" data-width="25"></span> <span
                        class="align-middle">Inicio</span>
                </a>
            </li>
            <?php
            if ($_SESSION['user_role'] == '1' or $_SESSION['user_role'] == '5' or $_SESSION['user_role'] == '2' or $_SESSION['user_role'] == '3') {
            ?>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="?controller=MateriaPriema">
                        <span class="iconify" data-icon="fontisto:doctor" data-width="20"></span> <span
                            class="align-middle">Materia Prima</span>
                    </a>
                </li>
            <?php } ?>
            <?php
            if ($_SESSION['user_role'] == '1' or $_SESSION['user_role'] == '5' or $_SESSION['user_role'] == '2' or $_SESSION['user_role'] == '3') {
            ?>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="?controller=Ordenes">
                        <span class="iconify" data-icon="fontisto:doctor" data-width="20"></span> <span
                            class="align-middle">Ordenes</span>
                    </a>
                <?php } ?>
                <?php
                if ($_SESSION['user_role'] == '1' or $_SESSION['user_role'] == '2' or $_SESSION['user_role'] == '3') {
                ?>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="?controller=Productosterminados">
                        <span class="iconify" data-icon="fontisto:doctor" data-width="20"></span> <span
                            class="align-middle">Productos Terminados</span>
                    </a>
                <?php } ?>
                <?php
                if ($_SESSION['user_role'] == '1' or $_SESSION['user_role'] == '5') {
                ?>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="?controller=Facturas">
                        <span class="iconify" data-icon="fontisto:doctor" data-width="20"></span> <span
                            class="align-middle">Comprobantes de pago</span>
                    </a>

                </li>
            <?php } ?>
            <?php
            if ($_SESSION['user_role'] == '1') {
            ?>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="?controller=Usuarios">
                        <span class="iconify" data-icon="fontisto:universal-acces" data-width="20"></span> <span
                            class="align-middle">Usuarios</span>
                    </a>
                </li>
            <?php } ?>
            <li class="sidebar-item">
    <a class="sidebar-link" href="javascript:void(0);" id="logout-link">
        <span class="iconify" data-icon="solar:logout-3-bold-duotone" data-width="25"></span> 
        <span class="align-middle">Cerrar sesión</span>
    </a>
</li>

<div id="logout-message" style="display: none; text-align: center; padding: 10px; font-size: 16px; font-weight: bold; color: #333;">
    Cerrando sesión...
</div>
        </ul>
    </div>
</nav>

<script>
    document.getElementById('logout-link').addEventListener('click', function (event) {
        // Prevenir la acción por defecto del enlace
        event.preventDefault();

        // Mostrar la alerta de confirmación
        if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
            // Mostrar el mensaje de "Cerrando sesión"
            const messageDiv = document.getElementById('logout-message');
            messageDiv.style.display = 'block';  // Mostrar el mensaje

            // Esperar 3 segundos y luego redirigir al logout
            setTimeout(function() {
                window.location.href = '?controller=login&method=logout';  // Redirigir para cerrar sesión
            }, 3000); // 3000 milisegundos = 3 segundos
        }
    });
    const logoutLink = document.getElementById('logout-link');
    const logoutForm = document.getElementById('logout-form');

    logoutLink.addEventListener('click', () => {
        logoutForm.submit();
    });
</script>