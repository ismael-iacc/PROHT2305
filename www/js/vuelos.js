function validarVuelo() {
    let origen = document.forms["formVuelo"]["origen"].value;
    let destino = document.forms["formVuelo"]["destino"].value;
    let plazas = document.forms["formVuelo"]["plazas_disponibles"].value;
    let precio = document.forms["formVuelo"]["precio"].value;

    if (origen === "" || destino === "" || plazas === "" || precio === "") {
        alert("Todos los campos son obligatorios.");
        return false;
    }

    if (isNaN(plazas) || plazas <= 0) {
        alert("El número de plazas debe ser un número mayor que 0.");
        return false;
    }

    if (isNaN(precio) || precio <= 0) {
        alert("El precio debe ser un valor numérico positivo.");
        return false;
    }

    return true;
}