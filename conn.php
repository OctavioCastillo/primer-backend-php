<?php

//variables inician con $
$db_host = 'localhost';
$db_username = 'sa';
$db_password = '0117';
$db_database = 'escuela';

$db = new mysqli($db_host, $db_username, $db_password, $db_database);
mysqli_query($db, "SET NAMES 'utf8'");

if($db->connect_errno > 0){
    die('No es posible conectarse a la base de datos ['. $db->connect_error .']');
}
else{
    echo "Conexión exitosa";
}

