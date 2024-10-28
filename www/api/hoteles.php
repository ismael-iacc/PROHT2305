<?php
require_once 'model/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre']);
    $ubicacion = htmlspecialchars($_POST['ubicacion']);
    $habitaciones_disponibles = (int)$_POST['habitaciones_disponibles'];
    $tarifa_noche = (float)$_POST['tarifa_noche'];

    if ($habitaciones_disponibles > 0 && $tarifa_noche > 0) {
        try {
            $db = new DatabaseConnection();
            $conn = $db->getConnection();
            
            $sql = "INSERT INTO HOTEL (nombre, ubicacion, habitaciones_disponibles, tarifa_noche) VALUES (:nombre, :ubicacion, :habitaciones_disponibles, :tarifa_noche)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':ubicacion', $ubicacion);
            $stmt->bindParam(':habitaciones_disponibles', $habitaciones_disponibles);
            $stmt->bindParam(':tarifa_noche', $tarifa_noche);
            $stmt->execute();

            echo "Hotel registrado exitosamente.";
        } catch (PDOException $e) {
            echo "Error al registrar el hotel: " . $e->getMessage();
        }
    } else {
        echo "Datos inválidos. Por favor, verifica los campos.";
    }
}
?>
