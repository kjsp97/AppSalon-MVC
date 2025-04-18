document.addEventListener('DOMContentLoaded', () => {
    iniciarApp()
})

function iniciarApp() {
    buscadorPorFecha()
}

function buscadorPorFecha() {
    const fecha = document.querySelector('#fecha')
    fecha.addEventListener('input', e => {
        const fechaSeleccionada = e.target.value
        window.location = `admin?fecha=${fechaSeleccionada}`
    })
}