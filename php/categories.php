<?php
    include 'connection.php';
    $sql = "select * from tb_function";
    $result = mysqli_query($connection, $sql);
?>