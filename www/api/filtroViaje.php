<?php
session_start();
session_regenerate_id(true); // Regenerar ID de sesión para mayor seguridad

header('Content-Type: application/json');

// Verificar y sanitizar las entradas
$destino = htmlspecialchars($_POST['destino']);
$fechaInicio = htmlspecialchars($_POST['fechaInicio']);
$fechaFin = htmlspecialchars($_POST['fechaFin']);
$tipoServicio = htmlspecialchars($_POST['tipoServicio']);
$duracion = filter_var($_POST['duracion'], FILTER_SANITIZE_NUMBER_INT);
$csrfToken = $_POST['csrf_token'] ?? '';

// Simulación de datos de paquetes turísticos con diferentes tipos de servicio
$paquetesDisponibles = [
    [
        "destino" => "Londres",
        "fechaInicio" => "2024-10-20",
        "fechaFin" => "2024-10-25",
        "tipoServicio" => "paquete",
        "precio" => "1500",
        "disponibilidad" => "Disponible",
        "duracion" => 5
    ],
    [
        "destino" => "Roma",
        "fechaInicio" => "2024-11-10",
        "fechaFin" => "2024-11-15",
        "tipoServicio" => "hotel",
        "precio" => "1200",
        "disponibilidad" => "Disponible",
        "duracion" => 5
    ],
    [
        "destino" => "Barcelona",
        "fechaInicio" => "2024-12-01",
        "fechaFin" => "2024-12-05",
        "tipoServicio" => "vuelo",
        "precio" => "800",
        "disponibilidad" => "Disponible",
        "duracion" => 4
    ],
];

// Filtrar paquetes según los datos proporcionados
$resultados = array_filter($paquetesDisponibles, function($paquete) use ($destino, $fechaInicio, $fechaFin, $tipoServicio, $duracion) {
    return $paquete['destino'] === $destino &&
           $paquete['fechaInicio'] === $fechaInicio &&
           $paquete['fechaFin'] === $fechaFin &&
           $paquete['tipoServicio'] === $tipoServicio &&
           $paquete['duracion'] == $duracion;
});

// Enviar la respuesta en JSON, manteniendo la estructura de datos esperada
if (!empty($resultados)) {
    echo json_encode(["paquete" => array_values($resultados)[0]]);
} else {
    echo json_encode(["paquete" => null]);
}
?>
