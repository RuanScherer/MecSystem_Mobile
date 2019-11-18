<?php
    session_start();
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
        <link rel="stylesheet" href="css/home.css?version=12">
        <script src="scripts/jquery.js"></script>
        <!-- Full Callendar -->
        <link href='css/main.min.css' rel='stylesheet' >
        <link href='css/mainb.min.css' rel='stylesheet'/>
        <link href='css/mainc.min.css' rel='stylesheet'/>
        <script src='scripts/main.min.js'></script>
        <script src='scripts/locales-all.js'></script>
        <script src='scripts/mainb.min.js'></script>
        <script src='scripts/mainc.min.js'></script>
        <script src='scripts/maind.min.js'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');
                var locale = 'pt-br';
                
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    contentHeight: 400,
                    plugins: [ 'interaction', 'dayGrid', 'timeGrid' ],
                    locale: locale,
                    height: 'auto',
                    selectable: true,
                    header: {
                        left: 'title',
                        center: '',
                        right: 'prev,next today'
                    },
                    dateClick: function(info) {
                        let date = info.dateStr;
                        document.querySelector("#loading").classList.remove("hidden");
                        document.querySelector("#spinner").classList.add("spin");
                        window.location.href = `registers.php?date=${date}`;
                    }
                });

            calendar.render();
            $('.fc-icon').css("color", "#fff");
            });
        </script>
    </head>
    <body>
        <div id="loading" class="loading-background flex-row flex-center hidden">
            <div id="spinner" class="loading-spinner"></div>
        </div>
        <div id="registers-video" class="video-tip flex-row flex-center hidden">
            <img id="close-registers" class="close-video" src="images/close.svg"/>
            <img class="gif-tip" src="videos/Navegue.gif"/>
        </div>
        <div class="local-container">
            <div class="flex-center flex-column content">
                <div id="home" class="flex flex-column align-center scrollable">
                    <h1 id="name">Olá, <?php echo utf8_encode($_SESSION['name']); ?></h1>
                    <h2 class="message">Aqui estão algumas informações sobre você na <?php echo utf8_encode($_SESSION['company']); ?></h2>
                    <ul class="data-list">
                        <li class="data flex-column flex-center">
                            <span>Código de Funcionário</span>
                            <span class="data-content">
                                <?php
                                    echo $_SESSION['codUser'];
                                ?>
                            </span>
                        </li>
                        <li class="data flex-column flex-center">
                            <span>CBO</span>
                            <span class="data-content">
                                <?php
                                    echo $_SESSION['cbo'];
                                ?>
                            </span>
                        </li>
                        <li class="data flex-column flex-center">
                            <span>Cargo</span>
                            <span class="data-content">
                                <?php
                                    echo utf8_encode($_SESSION['FunctionName']);
                                ?>
                            </span>
                        </li>
                        <li class="data flex-column flex-center">
                            <span>Código do Cartão Ponto</span>
                            <span class="data-content">
                                <?php
                                    echo $_SESSION['cardNumber'];
                                ?>
                            </span>
                        </li>
                    </ul>
                </div>
                <div id="registers" class="hidden flex flex-column align-center scrollable">
                    <div class="flex-row help">
                        <img src="images/libras.png" id="libras-registers"/>
                        <img src="images/help.svg" id="text-registers" />
                        <span id="registersTooltip-text" class="tooltip-text">
                            Navegue utilizando o calendário e selecione uma data para 
                            ver os registros de ponto correspondentes.
                        </span>
                    </div>
                    <div id="calendar"></div>
                </div>
            </div>
            <footer class="nav flex-column align-center">
                <h4><?php echo utf8_encode($_SESSION['company']); ?></h4>
                <div class="flex-row">
                    <div id="homeTab" class="tab flex-column flex-center selected-tab" style="width: 50% !important">
                        <span>Home</span>
                    </div>
                    <div id="registersTab" class="tab flex-column flex-center" style="width: 50% !important">
                        <span>Registros</span>
                    </div>
                </div>
            </footer>
        </div>
        <script>
            let textTooltip = document.querySelector("#text-registers");
            let tooltipText = document.querySelector("#registersTooltip-text");
            textTooltip.onclick = () => {
                tooltipText.classList.add("fade");
                setTimeout(() => {
                    tooltipText.classList.remove("fade");
                }, 5000);
            };
            $(document).ready(() => {
                $('a:last').addClass('hidden');
                let homeTab = document.querySelector("#homeTab");
                let registersTab = document.querySelector("#registersTab");
                let homeContent = document.querySelector("#home");
                let registersContent = document.querySelector("#registers");

                homeTab.addEventListener('click', (e) => {
                    homeContent.classList.remove("hidden");
                    registersContent.classList.add("hidden");
                    homeTab.classList.add("selected-tab");
                    registersTab.classList.remove("selected-tab");
                });
                registersTab.addEventListener('click', (e) => {
                    homeContent.classList.add("hidden");
                    registersContent.classList.remove("hidden");
                    homeTab.classList.remove("selected-tab");
                    registersTab.classList.add("selected-tab");
                });
                
                // REGISTERS TIP VIDEO
                let libRegisters = document.querySelector("#libras-registers");
                let closeRegisters = document.querySelector("#close-registers");
                let videoRegisters = document.querySelector("#registers-video");
                libRegisters.onclick = () => {
                    videoRegisters.classList.remove("hidden");
                }
                closeRegisters.onclick = () => {
                    videoRegisters.classList.add("hidden");
                }
            });
        </script>
    </body>
</html>