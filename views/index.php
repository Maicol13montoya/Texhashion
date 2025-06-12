<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="../assets/img/TexFashion.png" sizes="32x32" type="image/png">


    <link rel="stylesheet" href="assets/css/inicio.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>

<body>

    <section class="tank-bootstrap-header">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light py-lg-3 py-2">
                <div class="logo">
                    <img src="assets/img/TexFashion.png" alt="Logo">
                </div>
              
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="?controller=login&action=index">Iniciar sesión</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="views\contactanos.php">Contacto</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="views\consultarFactura.php">Consulta tu factura</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </section>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var currentPath = window.location.pathname;
            var navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach(function (link) {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        });
    </script>






    <center>
        <!-- Contenedor del carrusel -->
        <div class="carousel">
            <!-- Contenedor de las imágenes -->
            <div class="carousel-images">
            <img src="./assets/img/imagen1.png" alt="Imagen1" class="carousel-img" />
            <img src="./assets/img\M.1.jpg" alt="Imagen1" class="carousel-img" />
            <img src="./assets/img\obraluisdomingo.png" alt="Imagen1" class="carousel-img" />
            </div>
            <!-- Botones de navegación -->
            <button class="carousel-button prev" onclick="prevSlide()">&#10094;</button>
            <button class="carousel-button next" onclick="nextSlide()">&#10095;</button>
        </div>


        <script>
            // Índice inicial del carrusel
            let currentIndex = 0;
            const images = document.querySelector('.carousel-images');
            const totalImages = images.children.length;

            // Función para mostrar la diapositiva anterior
            function prevSlide() {
                currentIndex = (currentIndex > 0) ? currentIndex - 1 : totalImages - 1;
                updateCarousel();
            }

            // Función para mostrar la siguiente diapositiva
            function nextSlide() {
                currentIndex = (currentIndex + 1) % totalImages;
                updateCarousel();
            }

            // Función para actualizar la posición del carrusel
            function updateCarousel() {
                images.style.transform = `translateX(-${currentIndex * 100}%)`;
            }

            // Función para iniciar el carrusel automático
            function startCarousel() {
                setInterval(nextSlide, 3000); // Cambia de imagen cada 3 segundos
            }

            // Inicia el carrusel automático al cargar la página
            window.onload = startCarousel;
        </script>

        <br class="salto">
        <sion class="tank-features-4">
            <div class="features py-5" id="services">
                <div class="container py-md-3">
                    <div class="heading text-center mx-auto">
                        <h3 class="head">¿Quiénes somos? </h3>
                        <p class="my-3 head">En Tex fashión, nos especializamos en la producción de chaquetas de alta
                            calidad para colegios y diversas empresas. Nuestra misión es ofrecer productos duraderos,
                            cómodos y con un diseño personalizado que se ajuste a las necesidades específicas de
                            nuestros
                            clientes. Con años de experiencia en la industria textil, nos enorgullecemos de utilizar
                            materiales de primera calidad y técnicas de confección avanzadas para garantizar la
                            satisfacción
                            de nuestros clientes.</p>
                    </div>


                    </br>
                    <div class="fea-gd-vv row mt-5 pt-3">
                        <div class="float-lt feature-gd col-lg-4 col-md-6">
                            <div class="icon"><span class="fa fa-handshake-o" aria-hidden="true"></span></div>
                            <div class="icon-info">
                                <h5><a href="#">Mejor servicio</a></h5>
                                <p>Nos comprometemos a ofrecer el mejor servicio de personalización de chaquetas para
                                    colegios y empresas. Entendemos la importancia de representar la identidad de una
                                    institución a través de uniformes de calidad</p>
                            </div>
                        </div>
                        <div class="float-mid feature-gd col-lg-4 col-md-6 mt-md-0 mt-5">
                            <div class="icon"><span class="fa fa-clock-o" aria-hidden="true"></span></div>
                            <div class="icon-info">
                                <h5><a href="#">Por tiempo</a></h5>
                                <p>Nos esforzamos por cumplir con los plazos de entrega acordados, asegurando que
                                    recibas
                                    tus pedidos en el momento que los necesites, ya sea para el inicio del año escolar,
                                    eventos especiales o necesidades corporativas.</p>
                            </div>
                        </div>
                        <div class="float-rt feature-gd col-lg-4 col-md-6 mt-md-0 mt-5">
                            <div class="icon"><span class="fa fa-cutlery" aria-hidden="true"></span></div>
                            <div class="icon-info">
                                <h5><a href="#">Calidad de prendas </a></h5>
                                <p>nos dedicamos a la confección de chaquetas de alta calidad para colegios y empresas,
                                    y
                                    para lograrlo, utilizamos materiales de primera calidad. Nos enfocamos en cada
                                    detalle,
                                    desde la selección de telas hasta los hilos, asegurando que nuestros productos no
                                    solo
                                    sean atractivos, sino también duraderos y cómodos.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </section>


            <section class="tank-feature-3" id="features">
                <div class="grid top-bottom">
                    <div class="container">
                        <div class="heading text-center mx-auto">
                            <h3 class="head text-white">Elige entre diferentes modos</h3>
                            <p class="my-3 head text-white">En Tex fashión, ofrecemos varias modalidades para adaptarnos
                                a
                                tus
                                necesidades y preferencias. Puedes elegir entre tres opciones: modalidad presencial,
                                conocer
                                dónde compramos nuestras telas, o nuestra ubicación.</p>
                        </div>
                        <div class="middle-section grid-column text-center mt-5 pt-3">
                            <div class="three-grids-columns">
                                <span class="fa fa-star"></span>
                                <h4>Atención en Línea a través de Chat y Correo Electrónico</h4>
                                <p> Ofrecemos atención personalizada y soporte a nuestros clientes a través de un chat
                                    en
                                    vivo en nuestro sitio web y correo electrónico. Los clientes pueden consultar sobre
                                    productos, realizar preguntas sobre pedidos, y recibir asistencia técnica sin
                                    necesidad
                                    de desplazarse.</p>
                            </div>
                            <div class="three-grids-columns">
                                <span class="fa fa-shopping-basket"></span>
                                <h4>Atención Telefónica</h4>
                                <p>
                                    Descripción:
                                    Disponemos de un servicio de atención telefónica donde los clientes pueden
                                    comunicarse
                                    directamente con nuestro equipo de soporte. Ofrecemos ayuda para consultas
                                    generales,
                                    problemas con pedidos, y asesoramiento personalizado sobre productos.</p>
                            </div>
                            <div class="three-grids-columns">
                                <span class="fa fa-globe"></span>
                                <h4> <a
                                        href="https://www.google.com/maps/@4.4972359,-74.1078225,3a,75y,283.3h,89.17t/data=!3m7!1e1!3m5!1sUe3yCH61S5_MbwUXV1xAGA!2e0!6shttps:%2F%2Fstreetviewpixels-pa.googleapis.com%2Fv1%2Fthumbnail%3Fcb_client%3Dmaps_sv.tactile%26w%3D900%26h%3D600%26pitch%3D0.8341846464207237%26panoid%3DUe3yCH61S5_MbwUXV1xAGA%26yaw%3D283.30332324330305!7i13312!8i6656?coh=205410&entry=ttu">Ubicacion</a>
                                </h4>
                                <p>Atención Presencial en Usme, Comuneros
                                    Descripción:
                                    Nuestro punto de atención presencial está ubicado en Usme, Comuneros. En esta sede,
                                    los
                                    clientes pueden visitar nuestras instalaciones para recibir asistencia en persona,
                                    realizar compras directas, y recibir asesoramiento personalizado sobre nuestros
                                    productos.</p>

            </section>


            <div class="products-4" id="portfolio">
                <div id="products4-block" class="text-center">
                    <div class="container">

                        <div class="heading text-center mx-auto mb-5">
                            <h3 class="head">Trabajos realizados</h3>
                            <p class="my-3 head">En Tex Fashion, nos enorgullecemos de nuestra experiencia y habilidad
                                en la
                                creación de chaquetas personalizadas para colegios y empresas. A lo largo de los años,
                                hemos
                                trabajado con una amplia variedad de clientes, diseñando y produciendo prendas que
                                reflejan
                                la identidad y los valores de cada institución.
                            </p>
                        </div>
                        <input id="tab1" type="radio" name="tabs" checked>

                        <input id="tab2" type="radio" name="tabs">

                        <input id="tab3" type="radio" name="tabs">

                        <input id="tab4" type="radio" name="tabs">
                        <section id="content1" class="tab-content text-left">
                            <div class="d-grid grid-col-3">
                                <div class="product">
                                    <a>
                                        <figure>
                                        <img src="./assets/img/promgas.png" alt="Imagen1"  
                                        class="img-responsive animated-img"/>  
                                        </figure>
                                    </a>
                                </div>
                                <div class="product">
                                    <a>
                                        <figure>
                                        <img src="./assets/img/profeteacher.png" alt="Imagen1"  
                                        class="img-responsive animated-img"/> 
                                        </figure>
                                    </a>
                                </div>
                                <div class="product">
                                   <a>
  <figure>
    <img src="./assets/img/camisanegra.png" alt="Camiseta negra" class="img-responsive animated-img" />
  </figure>
