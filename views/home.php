<!DOCTYPE html>
<html lang="en">
<head>
    <title>Inicio - TexFashion</title>
    <?php include_once 'layouts/head.php'; ?>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var height = window.innerHeight - 2;
            var porh = (height * 74 / 100);
            $('#info').css('height', porh);
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <?php include_once 'layouts/sidebar.php'; ?>

        <div class="main">
            <?php include_once 'layouts/nadvar.php'; ?>

            <main class="content">
                <div class="container-fluid p-0">
                    <?php
                    if (isset($content) && !empty($content)) {
                        echo $content;
                    } else {
                        include_once 'inicio.php';
                    }
                    ?>
                </div>
            </main>

            <?php include_once 'layouts/footer.php'; ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnDisabled = document.getElementsByClassName('btnDisabled');
            for (let i = 0; i < btnDisabled.length; i++) {
                btnDisabled[i].addEventListener('click', function () {
                    Swal.fire(
                        'No disponible',
                        'Intenta más tarde',
                        'info'
                    );
                });
            }
        });
    </script>
</body>
</html>
