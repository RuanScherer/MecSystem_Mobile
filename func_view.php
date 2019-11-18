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
        <link rel="stylesheet" href="css/func_view.css?version=12">
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
                        let search = location.search;
                        let parameters = search.replace("?", "");
                        parameters = parameters.split("&");
                        document.querySelector("#loading").classList.remove("hidden");
                        document.querySelector("#spinner").classList.add("spin");
                        window.location.href = `registers_for_admin.php?date=${date}&${parameters[1]}&name=<?php echo $_GET['name']; ?>`;
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
        <div class="flex-row popup hidden">
           <div class="flex-column popup-content">
                <h2 class="popup-title">Aviso</h2>
                <h3 class="popup-text">Não foi possível carregar informações sobre o colaborador.</h3>
                <button class="popup-button">Entendi</button>
            </div>
        </div>
        <?php
        if($_GET['cpf'] != null){
            echo "
            <div class='local-container'>
                <div id='home' class='flex-center flex-column scrollable'>
                    <div class='flex-row help'>
                        <img src='images/libras.png' id='libras-registers'/>
                        <img src='images/help.svg' id='text-registers' />
                        <span id='registersTooltip-text' class='tooltip-text'>
                            Navegue utilizando o calendário e selecione uma data para 
                            ver os registros de ponto correspondentes.
                        </span>
                    </div>
                    <h1 id='title'>Colaborador</h1>
                    <h1 id='name'>";
            echo $_GET['name'];
            echo "</h1>
                    <h3 id='function'>";
            echo @$_GET['categorie'];
            echo "</h3>
                    <div id='calendar'></div>
                </div>
            </div>";
        } else {
            echo "
            <script>
                document.querySelector('.popup').classList.remove('hidden');
                document.querySelector('.popup').classList.add('fade-popup');
                document.querySelector('.popup-button').addEventListener('click', () => {
                    document.querySelector('#loading').classList.remove('hidden');
                    document.querySelector('#spinner').classList.add('spin');
                    javascript:history.back(-1)
                });
            </script>";
        }
        ?>
        <script>
            $(document).ready(() => {
                $('a:last').addClass('hidden');
                let textTooltip = document.querySelector("#text-registers");
                let tooltipText = document.querySelector("#registersTooltip-text");
                textTooltip.onclick = () => {
                    tooltipText.classList.add("fade");
                    setTimeout(() => {
                        tooltipText.classList.remove("fade");
                    }, 5000);
                };
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