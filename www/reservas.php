<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Reservas</title>
    <link rel="stylesheet" href="styles.css"> <!-- Enlace a tu hoja de estilos -->
</head>
<body>

<div id="results-container">
<?php
require_once 'api/model/db.php';

try {
    $db = new DatabaseConnection();
    $conn = $db->getConnection();

    $sql = "SELECT h.nombre, h.ubicacion, COUNT(r.id_reserva) AS num_reservas
            FROM HOTEL h
            INNER JOIN RESERVAS r ON h.id_hotel = r.id_hotel
            GROUP BY h.id_hotel
            HAVING num_reservas > 2";
    
    $stmt = $conn->query($sql);
    $hoteles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($hoteles) {
        echo "<h2>Hoteles con más de 2 Reservas</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Nombre del Hotel</th><th>Ubicación</th><th>Número de Reservas</th></tr>";
        foreach ($hoteles as $hotel) {
            echo "<tr>
                    <td>{$hotel['nombre']}</td>
                    <td>{$hotel['ubicacion']}</td>
                    <td>{$hotel['num_reservas']}</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "No hay hoteles con más de 2 reservas.";
    }
} catch (PDOException $e) {
    echo "Error al consultar los hoteles: " . $e->getMessage();
}
?>
</div>

</body>
</html>
