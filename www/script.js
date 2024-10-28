function search() {
    const destino = document.getElementById("destination-select").value;
    const travelDate = document.getElementById("travel-date").value;
    const fechaFin = document.getElementById("fechaFin").value;
    const serviceType = document.getElementById("service-type-select").value;
    const duracion = document.getElementById("duracion").value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const resultsContainer = document.getElementById("results-container");

    resultsContainer.innerHTML = '';

    if (destino && travelDate && fechaFin && serviceType && duracion) {
        const url = `/api/filtroViaje.php`;
        const formData = new FormData();
        formData.append("destino", destino);
        formData.append("fechaInicio", travelDate);
        formData.append("fechaFin", fechaFin);
        formData.append("tipoServicio", serviceType);
        formData.append("duracion", duracion);
        formData.append("csrf_token", csrfToken); // Asegúrate de enviar el token

        fetch(url, {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error(data.error); // Mostrar errores de token en la consola
                resultsContainer.innerHTML = `<p>Error: ${data.error}</p>`;
            } else if (data.paquete) {
                const paquete = data.paquete;
                resultsContainer.innerHTML = `
                    <div class="result">
                        <h3>Detalles del paquete:</h3>
                        <p><strong>Destino:</strong> ${paquete.destino}</p>
                        <p><strong>Rango de fechas:</strong> del ${paquete.fechaInicio} al ${paquete.fechaFin}</p>
                        <p><strong>Duración:</strong> ${paquete.duracion} días</p>
                        <p><strong>Precio:</strong> $${paquete.precio}</p>
                        <p><strong>Disponibilidad:</strong> ${paquete.disponibilidad}</p>
                        <button onclick="addToCart(${JSON.stringify(paquete)})">Añadir al Carrito</button>
                    </div>`;
            } else {
                resultsContainer.innerHTML = '<p>No se encontraron paquetes disponibles para los criterios seleccionados.</p>';
            }
        })
        .catch(error => console.error('Error:', error));
    } else {
        resultsContainer.innerHTML = '<p>Por favor completa todos los campos.</p>';
    }
}

function addToCart(paquete) {
    const url = `/api/carrito.php?action=add`;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify(paquete)
    })
    .then(response => response.json())
    .then(data => {
        updateCartDisplay(data.cart);
    })
    .catch(error => console.error('Error:', error));
}

function updateCartDisplay(cart) {
    const cartList = document.getElementById('cart-list');
    cartList.innerHTML = '';
    cart.forEach(item => {
        const li = document.createElement('li');
        li.textContent = `${item.destino} - ${item.precio}`;
        cartList.appendChild(li);
    });
}


function checkout() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/api/carrito.php?action=checkout', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        }
    })
    .then(response => response.json())
    .then(data => {
        alert('Compra finalizada exitosamente');
        updateCartDisplay([]);
    })
    .catch(error => console.error('Error en el checkout:', error));
}


setInterval(() => {
    fetch('/api/keep-alive.php', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        }
    })
    .catch(error => console.error('Error manteniendo la sesión:', error));
}, 5 * 60 * 1000);


function loadDestinationsFromAPI() {
    fetch('/api/destinos.php')
        .then(response => response.json())
        .then(data => {
            const destinations = data.destinations;
            const destinationSelect = document.getElementById("destination-select");

            destinationSelect.innerHTML = '<option value="">Selecciona un destino</option>';

            destinations.forEach(destination => {
                const option = document.createElement("option");
                option.value = destination.name;
                option.textContent = destination.name;
                destinationSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error cargando los destinos:', error));
}

function setMinDate() {
    const dateInput = document.getElementById("travel-date");

    if (dateInput) {
        const today = new Date();
        const year = today.getFullYear();
        const month = (today.getMonth() + 1).toString().padStart(2, '0');
        const day = today.getDate().toString().padStart(2, '0'); 

        dateInput.min = `${year}-${month}-${day}`;
    } else {
        console.error("El campo de fecha no existe en el DOM.");
    }
}

window.onload = function() {
    loadDestinationsFromAPI();
    setMinDate();
};
