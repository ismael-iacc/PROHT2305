<?php
header('Content-Type: application/json');

$destinos = [
    ["name" => "Madrid"],
    ["name" => "Barcelona"],
    ["name" => "París"],
    ["name" => "Londres"],
    ["name" => "Roma"]
];

echo json_encode(["destinations" => $destinos]);
