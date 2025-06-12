<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
            <img src="https://img.freepik.com/vector-premium/icono-circulo-usuario-anonimo-ilustracion-vector-estilo-plano-sombra_520826-1931.jpg" alt="Usuario anónimo">

                        alt="Descripción de la imagen" class="rounded-circle" width="50" height="50">
                    <span class="text-dark fw-bold">
                        <?php echo htmlspecialchars($_SESSION['user'])?>
                    </span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route('count.profile') }}"><i class="align-middle me-1"
                            data-feather="user"></i> Mi perfil</a>
                    <a class="dropdown-item" href="{{ route('reports') }}"><i class="align-middle me-1"
                            data-feather="pie-chart"></i>
                        Reportes</a>
                    <div class="dropdown-divider"></div>

                    <form action="{{ route('logout') }}" method="post" id="logout-formNavBar">
                        <a class="dropdown-item" href="#" id="logout-linkNavBar"><i class="align-middle me-1"
                                data-feather="log-out"></i>
                            Cerrar sesión</a>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>

<script>
    const logoutLinkNavBar = document.getElementById('logout-linkNavBar');
    const logoutFormNavBar = document.getElementById('logout-formNavBar');

    logoutLinkNavBar.addEventListener('click', () => {
        logoutFormNavBar.submit();
    });
</script>

<script>
    $(document).on('click', '.btnReadRedirect', function() {
        var ids = $(this).data('ids').split(',');
        var notificationId = ids[0];
        var moduleId = ids[1];
        var module = ids[2];

        axios.get("{{ route('notification_admin.read_and_redirect', [':id', ':module_id', ':module']) }}"
                .replace(
                    ':id',
                    notificationId).replace(':module_id', moduleId).replace(':module', module), {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
            .then((response) => {
                Swal.fire({
                    title: 'Actualizado',
                    text: response.data.message,
                    icon: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    didClose: () => {
                        if (response.data.redirect) {
                            var redirectUrl = '';

                            switch (response.data.module) {
                                case 'Cliente':
                                    redirectUrl =
                                        "{{ route('clients.show', ['id' => ':id']) }}";
                                    break;
                                case 'Gestión':
                                    redirectUrl =
                                        "{{ route('procedures.show', ['id' => ':id']) }}";
                                    break;
                                case 'Transferencia':
                                    redirectUrl =
                                        "{{ route('orders.show', ['id' => ':id']) }}";
                                    break;
                                case 'Rol':
                                    redirectUrl =
                                        "{{ route('roles.show', ['id' => ':id']) }}";
                                    break;
                                default:
                                    redirectUrl = "{{ route('home') }}";
                                    break;
                            }

                            redirectUrl = redirectUrl.replace(':id', response.data.redirect);
                            window.location.href = redirectUrl;
                        } else {
                            window.location.href = "{{ route('home') }}";
                        }

                    }
                });

            })
            .catch((error) => {
                console.log(error);
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrio un error al actualizar la notificación',
                    icon: 'error',
                    confirmButtonColor: '#035da3',
                    confirmButtonText: 'Aceptar',
                });
            });
    });
</script>
<script>
    $(document).on('click', '.btnReadRedirect', function() {
        var ids = $(this).data('ids').split(',');
        var notificationId = ids[0];
        var moduleId = ids[1];
        var module = ids[2];

        axios.get("{{ route('notification_executive.read_and_redirect', [':id', ':module_id', ':module']) }}"
                .replace(
                    ':id',
                    notificationId).replace(':module_id', moduleId).replace(':module', module), {
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
            .then((response) => {
                Swal.fire({
                    title: 'Actualizado',
                    text: response.data.message,
                    icon: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    didClose: () => {
                        if (response.data.redirect) {
                            var redirectUrl = '';

                            switch (response.data.module) {
                                case 'Cliente':
                                    redirectUrl =
                                        "{{ route('clients.show', ['id' => ':id']) }}";
                                    break;
                                case 'Gestión':
                                    redirectUrl =
                                        "{{ route('procedures.show', ['id' => ':id']) }}";
                                    break;
                                case 'Transferencia':
                                    redirectUrl =
                                        "{{ route('orders.show', ['id' => ':id']) }}";
                                    break;
                                default:
                                    redirectUrl = "{{ route('home') }}";
                                    break;
                            }

                            redirectUrl = redirectUrl.replace(':id', response.data.redirect);
                            window.location.href = redirectUrl;
                        } else {
                            window.location.href = "{{ route('home') }}";
                        }

                    }
                });

            })
            .catch((error) => {
                console.log(error);
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrio un error al actualizar la notificación',
                    icon: 'error',
                    confirmButtonColor: '#035da3',
                    confirmButtonText: 'Aceptar',
                });
            });
    });
</script>
