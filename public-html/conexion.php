<?php

$db_user="id14598628_grupo8";

$db_password="vE)h4WebIQ>4kR~s";

$db_name="id14598628_reciclajeautomatico";

$db_host="localhost";

$con = mysqli_connect($db_host,$db_user,$db_password,$db_name);

if (!$con) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    exit;
}

?>