<?php
    include 'connection.php';
    $sql = "select UserName, UserLastName, UserCpf from tb_user where UserName = '{$_GET['name']}' or UserLastName = '{$_GET['name']}'";
    $result = mysqli_query($connection, $sql);
?>