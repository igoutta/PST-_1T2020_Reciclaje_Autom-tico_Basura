<?php
$db_user="id14598628_grupo8";
$db_password="vE)h4WebIQ>4kR~s";
$db_name="id14598628_reciclajeautomatico";
$db_server="localhost";

$con = mysqli_connect($db_server,$db_user,$db_password,$db_name);
if (!$con) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_errno() . PHP_EOL;
    exit;
}
?>

<html>
<head>
</head>
<title> Conectando a la base de datos MySQL </title> 
<body>
<table border="1">
<tr>
  <td colspan="4">CONSULTA DE OBJETOS</td> 

</tr>
<tr>
  <td>ID</td>
  <td>Peso</td>
  <td>Fecha</td>
  <td>Hora</td>
  <td>idContenedor</td>
</tr>

<?php
$result = mysqli_query($con, "select * from RegistroObjeto");
while($row = mysqli_fetch_array($result)){
?>

<tr>
  <td> <?php echo $row["id_objeto"]; ?> </td>
  <td> <?php echo $row["pesoObjeto"]; ?> </td>
  <td> <?php echo $row["fecha"]; ?> </td>
  <td> <?php echo $row["hora"]; ?> </td>
  <td> <?php echo $row["id_contenedor"]; ?> </td>
</tr>

<?php
}
?>
</table>

<?php
echo "Consulta realizada exitosamente...";
mysqli_free_result($result);
mysqli_close($con);
?>
</body>
</html>
