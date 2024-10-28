<?php
require_once 'model/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $origen = htmlspecialchars($_POST['origen']);
    $destino = htmlspecialchars($_POST['destino']);
    $fecha = htmlspecialchars($_POST['fecha']);
    $plazas_disponibles = (int)$_POST['plazas_disponibles'];
    $precio = (float)$_POST['precio'];

    if ($plazas_disponibles > 0 && $precio > 0) {
        try {
            $db = new DatabaseConnection();
            $conn = $db->getConnection();
            
            $sql = "INSERT INTO VUELO (origen, destino, fecha, plazas_disponibles, precio) VALUES (:origen, :destino, :fecha, :plazas_disponibles, :precio)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':origen', $origen);
            $stmt->bindParam(':destino', $destino);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':plazas_disponibles', $plazas_disponibles);
            $stmt->bindParam(':precio', $precio);
            $stmt->execute();

            echo "Vuelo registrado exitosamente.";
        } catch (PDOException $e) {
            echo "Error al registrar el vuelo: " . $e->getMessage();
        }
    } else {
        echo "Datos inválidos. Por favor, verifica los campos.";
    }
}
?>
