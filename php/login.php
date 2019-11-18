<?php
    session_start();
    include 'connection.php';
    
    if(empty($_GET["login"] || empty($_GET["password"]))) {
        //verifica se os posts estão vazios, para evitar acesso direto a esta página
        header("Location: ../index.php");
        exit();
    }
    
    $login = mysqli_real_escape_string($connection, $_GET["login"]);
    $password = mysqli_real_escape_string($connection, $_GET["password"]);
    
    $sql = "select * from tb_user where UserCpf='$login' and UserPassword='$password'";
    $result = mysqli_query($connection, $sql);

    $sqlCompany = "select CompanyName from tb_company where idtb_company = 1";
    $resultCompany = mysqli_query($connection, $sqlCompany);
    
    $rows = mysqli_num_rows($result);
    
    $functionQuery = "";
    $functionResult = "";

    if ($rows == 1) {
        // salva os dados do usuário na sessão
        while($row = mysqli_fetch_assoc($result)) {
            $functionQuery = "select FunctionName, CBO from tb_function where idtb_function = '".$row['fk_function']."'";
            $functionResult = mysqli_query($connection, $functionQuery);
            while($function_row = mysqli_fetch_assoc($functionResult)) {
                $_SESSION['FunctionName'] = $function_row['FunctionName'];
                $_SESSION['cbo'] = $function_row['CBO'];
            }
            $_SESSION['codUser'] = $row['idtb_user'];
            $_SESSION['name'] = $row['UserName'];
            $_SESSION['lastName'] = $row['UserLastName'];
            $_SESSION['cardNumber'] = $row['CardNumber'];
            $_SESSION['PIS'] = $row['PIS'];
            while($company = mysqli_fetch_assoc($resultCompany)){
                $_SESSION['company'] = $company['CompanyName'];
            }
            // redireciona para a página do tipo do usuário
            if ($row['Admin'] == 0) {
                header("Location: ../home_func.php");
            } else {
                header("Location: ../home_admin.php");
            }
        }
        exit();
    } else {
        header("Location: ../index.php?erro=incorrect");
        exit();
    }
?>