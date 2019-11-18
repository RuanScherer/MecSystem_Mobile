<?php
    include 'connection.php';
    $sql = "select idtb_point, EntryHour, LunchBreak, LunchReturn, DepartureTime, EntryHourManual, LunchBreakManual, LunchReturnManual, DepartureTimeManual, UserName from tb_point inner join tb_user on fk_employee = idtb_user where date = '{$_GET['date']}' and UserCpf = '{$_GET['cpf']}'";
    
    $result = mysqli_query($connection, $sql);
    $rowsNumber = mysqli_num_rows($result);
?>