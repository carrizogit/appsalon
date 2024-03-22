document.addEventListener('DOMContentLoaded', function() {

    iniciarApp();
});

function iniciarApp() {
    buscarporFecha();
}

function buscarporFecha() {
    const fechaInput = document.querySelector('#fecha');
    fechaInput.addEventListener('input', function(e) {

        const fechaSeleccionada = e.target.value;

        console.log(fechaSeleccionada);
        //enviamos fecha a la url
        window.location = `?fecha=${fechaSeleccionada}`;

    });
}

 