<main class="content">
    <div class="container-fluid p-0">
        <section class="pt-3 pb-4" id="count-stats">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="row-reverse">
                            <div class="col d-flex justify-content-center">
                                <label class="h2 font-weight-bold text-center"><img src="assets/img/TexFashion.png"
                                        class="w-55" style="width: 25%">
                                    <h2 class="pt-4">Bienvenido a Texfashion</h2>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
          
        </section>

        <section class="my-2 py-2">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 ms-auto me-auto p-lg-4 mt-lg-0 mt-4">
                        <div class="rotating-card-container">
                            <div
                                class="card card-rotate card-background card-background-mask-primary shadow-primary mt-md-0 mt-5">
                                <div class="front front-background"
                                    style="background-image: url(/assets/img/odontologia.jpg); background-size: cover;">
                                    <div class="card-body py-7 text-center">
                                        <i class="material-icons text-white text-4xl my-3"><span class="iconify"
                                                data-icon="mdi:people" data-width="75"></span></i>
                                        <h3 class="text-white">USUARIOS</h3>
                                    </div>
                                </div>
                                <div class="back back-background"
                                    style="background-image: url(/assets/img/cliente.jpg); background-size: cover;">
                                    <div class="card-body pt-7 text-center">
                                        <h3 class="text-white">IR AL MODULO</h3>
                                        <a href="{{ route('/TexFashion2/views/Usuarios/list.php') }}"
                                            class="btn btn-white btn-sm w-50 mx-auto mt-3">VISITAR</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 ms-auto me-auto p-lg-4 mt-lg-0 mt-4">
                        <div class="rotating-card-container">
                            <div
                                class="card card-rotate card-background card-background-mask-primary shadow-primary mt-md-0 mt-5">
                                <div class="front front-background"
                                    style="background-image: url(/assets/img/gestion.jpg); background-size: cover;">
                                    <div class="card-body py-7 text-center">
                                        <i class="material-icons text-white text-4xl my-3"><span class="iconify"
                                                data-icon="bi:briefcase" data-width="75"></span></i>
                                        <h3 class="text-white">ORDENES</h3>
                                    </div>
                                </div>
                                <div class="back back-background"
                                    style="background-image: url(/assets/img/gestiones2.jpg); background-size: cover;">
                                    <div class="card-body pt-7 text-center">
                                        <h3 class="text-white">IR AL MODULO</h3>
                                        <a href="{{ route('procedures.index') }}"
                                            class="btn btn-white btn-sm w-50 mx-auto mt-3">VISITAR</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 ms-auto me-auto p-lg-4 mt-lg-0 mt-4">
                        <div class="rotating-card-container">
                            <div
                                class="card card-rotate card-background card-background-mask-primary shadow-primary mt-md-0 mt-5">
                                <div class="front front-background"
                                    style="background-image: url(/assets/img/reporte.png); background-size: cover;">
                                    <div class="card-body py-7 text-center">
                                        <i class="material-icons text-white text-4xl my-3"><span class="iconify"
                                                data-icon="ic:trending-up" data-width="75"></span></i>
                                        <h3 class="text-white">COMPROBANTES DE PAGO</h3>
                                    </div>
                                </div>
                                <div class="back back-background"
                                    style="background-image: url(/assets/img/reportes.jpg); background-size: cover;">
                                    <div class="card-body pt-7 text-center">
                                        <h3 class="text-white">IR AL MODULO</h3>
                                        <a href="{{ route('reports')}}" class="btn btn-white btn-sm w-50 mx-auto mt-3">VISITAR</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>