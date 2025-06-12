<!DOCTYPE html>
<html lang="en">
<head>
    <title>Inicio - TexFashion</title>
    </head>
    <?php include_once('layouts/head.php'); ?>


<script>
    var height = window.innerHeight - 2;
    var porh = (height * 74 / 100);
    $(document).ready(function () {
        $('#info').css('height', porh);
    });
</script>
<body>
    <div class="wrapper">
        <?php
        include_once('layouts/sidebar.php');
        ?>
        <div class="main">
            <?php
            include_once('layouts/nadvar.php');
            ?>
            <main class="content">
                <div class="container-fluid p-0">
                    <?php
                    if (isset($content) && !empty($content)) {
                        echo $content;
                    } else {
                        include_once('inicio.php');
                    }
                    ?>
                </div>
            </main>
            <?php
            include_once('layouts/footer.php');
            ?>
        </div>
    </div>
    <script>
        let btnDisabled = document.getElementsByClassName('btnDisabled');
        for (let i = 0; i < btnDisabled.length; i++) {
            btnDisabled[i].addEventListener('click', function () {
                Swal.fire(
                    'No disponible',
                    'Intenta más tarde',
                    'info'
                );
            });
        }
    </script>
</body>
</html>
