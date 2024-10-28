<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Vuelo</title>
    <link rel="stylesheet" href="styles.css">
    <script src="js/vuelos.js"></script>
</head>
<body>
    <form name="formVuelo" action="/api/vuelos.php" method="post" onsubmit="return validarVuelo();">
        <input type="text" name="origen" placeholder="Origen" required><br><br>
        <input type="text" name="destino" placeholder="Destino" required><br><br>
        <input type="date" name="fecha" required><br><br>
        <input type="number" name="plazas_disponibles" placeholder="Plazas Disponibles" required><br><br>
        <input type="text" name="precio" placeholder="Precio" required><br><br>
        <input type="submit" value="Registrar Vuelo">
    </form>
</body>
</html>