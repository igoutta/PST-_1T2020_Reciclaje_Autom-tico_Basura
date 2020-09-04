<?php
    // Ejecuta el código del archivo nombrado y concatena sus variables
    include("conexion.php");

    // Se indica una consulta donde se obtiene un campo, la suma de otro campo y 
    // se cuenta la cantidad de campos según el agrupamiento hecho por GROUP BY.
    // Notesé que en esta consulta se une temporalmente la tabla de RegistroObjeto
    // con Contenedor mediante su clave compartida, y así se resuleve bien la consulta. 
    $query = "SELECT tipo, sum(pesoObjeto) as peso, count(*) as amount from RegistroObjeto inner join Contenedor on RegistroObjeto.id_contenedor=Contenedor.id group by tipo";
    // Realiza la consulta con la base de datos
    $result = mysqli_query($con, $query);
    
    // Variables donde se guardan los resultados que se necesitan para mostrar en las gráficas
    $tipos = array();
    $cantidad = array();
    $peso = array();
    // Se navega por todas las filas de la consulta y se ingresar los resultados
    // en los array correspondientes
    while ($row = mysqli_fetch_array($result)) {
        array_push($tipos, $row['tipo']);
        array_push($cantidad, (int)$row['amount']);
        array_push($peso, round($row['peso'],2));
    }
    // Libera el resultado de la memoria
    mysqli_free_result($result);
    // Cierra a conexión con la base de datos
    mysqli_close($con);
?>