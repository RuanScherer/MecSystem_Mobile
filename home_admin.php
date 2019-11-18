<?php
    session_start();
    include 'php/categories.php';
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
        <link rel="stylesheet" href="css/all.css"/>
        <link rel="stylesheet" href="css/home_adm.css"/>
        <script src=scripts/jquery.js></script>
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
        <div id="search-video" class="video-tip flex-row flex-center hidden">
            <img id="close-search" class="close-video" src="images/close.svg"/>
            <img class="gif-tip" src="videos/Utilize.gif"/>
        </div>
        <div class="local-container page-fade">
            <div class="flex-center flex-column content">
                <div id="home" class="flex flex-column align-center scrollable">
                    <h1 id="name">Olá, <?php echo utf8_encode($_SESSION['name']); ?></h1>
                    <h2 class="message">Aqui estão algumas informações sobre você na MecSystem</h2>
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
                <div id="search-content" class="hidden flex-column align-center scrollable">
                    <div class="flex-row help">
                        <img src="images/libras.png" id="libras-search"/>
                        <img src="images/help.svg" id="text-search" />
                        <span id="searchTooltip-text" class="tooltip-text">
                            Utilize a barra de pesquisa para buscar por funcionários com um nome específico ou
                            toque sobre algum cargo para visualizar os colaboradores que exercem dele.
                        </span>
                    </div>
                    <div id="search" class="flex-row">
                        <input type="text" placeholder="Busque aqui..." class="search-input" id="searchInput">
                        <button id="searchButton" class="search-button">Buscar</button>
                    </div>
                    <h2 class="subtitle">Cargos na sua empresa</h2>
                    <div id="categories-container" class="flex-row flex-wrap">
                        <?php
                            while($row = mysqli_fetch_assoc($result)){
                                echo utf8_encode("<div class='categorie'><h3 class='categorie-name'>{$row['FunctionName']}</h3></div>");
                            }
                        ?>
                    </div>
                </div>
            </div>
            <footer class="nav flex-column flex-center">
                <h4><?php echo utf8_encode($_SESSION['company']); ?></h4>
                <div class="flex-row">
                    <div id="homeTab" class="tab flex-column flex-center selected-tab">
                        <span>Home</span>
                    </div>
                    <div id="registersTab" class="tab flex-column flex-center">
                        <span>Registros</span>
                    </div>
                    <div id="searchTab" class="tab flex-column flex-center">
                        <span>Buscar</span>
                    </div>
                </div>
            </footer>
        </div>
        <script>
            $(document).ready(() => {
                $('a:last').addClass('hidden');
                let categories = [...document.getElementsByClassName('categorie')];
                categories.forEach((e) => {
                    e.addEventListener('click', () => {
                        document.querySelector("#loading").classList.remove("hidden");
                        document.querySelector("#spinner").classList.add("spin");
                        window.location.href = `categorie_results.php?categorie=${e.children[0].innerHTML}`;
                    });
                });
                let searchButton = document.getElementById("searchButton");
                let nameInput = document.getElementById("searchInput");
                nameInput.value = "";
                searchButton.addEventListener('click', () => {
                    document.querySelector("#loading").classList.remove("hidden");
                    document.querySelector("#spinner").classList.add("spin");
                    window.location.href = `search_results.php?name=${nameInput.value}`;
                });
                let homeTab = document.querySelector("#homeTab");
                let registersTab = document.querySelector("#registersTab");
                let configTab = document.querySelector("#searchTab");
                let homeContent = document.querySelector("#home");
                let registersContent = document.querySelector("#registers");
                let settingsContent = document.querySelector("#search-content");
                homeTab.addEventListener('click', () => {
                    homeContent.classList.remove("hidden");
                    registersContent.classList.add("hidden");
                    settingsContent.classList.add("hidden");
                    homeTab.classList.add("selected-tab");
                    registersTab.classList.remove("selected-tab");
                    configTab.classList.remove("selected-tab");
                });
                registersTab.addEventListener('click', () => {
                    homeContent.classList.add("hidden");
                    registersContent.classList.remove("hidden");
                    settingsContent.classList.add("hidden");
                    homeTab.classList.remove("selected-tab");
                    registersTab.classList.add("selected-tab");
                    configTab.classList.remove("selected-tab");
                });
                configTab.addEventListener('click', () => {
                    homeContent.classList.add("hidden");
                    registersContent.classList.add("hidden");
                    settingsContent.classList.remove("hidden");
                    homeTab.classList.remove("selected-tab");
                    registersTab.classList.remove("selected-tab");
                    configTab.classList.add("selected-tab");
                });
                //tooltips
                let registersTooltip = document.querySelector("#text-registers");
                let registersTooltipText = document.querySelector("#registersTooltip-text");
                registersTooltip.onclick = () => {
                    registersTooltipText.classList.add("fade");
                    setTimeout(() => {
                        registersTooltipText.classList.remove("fade");
                    }, 5000);
                };
                let searchTooltip = document.querySelector("#text-search");
                let searchTooltipText = document.querySelector("#searchTooltip-text");
                searchTooltip.onclick = () => {
                    searchTooltipText.classList.add("fade");
                    setTimeout(() => {
                        searchTooltipText.classList.remove("fade");
                    }, 5000);
                };
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
            
            // SEARCH TIP VIDEO
            let libSearch = document.querySelector("#libras-search");
            let closeSearch = document.querySelector("#close-search");
            let videoSearch = document.querySelector("#search-video");
            libSearch.onclick = () => {
                videoSearch.classList.remove("hidden");
            }
            closeSearch.onclick = () => {
                videoSearch.classList.add("hidden");
            }
        </script>
    </body>
</html>