<?php
require_once 'model/db.php';

try {
    $db = new DatabaseConnection();
    $conn = $db->getConnection();

    // Obtener vuelos y hoteles con coincidencias entre destino (vuelo) y ubicación (hotel)
    $sql = "SELECT v.id_vuelo, h.id_hotel, v.destino
            FROM VUELO v
            INNER JOIN HOTEL h ON v.destino = h.ubicacion";
    $stmt = $conn->query($sql);
    $coincidencias = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Validar que existan coincidencias
    if (count($coincidencias) === 0) {
        throw new Exception("No hay coincidencias entre los destinos de los vuelos y las ubicaciones de los hoteles.");
    }

    // Obtener las ubicaciones únicas
    $ubicaciones = array_unique(array_column($coincidencias, 'destino'));

    // Verificar que haya suficientes ubicaciones
    if (count($ubicaciones) < 1) {
        throw new Exception("No hay suficientes ubicaciones disponibles.");
    }

    // Crear un arreglo para hacer un seguimiento de cuántas reservas se han hecho por ubicación
    $reservas_por_ubicacion = [];

    // Realizar al menos una reserva por cada ubicación
    foreach ($ubicaciones as $ubicacion) {
        // Obtener una coincidencia aleatoria para esta ubicación
        $opciones = array_filter($coincidencias, function($coincidencia) use ($ubicacion) {
            return $coincidencia['destino'] === $ubicacion;
        });
        $coincidencia = $opciones[array_rand($opciones)];

        $id_cliente = rand(1, 100);
        $id_vuelo = $coincidencia['id_vuelo'];
        $id_hotel = $coincidencia['id_hotel'];
        $fecha_reserva = date('Y-m-d', strtotime("+1 days"));

        // Insertar la reserva
        $sql_reserva = "INSERT INTO RESERVAS (id_cliente, fecha_reserva, id_vuelo, id_hotel) 
                        VALUES (:id_cliente, :fecha_reserva, :id_vuelo, :id_hotel)";
        $stmt_reserva = $conn->prepare($sql_reserva);
        $stmt_reserva->bindParam(':id_cliente', $id_cliente);
        $stmt_reserva->bindParam(':fecha_reserva', $fecha_reserva);
        $stmt_reserva->bindParam(':id_vuelo', $id_vuelo);
        $stmt_reserva->bindParam(':id_hotel', $id_hotel);
        $stmt_reserva->execute();

        echo "Se ha registrado una reserva para la ubicación: $ubicacion.<br>";

        // Registrar que se ha hecho una reserva para esta ubicación
        $reservas_por_ubicacion[$ubicacion] = 1;
    }

    // Insertar las otras 6 reservas considerando las ubicaciones, pero sin necesidad de cumplir con la regla de 1 por ubicación
    for ($i = count($ubicaciones) + 1; $i <= 10; $i++) {
        $coincidencia = $coincidencias[array_rand($coincidencias)]; // Seleccionar aleatoriamente una coincidencia

        $id_cliente = rand(1, 100);
        $id_vuelo = $coincidencia['id_vuelo'];
        $id_hotel = $coincidencia['id_hotel'];
        $fecha_reserva = date('Y-m-d', strtotime("+$i days"));

        // Insertar la reserva
        $sql_reserva = "INSERT INTO RESERVAS (id_cliente, fecha_reserva, id_vuelo, id_hotel) 
                        VALUES (:id_cliente, :fecha_reserva, :id_vuelo, :id_hotel)";
        $stmt_reserva = $conn->prepare($sql_reserva);
        $stmt_reserva->bindParam(':id_cliente', $id_cliente);
        $stmt_reserva->bindParam(':fecha_reserva', $fecha_reserva);
        $stmt_reserva->bindParam(':id_vuelo', $id_vuelo);
        $stmt_reserva->bindParam(':id_hotel', $id_hotel);
        $stmt_reserva->execute();
    }

    echo "Se han registrado 6 reservas adicionales sin importar la ubicación.";
} catch (PDOException $e) {
    echo "Error al insertar las reservas: " . $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
