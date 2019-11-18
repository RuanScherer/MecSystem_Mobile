<?php
    session_start();
    include "php/search-by-categorie.php";
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
        <div id="loading" class="loading-background flex-row flex-center hidden">
            <div id="spinner" class="loading-spinner"></div>
        </div>
        <div id="categorie-video" class="video-tip flex-row flex-center hidden">
            <img id="close-categorie" class="close-video" src="images/close.svg"/>
            <img class="gif-tip" src="videos/Circulo.gif"/>
        </div>
       <div class="flex-row popup hidden">
           <div class="flex-column popup-content">
                <h2 class="popup-title">Aviso</h2>
                <h3 class="popup-text">Não existem colaboradores cadastrados para o cargo selecionado.</h3>
                <button class="popup-button">Entendi</button>
            </div>
       </div>
        <div class="container page-fade">
            <div id="home" class="flex-center flex-column scrollable">
                <div class="flex-row help">
                    <img src="images/libras.png" id="libras-categorie"/>
                    <img src="images/help.svg" id="text-categorie" />
                    <span id="categorieTooltip-text" class="tooltip-text">
                        O círculo azul ao lado do nome representa a presença do colaborador na empresa e o cinza, ausência. Tocando sobre algum nome você pode saber mais sobre o colaborador.
                    </span>
                </div>
                <div id="header" class="flex-center flex-column">
                    <h1 id="title"><?php echo utf8_encode($_GET['categorie']); ?></h1>
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
                                document.querySelector('#loading').classList.remove('hidden');
                                document.querySelector('#spinner').classList.add('spin');
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
                        document.querySelector('#loading').classList.remove('hidden');
                        document.querySelector('#spinner').classList.add('spin');
                        window.location.href = <?php echo utf8_encode('`func_view.php?name=${e.children[1].innerHTML}&cpf=${e.children[2].innerText}&${parameters}`'); ?>;
                    });
                });
                let categorieTooltip = document.querySelector("#text-categorie");
                let categorieTooltipText = document.querySelector("#categorieTooltip-text");
                categorieTooltip.onclick = () => {
                    categorieTooltipText.classList.add("fade");
                    setTimeout(() => {
                        categorieTooltipText.classList.remove("fade");
                    }, 5000);
                };
                // REGISTERS TIP VIDEO
                let libCategorie = document.querySelector("#libras-categorie");
                let closeCategorie = document.querySelector("#close-categorie");
                let videoCategorie = document.querySelector("#categorie-video");
                libCategorie.onclick = () => {
                    videoCategorie.classList.remove("hidden");
                }
                closeCategorie.onclick = () => {
                    videoCategorie.classList.add("hidden");
                }
            });
        </script>
    </body>
</html>