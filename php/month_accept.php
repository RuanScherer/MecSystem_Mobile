<?php
    include 'connection.php';
    session_start();
    
    $passRes = mysqli_query($connection, "select idtb_user, UserPassword from tb_user where UserEmail = '".$_SESSION['email']."'");
    while($row = mysqli_fetch_assoc($passRes)) {
        if($row['UserPassword'] == $_POST['password']) {
            $sql = "update tb_monthControl set Status = 'Confirmado' where fk_user = '".$row['idtb_user']."' and month(DateControl) = month(now()) and year(DateControl) = year(now());";
            mysqli_query($connection, $sql);
            header('Location: ../month_closed.html');
        } else {
            header('Location: ../authentication_error.html');
        }
    }
?>