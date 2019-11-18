<?php
    include 'connection.php';
    
    $sqlId = "select fk_electronicPoint from tb_point where idtb_point = ".$_SESSION['pointCode'];
    $resultId = mysqli_query($connection, $sqlId);

    while($row = mysqli_fetch_assoc($resultId)) {
        $sql = "select Locale, CNPJ from tb_electronicpoint inner join tb_company on idtb_company = fk_company
         where idtb_electronicPoint = ".$row['fk_electronicPoint']." and idtb_company = 1";
    }
    $result = mysqli_query($connection, $sql);
?>