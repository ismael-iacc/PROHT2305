function validarHotel() {
    let nombre = document.forms["formHotel"]["nombre"].value;
    let ubicacion = document.forms["formHotel"]["ubicacion"].value;
    let habitaciones = document.forms["formHotel"]["habitaciones_disponibles"].value;
    let tarifa = document.forms["formHotel"]["tarifa_noche"].value;

    if (nombre === "" || ubicacion === "" || habitaciones === "" || tarifa === "") {
        alert("Todos los campos son obligatorios.");
        return false;
    }

    if (isNaN(habitaciones) || habitaciones <= 0) {
        alert("El número de habitaciones debe ser un número mayor que 0.");
        return false;
    }

    if (isNaN(tarifa) || tarifa <= 0) {
        alert("La tarifa debe ser un valor numérico positivo.");
        return false;
    }

    return true;
}
