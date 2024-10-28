<?php
header('Content-Type: application/json');

function generarNotificacionOferta() {
    $ofertas = [
        "¡Oferta especial! 20% de descuento en paquetes a Madrid.",
        "¡No te lo pierdas! 15% de descuento en paquetes a París por tiempo limitado.",
        "¡Oferta relámpago! Reserva ahora y obtén un 10% de descuento en paquetes a Londres.",
        "¡Descuento sorpresa! 25% de descuento en paquetes a Roma, solo por hoy."
    ];
    
    $ofertaAleatoria = $ofertas[array_rand($ofertas)];
    
    echo json_encode(["oferta" => $ofertaAleatoria]);
}

generarNotificacionOferta();
