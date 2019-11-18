<?php
    session_start();
    include 'php/registers.php';
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
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="ie-edge"/>
        <link rel="stylesheet" href="css/all.css?version=12">
        <link rel="stylesheet" href="css/registers.css?version=12">
        <script src="scripts/jquery.js"></script>
    </head>
    <body>
        <div id="loading" class="loading-background flex-row flex-center hidden">
            <div id="spinner" class="loading-spinner"></div>
        </div>
        <div id="registers-video" class="video-tip flex-row flex-center hidden">
            <img id="close-registers" class="close-video" src="images/close.svg"/>
            <img class="gif-tip" src="videos/Toque.gif"/>
        </div>
       <div class="flex-row popup hidden fade-popup">
           <div class="flex-column popup-content">
                <h2 class="popup-title">Aviso</h2>
                <h3 class="popup-text">Não existe um comprovante para o horário selecionado.</h3>
                <button class="popup-button">Entendi</button>
            </div>
       </div>
        <div class="local-container page-fade">
            <div class="flex-row help">
                <img src="images/libras.png" id="libras-registers"/>
                <img src="images/help.svg" id="text-registers" />
                <span id="registersTooltip-text" class="tooltip-text">
                     Toque sobre um horário para visualizar o comprovante correspondente.
                </span>
            </div>
            <div class="align-center flex-column tabless-content scrollable">
                <div id="header" class="flex-center flex-column">
                    <h1 id="title">Registros</h1>
                </div>
                <div class="flex-center flex-column">
                    <h2 id="date">
                        <?php
                            if (isset($_GET['date'])) {
                                echo date("d/m/Y", strtotime($_GET['date']));
                            }
                        ?>
                    </h2>
                    <div id="msg" class="flex-center flex-column">
                        <h5 id="message">
                            <?php
                                if ($rowsNumber == 0) {
                                    echo "Nenhum registro disponível para esta data.";
                                }
                            ?>
                        </h5>
                    </div>
                    <?php while($row = mysqli_fetch_assoc($result)) {
                        $_SESSION['pointCode'] = $row['idtb_point'];
                    ?>
                    <h3 class="subtitle">Período Matutino</h3>
                    <div class="table" style="display:flex">
                        <div id="left" class="column flex-column">
                            <h3 class="header-title">Entrada</h3>
                            <h4 style="color: #404040" <?php if($row['EntryHourManual'] == 1){echo "class='manual'";} ?>>
                                <?php
                                    echo $row['EntryHour'];
                                ?>
                            </h4>
                        </div>
                        <div id="right" class="column flex-column">
                            <h3 class="header-title">Saída</h3>
                            <h4 style="color: #404040" <?php if($row['LunchBreakManual'] == 1){echo "class='manual'";} ?>>
                                <?php
                                    echo $row['LunchBreak'];
                                ?>
                            </h4>
                        </div>
                    </div>
                    <h3 class="subtitle">Período Vespertino</h3>
                    
                    <div class="table" style="display:flex">
                        <div id="left" class="column flex-column">
                            <h3 class="header-title">Entrada</h3>
                            <h4 style="color: #404040" <?php if($row['LunchReturnManual'] == 1){echo "class='manual'";} ?>>
                                <?php
                                    echo $row['LunchReturn'];
                                ?>
                            </h4>
                        </div>
                        <div id="right" class="column flex-column">
                            <h3 class="header-title">Saída</h3>
                            <h4 style="color: #404040" <?php if($row['DepartureTimeManual'] == 1){echo "class='manual'";} ?>>
                                <?php
                                    echo $row['DepartureTime'];
                                    }
                                ?>
                            </h4>
                        </div>
                    </div>
                    <?php
                    if($rowsNumber > 0) {
                    echo '
                        <div id="tip-box" class="tip-box flex-column align-center">
                            <h2>Aviso</h2>
                            <span class="tip">Horários na cor laranja representam registros inseridos manualmente por algum administrador.</span>
                        </div>
                    ';
                    }
                    ?>
                </div>
            </div>
        </div>
        <script>
            let tooltip = document.querySelector("#text-registers");
            let tooltipText = document.querySelector("#registersTooltip-text");
            tooltip.onclick = () => {
                tooltipText.classList.add("fade");
                setTimeout(() => {
                    tooltipText.classList.remove("fade");
                }, 4000);
            };
            $(document).ready(function(){
                $('a:last').addClass('hidden');
                var popup = document.querySelector(".popup");
                let hour = document.getElementsByTagName("h4");
                let hourArray = [...hour];
                hourArray.forEach((element) => {
                    element.addEventListener('click', () => {
                        if(element.innerText == "") {
                            popup.classList.remove("hidden");
                            popup.classList.add("fade-popup");
                        } else {
                            document.querySelector("#loading").classList.remove("hidden");
                            document.querySelector("#spinner").classList.add("spin");
                            window.location.href = `receipt.php?hour=${element.innerText}&date=<?php echo $_GET['date']; ?>`;
                        }
                    });
                });
                document.querySelector(".popup-button").addEventListener('click', () => {
                    popup.classList.add("hidden");
                    popup.classList.remove("fade-popup");
                })
            });
            tipBox = document.querySelector("#tip-box");
            setTimeout(() => {
                tipBox.classList.add("fadeout");
                tipBox.addEventListener("animationend", (e) => {
                    e.target.classList.add("hidden");
                })
            }, 5000)
            let libRegisters = document.querySelector("#libras-registers");
            let closeRegisters = document.querySelector("#close-registers");
            let videoRegisters = document.querySelector("#registers-video");
            libRegisters.onclick = () => {
                videoRegisters.classList.remove("hidden");
            }
            closeRegisters.onclick = () => {
                videoRegisters.classList.add("hidden");
            }
        </script>
    </body>
</html>