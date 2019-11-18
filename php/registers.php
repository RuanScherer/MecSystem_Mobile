<?php
    include 'connection.php';
    $sql = "select idtb_point, EntryHour, LunchBreak, LunchReturn, DepartureTime,  EntryHourManual, LunchBreakManual, LunchReturnManual, DepartureTimeManual, idtb_user from tb_point inner join tb_user on fk_employee = idtb_user where Date = '{$_GET['date']}'
    and idtb_user = '".$_SESSION['codUser']."'";

    $result = mysqli_query($connection, $sql);
    $rowsNumber = mysqli_num_rows($result);
?>