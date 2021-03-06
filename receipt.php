<?php
    session_start();
    header("Content-type: text/html; charset: utf-8");
    include 'php/receipt.php';
    if (isset($_SESSION["codUser"])){
        //
    } else {
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8"/>
        <meta http-equiv="pragma" content="no-cache">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="ie-edge"/>
        <link rel="stylesheet" href="css/all.css?version=12">
        <link rel="stylesheet" href="css/receipt.css?version=12">
        <script src="scripts/jquery.js"></script>
    </head>
    <body>
        <div class="local-container page-fade">
            <div class="flex-center flex-column tabless-content scrollable">
                <div id="header" class="flex-center flex-column">
                    <h1 id="title">Comprovante</h1>
                </div>
                <div class="flex-center flex-column" style="width: 100%; margin-bottom: 20px;">
                    <?php while($row = mysqli_fetch_assoc($result)){ ?>
                    <div class="spaced">
                        <h2 class="label">Nome do Funcionário</h2>
                        <h3 class="data" id="name"><?php echo utf8_encode($_SESSION['name']." ".$_SESSION['lastName']); ?></h3>
                    </div>
                    <div class="spaced box">
                        <h2 class="label">Código do Funcionário</h2>
                        <h3 class="data"><?php echo $_SESSION['codUser']; ?></h3>
                    </div>
                    <div class="spaced box">
                        <h2 class="label">CNPJ</h2>
                        <h3 class="data"><?php echo $row['CNPJ']; ?></h3>
                    </div>
                    <div class="spaced box">
                        <h2 class="label">Data</h2>
                        <h3 class="data"><?php echo date("d/m/Y", strtotime($_GET['date'])); ?></h3>
                    </div>
                    <div class="spaced box">
                        <h2 class="label">Horário</h2>
                        <h3 class="data"><?php echo $_GET['hour']; ?></h3>
                    </div>
                    <div class="spaced box">
                        <h2 class="label">Local</h2>
                        <h3 class="data"><?php echo utf8_encode($row['Locale']);} ?></h3>
                    </div>
                    <div class="spaced box">
                        <h2 class="label">PIS</h2>
                        <h3 class="data"><?php echo $_SESSION['PIS']; ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <script src="php/receipt.php"></script>
        <script>
            $(document).ready(() => {
                $('a:last').addClass('hidden');
            });
        </script>
    </body>
</html>