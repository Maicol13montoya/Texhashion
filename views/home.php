<!DOCTYPE html>
<html lang="en">
<?php
include('layouts/head.php')
?>
<script>
    var height = window.innerHeight - 2;
    var porh = (height * 74 / 100);
    $(document).ready(function() {
        $('#info').css('height', porh);
    });
</script>

<body>
    <div class="wrapper">
        <?php
        include('layouts/sidebar.php')
        ?>
        <div class="main">
            <?php
            include('layouts/nadvar.php')
            ?>
            <main class="content">
                <div class="container-fluid p-0">
                    <?php
                    if (isset($content) && !empty($content)) {
                        echo $content;
                    } else {
                        include('inicio.php');
                    }
                    ?>
                </div>
            </main>

            <?php
            include('layouts/footer.php')
            ?>
        </div>
    </div>

    <script>
        let btnDisabled = document.getElementsByClassName('btnDisabled');

        for (let i = 0; i < btnDisabled.length; i++) {
            btnDisabled[i].addEventListener('click', function() {
                Swal.fire(
                    'No disponible',
                    'Intenta mas tarde',
                    'info'
                );
            });
        }
    </script>
</body>

</html>