<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Intención de Viaje</title>
    <link rel="stylesheet" href="styles.css">
    <meta name="csrf-token" content="<?php echo $_SESSION['csrf_token']; ?>">
</head>
<body>
    <div class="search-container">
        <form id="search-form" onsubmit="event.preventDefault(); search();">
            <select id="destination-select" name="destino" required>
                <option value="">Selecciona un destino</option>
            </select>
            <input type="date" id="travel-date" name="fechaInicio" placeholder="Fecha de inicio del viaje" required />
            <input type="date" id="fechaFin" name="fechaFin" placeholder="Fecha de fin del viaje" required />
            <label for="precio-min">Precio Mínimo:</label>
            <input type="number" id="precio-min" placeholder="Min" />

            <label for="precio-max">Precio Máximo:</label>  
            <input type="number" id="precio-max" placeholder="Max" />

            <select id="service-type-select" name="tipoServicio" required>
                <option value="">Selecciona un tipo de servicio</option>
                <option value="hotel">Hotel</option>
                <option value="paquete">Paquete Turístico</option>
                <option value="vuelo">Vuelo</option>
            </select>
            <input type="number" id="duracion" name="duracion" placeholder="Duración del viaje (días)" min="1" required />
            <input type="submit" value="Buscar">
        </form>
    </div>

    <div id="results-container"></div>
    <div id="cart-container">
        <h2>Carrito de Compra</h2>
        <ul id="cart-list"></ul>
        <button onclick="checkout()">Finalizar Compra</button>
    </div>

    <script src="script.js"></script>
</body>
</html>
