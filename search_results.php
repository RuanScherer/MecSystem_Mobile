<?php
    session_start();
    include 'php/func.php';
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
        <link rel="stylesheet" href="css/categorie_results.css"/>
        <script src="scripts/jquery.js"></script>
    </head>
    <body>
        <div id="search-video" class="video-tip flex-row flex-center hidden">
            <img id="close-search" class="close-video" src="images/close.svg"/>
            <img class="gif-tip" src="videos/Circulo.gif"/>
        </div>
       <div class="flex-row popup hidden fade-popup">
           <div class="flex-column popup-content">
                <h2 class="popup-title">Aviso</h2>
                <h3 class="popup-text">A busca não retornou nenhum resultado.</h3>
                <button class="popup-button" style="background-color: white">Entendi</button>
            </div>
       </div>
        <div class="container">
            <div id="home" class="flex-center flex-column scrollable">
                <div class="flex-row help">
                    <img src="images/libras.png" id="libras-search"/>
                    <img src="images/help.svg" id="text-search" />
                    <span id="searchTooltip-text" class="tooltip-text">
                        O círculo azul ao lado do nome representa a presença do colaborador na empresa e o cinza, ausência. Tocando sobre algum nome você pode saber mais sobre o colaborador.
                    </span>
                </div>
                <div id="header" class="flex-center flex-column">
                    <h1 id="title">Busca</h1>
                </div>
                <div class="content">
                    <?php 
                    if(mysqli_num_rows($result) > 0){
                        echo "<div id='results' class='flex-column flex-center'>";
                        while($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="list-item"><span class="status ';
                            $verification = "SELECT EntryHour, LunchBreak, LunchReturn, DepartureTime FROM tb_point WHERE fk_employee = (SELECT idtb_user FROM tb_user WHERE UserName = '".$row['UserName']."') AND DATE = DATE(NOW());";
                            $verificationResult = mysqli_query($connection, $verification);
                            if(mysqli_num_rows($verificationResult) > 0) {
                                while($dataRow = mysqli_fetch_assoc($verificationResult)) {
                                    if($dataRow['EntryHour'] != null && $dataRow['LunchBreak'] == null) {
                                        echo 'online';
                                    } else if ($dataRow['LunchReturn'] != null && $dataRow['DepartureTime'] == null) {
                                        echo 'online';
                                    } else {
                                        echo 'offline';
                                    }
                                }
                            } else {
                                echo 'offline';
                            }
                            echo utf8_encode('">&#9679</span><span>'.$row['UserName'].' '.$row['UserLastName'].'</span><h1 class="hidden">'.$row['UserCpf'].'</h1></div>');
                        }          
                        echo "</div>";
                    } else {
                        echo "
                        <script>
                            document.querySelector('.popup').classList.remove('hidden');
                            document.querySelector('.popup').classList.add('fade-popup');
                            document.querySelector('.popup-button').addEventListener('click', () => {
                                javascript:history.back(-1)
                            });
                        </script>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(() => {
                $('a:last').addClass('hidden');
                $('span:last').css("border-bottom", "none");
                let funcs = [...document.getElementsByClassName("list-item")];
                let search = location.search;
                let parameters = search.replace("?", "");
                funcs.forEach((e) => {
                    e.addEventListener('click', () => {
                        window.location.href = `func_view.php?name=${e.children[1].innerHTML}&cpf=${e.children[2].innerText}`;
                    });
                });
                let searchTooltip = document.querySelector("#text-search");
                let searchTooltipText = document.querySelector("#searchTooltip-text");
                searchTooltip.onclick = () => {
                    searchTooltipText.classList.add("fade");
                    setTimeout(() => {
                        searchTooltipText.classList.remove("fade");
                    }, 5000);
                };
                
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
            });
        </script>
    </body>
</html>