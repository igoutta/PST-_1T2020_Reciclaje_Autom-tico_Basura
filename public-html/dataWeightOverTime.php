<?php
    include("conexion.php");

    $query = "SELECT fecha, sum(pesoObjeto) as peso from RegistroObjeto group by fecha order by fecha asc";
    $result = mysqli_query($con, $query);
    
    $data = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($data, array(strtotime($row['fecha'].' 00:00:00')*1000,round($row['peso'],2)));
    }
    mysqli_free_result($result);

    echo json_encode($data, JSON_PRETTY_PRINT);
?>