<?php
    include("conexion.php");

    // Esta consulta tiene como fin presenta un gráfica de peso en el tiempo
    // así que simplemente realizamos una consulta donde agrupamos por fecha
    // con GROUP BY y lo ordenamos ascendentemente con ORDER BY [campo] ASC.
    // y se obtiene la suma del peso de los objetos ese día con SUM(campo)
    $query = "SELECT fecha, sum(pesoObjeto) as peso from RegistroObjeto group by fecha order by fecha asc";
    $result = mysqli_query($con, $query);
    
    $data = array();
    while ($row = mysqli_fetch_array($result)) {
    // Para presentar los datos gráficados se requiere la fecha en el formato 
    // de Epoch time de gran magnitud (que incluye milisegundos) por lo que se
    // obtiene el dato de la fehca y se lo contatena con la hora de inicio
    // y luego se lo transforma con el comando strtotime(). Dado que esto no 
    // entrega el formato largo se multiplica por mil.
        array_push($data, array(strtotime($row['fecha'].' 00:00:00')*1000,round($row['peso'],2)));
    }
    mysqli_free_result($result);

    // Para trabajar en Javascript, la gran mayoría de veces es necesario un 
    // formato donde se guardan y se reciban datos, en este caso es el formato 
    // JSON. Para presentar nuestro arreglo en ese formato de modo que se trabaje
    // correctamente en Javascript se usa el comando json_encode($array, OPCIONES) 
    // donde se ingresa el array a codificar, y la opcion para presentarlo 
    // con llaves y corchetes es JSON_PRETTY_PRINT
    echo json_encode($data, JSON_PRETTY_PRINT);
?>