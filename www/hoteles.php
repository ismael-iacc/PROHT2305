<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Hotel</title>
    <link rel="stylesheet" href="styles.css">
    <script src="js/hoteles.js"></script>
</head>
<body>
    <form name="formHotel" action="/api/hoteles.php" method="post" onsubmit="return validarHotel();">
        <input type="text" name="nombre" placeholder="Nombre del Hotel" required><br><br>
        <input type="text" name="ubicacion" placeholder="Ubicación" required><br><br>
        <input type="number" name="habitaciones_disponibles" placeholder="Habitaciones Disponibles" required><br><br>
        <input type="text" name="tarifa_noche" placeholder="Tarifa por Noche" required><br><br>
        <input type="submit" value="Registrar Hotel">
    </form>
</body>
</html>
