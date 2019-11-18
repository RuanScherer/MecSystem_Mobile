<?php
    include 'connection.php';
    $sql = "select UserName, UserLastName, UserCpf from tb_user inner join tb_function on idtb_function = fk_function where FunctionName = '{$_GET['categorie']}'";
    $result = mysqli_query($connection, $sql);
?>