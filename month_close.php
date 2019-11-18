<?php
    session_start();
    $_SESSION['email'] = $_GET['email'];
    include 'php/connection.php';
    $verify = mysqli_query($connection, "select CompanyRecieved from tb_monthControl where month(DateControl) = '".$_GET['month']."' and year(DateControl) = '".$_GET['year']."';");
    while($verifyRow = mysqli_fetch_assoc($verify)) {
        if($verifyRow['CompanyRecieved'] == 1) {
            header('Location: month_expired.html');    
        }
    }
    $sqlCompany = "select CompanyName from tb_company where idtb_company = 1";
    $resCompany = mysqli_query($connection, $sqlCompany);
    $sql = "select EntryHour, LunchBreak, LunchReturn, DepartureTime, Date, EntryHourManual, LunchBreakManual, 
	LunchReturnManual, DepartureTimeManual, UserName, UserCpf
    from tb_point
    inner join tb_user
    on fk_employee = idtb_user
    where UserEmail = '".$_GET['email']."' and month(Date) = '".$_GET['month']."' and year(Date) = '".$_GET['year']."';";
    $res = mysqli_query($connection, $sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="ie-edge"/>
        <link rel="stylesheet" href="css/all.css?version=12"/>
        <link rel="stylesheet" href="css/index.css?version=12"/>
        <link rel="stylesheet" href="css/month_close.css?version=12"/>
        <LINK REL="SHORTCUT ICON" href="images/Logo-MecSystem.png">
        <script src="scripts/jquery.js"></script>
        <title>Verificação</title>
    </head>
    <body>
        <div id="accept-popup" class="flex-row popup hidden">
           <div class="flex-column popup-content">
                <img id="close-accept" src="images/close-dark.svg" />
                <h2 class="popup-title">Aviso</h2>
                <h3 class="popup-text">Por questões de segurança, precisamos que confirme com sua senha.</h3>
                <form action="php/month_accept.php" method="POST" class="flex-column flex-center">
                    <input type="password" placeholder="Senha" name="password" />
                    <button class="popup-button" style="background-color: white" type="submit">Confirmar</button>
                </form>
            </div>
        </div>
        <div id="decline-popup" class="flex-row popup hidden">
           <div class="flex-column popup-content">
                <img id="close-decline" src="images/close-dark.svg" />
                <h2 class="popup-title">Aviso</h2>
                <h3 class="popup-text">Por questões de segurança, precisamos que confirme com sua senha.</h3>
                <form action="php/month_decline.php" method="POST" class="flex-column flex-center">
                    <input type="password" placeholder="Senha" name="password" />
                    <button class="popup-button" style="background-color: white" type="submit">Confirmar</button>
                </form>
            </div>
        </div>
        <div id="page" class="hidden flex-column align-center" style="padding: 0; display: flex;
    justify-content: center;">
            <div id="header" class="flex-row flex-center">
                <span id="primary">
                <?php
                    while($row = mysqli_fetch_assoc($resCompany)) {
                        echo $row['CompanyName'];
                    }
                ?>
                </span>
            </div>
            <div class="flex-column flex-center" style="padding: 15px">
                <?php
                    while($row = mysqli_fetch_assoc($res)) {
                ?>
                <h2>Dados Pessoais</h2>
                <div class="info">
                    <h2 class="label">Nome do Funcionário</h2>
                    <h3 class="data"><?php echo utf8_encode($row['UserName']); ?></h3>
                    <h2 class="label">CPF</h2>
                    <h3 class="data"><?php echo utf8_encode($row['UserCpf']); ?></h3>
                </div>
                <h2>Relatório completo de registro de ponto do mês </h2>
                <div class="table-controller">
                    <table>
                        <tr>
                            <th>Data</th>
                            <th>Entrada (Matutino)</th>
                            <th>Saída (Matutino)</th>
                            <th>Entrada (Vespertino)</th>
                            <th>Saída (Vespertino)</th>
                        </tr>
                        <tbody>
                            <?php
                                echo "
                                <tr>
                                    <td>".date("d/m/y", strtotime($row['Date']))."</td>
                                    <td";
                                if($row['EntryHourManual'] == 1){echo " class='manual'";}
                                echo ">".$row['EntryHour']."</td>
                                    <td";
                                if($row['LunchBreakManual'] == 1){echo " class='manual'";}
                                    echo ">".$row['LunchBreak']."</td>
                                    <td";
                                if($row['LunchReturnManual'] == 1){echo " class='manual'";}
                                    echo ">".$row['LunchReturn']."</td>
                                    <td";
                                if($row['DepartureTimeManual'] == 1){echo " class='manual'";}
                                    echo ">".$row['DepartureTime']."</td>
                                </tr>
                                ";
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php } ?>
                <span id="tip">Registros inseridos manualmente por administradores estão
                representados pela cor laranja.</span>
                <div class="decision flex-row flex-center">
                    <button id="decline">Discordo</button>
                    <button id="accept">Concordo</button>
                </div>
            </div>
        </div>
        <script>
            let accept = document.querySelector("#accept");
            let decline = document.querySelector("#decline");
            let acceptClose = document.querySelector("#close-accept");
            let declineClose = document.querySelector("#close-decline");
            accept.onclick = () => {
                document.querySelector("#accept-popup").classList.remove("hidden");
            }
            acceptClose.onclick= () => {
                document.querySelector("#accept-popup").classList.add("hidden");
            }
            decline.onclick = () => {
                document.querySelector("#decline-popup").classList.remove("hidden");
            }
            declineClose.onclick= () => {
                document.querySelector("#decline-popup").classList.add("hidden");
            }
        </script>
    </body>
</html>