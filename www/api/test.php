<?php
require_once 'model/db.php';

$db = new DatabaseConnection();
$connection = $db->getConnection();

if ($connection) {
    echo "Conexión exitosa";
} else {
    echo "Error al conectar a la base de datos";
}
?>