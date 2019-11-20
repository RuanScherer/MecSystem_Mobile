<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="ie-edge"/>
        <link rel="stylesheet" href="css/all.css?version=12"/>
        <link rel="stylesheet" href="css/index.css?version=12"/>
        <script src="scripts/jquery.js"></script>
    </head>
    <body>
        <div id="loading" class="loading-background flex-row flex-center hidden">
            <div id="spinner" class="loading-spinner"></div>
        </div>
        <div id="page" class="local-container hidden">
            <div id="home" class="flex-center flex-column">
                <img src="images/RoundedLogo.svg"/>
                <h1>Bem-Vindo!</h1>
                <div id="form">
                    <form class="form flex-center">
                        <input type="text" autocomplete="off" class="login-input" id="login" name="login" placeholder="Login" maxlength="14">
                        <input type="password" autocomplete="off" class="login-input" id="password" name="password" placeholder="Senha">
                        <h3 id="info">
                            <?php 
                                if (isset($_GET['erro'])) {
                                    if ($_GET['erro'] == "incorrect") {
                                        echo "Os dados informados são inválidos.";
                                    }
                                }
                            ?>
                        </h3>
                        <input type="submit" id="pronto" class="btn" value="Entrar">
                    </form>
                </div>
            </div>
        </div>
        <script>
            window.history.forward(1);
            window.onload = () => {
                document.getElementById("page").classList.remove("hidden");
            }
            let login = document.querySelector("#login");
            let password = document.querySelector("#password");
            let form = document.querySelector("#form");
            document.querySelector("#pronto").addEventListener('click', (event) => {
                event.preventDefault();
                if(login.value == "" || password.value == "") {
                    form.classList.add("validate-error");
                    form.addEventListener('animationend', (evt) => {
                        if(evt.animationName == "nono") {
                            form.classList.remove("validate-error");
                        }
                    })
                } else {
                    document.querySelector("#loading").classList.remove("hidden");
                    document.querySelector("#spinner").classList.add("spin");
                    window.location.href = `php/login.php?login=${login.value}&password=${password.value}`
                }
            });
            login.addEventListener('input', (e) => {
                if(login.value.length == 3 && e.inputType != "deleteContentBackward") {
                    login.value += ".";
                } else if (login.value.length == 7 && e.inputType != "deleteContentBackward") {
                    login.value += ".";
                } else if (login.value.length == 11 && e.inputType != "deleteContentBackward") {
                    login.value += "-";
                }
            })
        </script>

    </body>
</html>