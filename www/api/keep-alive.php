<?php
session_start();
session_regenerate_id(true); // Regenerar ID de sesión

// Validar el origen
$allowedOrigins = ['https://localhost'];
if (!in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
    header("HTTP/1.1 403 Forbidden");
    exit('Origen no permitido');
}

header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
header('Content-Type: application/json');

// Validar CSRF Token
$csrfToken = $_POST['csrf_token'] ?? '';
if ($csrfToken !== $_SESSION['csrf_token']) {
    http_response_code(403);
    echo json_encode(['message' => 'CSRF token inválido']);
    exit;
}

echo json_encode(['message' => 'Sesión actualizada']);
?>