</a>

                                </div>
                                <div class="product">
                                   <a>
  <figure>
    <img src="./assets/img/posillos.png" alt="Posillos" class="img-responsive animated-img" />
  </figure>
</a>

                                </div>
                                <div class="product">
                                   <a>
  <figure>
    <img src="./assets/img/clavijo.png" alt="Clavijo" class="img-responsive animated-img" />
  </figure>
</a>

                                </div>
                                <div class="product">
                                    <a>
                                        <figure>
  <img src="./assets/img/prom.png" alt="Promoción" class="img-responsive animated-img" />
</figure>

                                    </a>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>


            <section class="services-12" id="experience">
                <div class="form-12-content">
                    <div class="container">
                        <div class="grid grid-column-2">
                            <div class="column1">
                                <h3 class="mb-5">Entre semana</h3>
                                <div class="experience-top">
                                    <h5>Lunes</h5>
                                    <h4>Disponibilidad</h4>
                                    <p class="my-3 text-white">De 9:00 AM a 6:00 PM. Durante este horario, el
                                        equipo de Tex
                                        Fashion Confección se dedica a la producción y revisión de las prendas,
                                        asegurando
                                        que cada pieza cumpla con los estándares de calidad establecidos por la
                                        empresa
                                    </p>
                                </div>
                                <div class="experience-top">
                                    <h5>Martes</h5>
                                    <h4>Disponibilidad</h4>
                                    <p class="my-3 text-white">De 9:00 AM a 6:00 PM. Continuamos con el corte,
                                        confección y
                                        ensamblaje de las prendas. Además, se realizan reuniones internas para
                                        planificar la
                                        producción de la semana y evaluar el progreso de los pedidos.
                                    </p>
                                </div>
                                <div class="experience-top">
                                    <h5>Miercoles</h5>
                                    <h4>Disponibilidad</h4>
                                    <p class="my-3 text-white">De 9:00 AM a 6:00 PM. El enfoque está en la
                                        terminación y
                                        detallado de las prendas, incluyendo bordados y ajustes finales. También
                                        se lleva a
                                        cabo el control de calidad antes del embalaje.</p>
                                </div>
                            </div>
                            <div class="column2">
                                <h3 class="mb-5">Fines de semana</h3>
                                <div class="experience-top">
                                    <h5>Sábado</h5>
                                    <h4>Disponibilidad</h4>
                                    <p class="my-3 text-white">De 9:00 AM a 12:00 PM. Solo se realizan tareas
                                        esenciales
                                        como el mantenimiento de equipos, revisión de stock y preparación de
                                        materiales para
                                        la siguiente semana. No se realiza producción completa.</p>
                                </div>
                                <div class="experience-top">
                                    <h5>Domingo</h5>
                                    <h4>Disponibilidad</h4>
                                    <p class="my-3 text-white">No trabajamos. El equipo de Tex Fashion
                                        Confección descansa
                                        para recargar energías y prepararse para la semana siguiente.</p>
                                    </p>
                                </div>
                                <div class="experience-top">
                                    <h5>Día Festivos</h5>
                                    <h4>Disponibilidad</h4>
                                    <p class="my-3 text-white">En días festivos, la planta de Tex Fashion
                                        Confección
                                        permanece cerrada. Se aprovecha para realizar mantenimiento profundo de
                                        las
                                        instalaciones y equipos, asegurando que todo esté en óptimas condiciones
                                        para la
                                        reanudación de actividades.</p>


                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>







            <br>

            <div class="container">
                <div class="left-content">
                    <h2>Tex fashion - Usme</h2>
                    <div class="contact-info">
                        <p>95 Sur53 Cra. 5a Este</p>
                        <p>Bogotá, Colombia </p>
                        <p>Celular 3214911633</p>
                        <p>E: <a href="texfashion.gmail.com">texfashion.gmail.com</a></p>
                        <p><strong>LUNES - SÁBADOS:</strong> 9 am - 6 pm</p>
                        <p><strong>DOMINGOS:</strong> 10 am - 1 pm</p>
                    </div>
                   <iframe
  title="Ubicación de Tex Fashion en Google Maps"
  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3976.2360623589466!2d-74.1078225!3d4.4972359!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e3f9b9a86e77d9f%3A0x24a0010c00863e34!2sTex%20fashion!5e0!3m2!1ses!2sco!4v1607040460989!5m2!1ses!2sco"
  width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy">
</iframe>



            </div>
    </center>
    </br>
    <section class="tank-footer-29-main" id="footer">
        <div class="footer-29 text-center">
            <div class="container">
                <div class="main-social-footer-29">
                <a href="https://wa.me/3107065663?text=Hola,%20quisiera%20más%20información" class="whatsapp" target="_blank">
                        <span class="fa fa-whatsapp"></span>
      </a>
                </div>
                <div class="bottom-copies text-center">
                    <p class="copy-footer-29"> 2024 TexFashion | Seguridad <a href="#">Empresa</a></p>
                </div>
            </div>
        </div>

        <button id="movetop" title="Go to top">
            <span class="fa fa-angle-up"></span>
        </button>
    </section>




    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
        crossorigin="anonymous"></script>

</body>

</html>
