<?php
session_start();
session_regenerate_id(true); // Regenerar ID de sesión para mayor seguridad

// Configurar origenes permitidos
$allowedOrigins = ['http://localhost'];
if (!in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)) {
    header("HTTP/1.1 403 Forbidden");
    exit('Origen no permitido');
}

header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
header('Content-Type: application/json');

// Crear el carrito si no existe
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Validar CSRF Token
$csrfToken = $_POST['csrf_token'] ?? '';
if ($csrfToken !== $_SESSION['csrf_token']) {
    http_response_code(403);
    echo json_encode(['message' => 'CSRF token inválido']);
    exit;
}

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        $input = json_decode(file_get_contents('php://input'), true);
        $destino = htmlspecialchars($input['destino']);
        $fechaInicio = htmlspecialchars($input['fechaInicio']);
        $fechaFin = htmlspecialchars($input['fechaFin']);
        $precio = filter_var($input['precio'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        $item = [
            'destino' => $destino,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'precio' => $precio
        ];

        $_SESSION['cart'][] = $item;
        echo json_encode(['message' => 'Item agregado al carrito', 'cart' => $_SESSION['cart']]);
        break;

    case 'checkout':
        $_SESSION['cart'] = [];
        echo json_encode(['message' => 'Compra finalizada']);
        break;

    default:
        echo json_encode(['cart' => $_SESSION['cart']]);
        break;
}
?>
