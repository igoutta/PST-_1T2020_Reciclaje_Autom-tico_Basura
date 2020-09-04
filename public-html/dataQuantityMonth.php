<?php
    include("conexion.php");
    // Es necesario indicar a la base de datos que trabaje con la información en Español
    // debido a que se utilizara este idioma para obtener los meses del año.
    mysqli_query($con, "SET lc_time_names = 'es_ES'");

    // Se realizan dos consultas, cada una por tipo de Objeto. Se 
    // requiere la cantidad de objetos según el mes del año, se usa 
    // el formato date_format(campo, formato) como campo seleccionado y 
    // objetivo de agrupamiento y se cuenta los obejtos con count(*).
    $query = "SELECT date_format(fecha, '%M-%y') as mes, count(*) as cuenta from RegistroObjeto inner join Contenedor on RegistroObjeto.id_contenedor=Contenedor.id  where Contenedor.tipo = 'papel' group by date_format(fecha, '%M-%y') order by fecha asc";
    $result = mysqli_query($con, $query);
    
    $meses = array();
    $cuenta = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($meses, $row['mes']);
        array_push($cuenta, (int)$row['cuenta']);
    }
    mysqli_free_result($result);

    // Esta consulta es igual a la anterior, pero como no se requiere 
    // presentar el mes ya que se obtiene este dato en la anterior consulta, 
    // así que se realiza la consulta con year(campo), month(fecha) 
    // ya que funciona de igual manera
    $query2 = "SELECT year(fecha), month(fecha), count(*) as cuenta from RegistroObjeto inner join Contenedor on RegistroObjeto.id_contenedor=Contenedor.id  where tipo = 'metal' group by EXTRACT(YEAR_MONTH FROM fecha) order by fecha asc";
    $result2 = mysqli_query($con, $query2);

    $cuenta2 = array();
    while ($row2= mysqli_fetch_array($result2)) {
        array_push($cuenta2, (int)$row2['cuenta']);
    }
    mysqli_free_result($result2);

    mysqli_close($con);
?>