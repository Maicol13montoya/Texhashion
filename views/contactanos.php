<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - TexFashion</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/inicio.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
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

        main {
            margin-top: 5%;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

        .contact-section {
            display: flex;
            max-width: 900px;
            width: 100%;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: all 0.3s ease;
        }

        .contact-section:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .image-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-right: 20px;
        }

        .image-section img {
            max-width: 80%;
            border-radius: 12px;
        }

        .form-section {
            flex: 2;
            padding-left: 20px;
        }

        h2 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        p {
            margin-bottom: 20px;
            color: #7f8c8d;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #34495e;
        }

        input,
        select,
        textarea {
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #dcdfe1;
            border-radius: 8px;
            font-size: 1em;
            width: 100%;
            transition: border-color 0.3s ease;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #3498db;
            outline: none;
        }

        textarea {
            resize: vertical;
        }

        button {
            padding: 12px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
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

        .home-icon a {
            text-decoration: none;
            color: #0099ff;
            font-size: 2rem;
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

    <main>
        <section class="contact-section">
            <div class="image-section">
                <img src="../assets/img/TexFashion.png" alt="Logo">
            </div>
            <div class="form-section">
                <h2>CONTÁCTANOS</h2>
                <p>Si tienes alguna duda, comentario o sugerencia, puedes contactarnos y nos comunicaremos contigo lo
                    antes posible.</p>
                <form action="https://formspree.io/f/xeoqoaqn" method="POST">
                    <label for="nombre">Nombre completo</label>
                    <input type="text" id="nombre" name="nombre" required>

                    <label for="email">Email*</label>
                    <input type="email" id="email" name="email" required>

                    <label for="comentarios">Comentarios</label>
                    <textarea id="comentarios" name="comentarios" rows="4" required></textarea>

                    <button type="submit">Enviar</button>
                </form>
            </div>
        </section>
    </main>
</body>

</html>
