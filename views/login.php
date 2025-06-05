<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TexFashion</title>

    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <!-- Incluir Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* Fondo animado con gradiente azul */
        body {
            background: linear-gradient(45deg, #0099ff, #66ccff, #e0f7fa);
            background-size: 400% 400%;
            animation: gradientAnimation 10s ease infinite;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Contenedor principal */
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }

        /* Tarjeta de login */
        .card {
            border-radius: 15px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 35px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            width: 100%;
            max-width: 450px;
        }

        .card-body {
            padding: 2rem;
        }

        .btn-primary {
            background-color: #0099ff;
            border: none;
            border-radius: 25px;
            padding: 12px 25px;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #66ccff, #0099ff);
            transform: translateY(-3px);
        }

        .form-control {
            border-radius: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 12px;
            margin-bottom: 15px;
        }

        .form-control:focus {
            border-color: #0099ff;
            box-shadow: 0 0 5px rgba(0, 153, 255, 0.5);
        }

        .input-group-text {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 50%;
            padding: 10px;
        }

        .image-header {
            width: 30%;
            max-width: 200px;
            display: block;
            margin: 0 auto;
            border-radius: 20px;
        }

        /* Casita */
        .home-icon {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 60px;
            height: 60px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, background-color 0.3s ease;
        }



        .home-icon:hover {
            transform: scale(1.1);
            background: linear-gradient(45deg, #66ccff, #0099ff);
        }

        .home-icon:hover a {
            color: #fff;
        }
    </style>
</head>

<body>
    <!-- Icono de la casita -->
    <div class="home-icon">
        <a href="\TexFashion2\index.php">
            <i class="fas fa-home"></i>
        </a>
    </div>

    <main class="container">
        <!-- Tarjeta de login -->
        <section class="card">
            <img src="assets/img/TexFashion.png" alt="Imagen de Bienvenida" class="image-header">
            <div class="card-body">
                <form action="?controller=login&method=login" method="post">

                    <?php if (isset($error['errorMessage'])) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <p class="text-dark">
                                <?php echo implode('<br>', $error['errorMessage']); ?>
                            </p>

                        </div>
                    <?php } ?>

                    <div class="form-group input-group">
                        <span class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" id="email" class="form-control"
                            placeholder="Correo Electrónico"
                            value="<?php echo isset($error['email']) ? $error['email'] : ''; ?>" required>
                    </div>
                    <div class="form-group input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="******" required>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt"></i> Iniciar sesión
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>