document.addEventListener('DOMContentLoaded', () => {
    iniciarApp()
})

let paso = 1

const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

function iniciarApp() {
    tabs()
    mostrarSeccion()
    paginador()
    opacador()
    consultarAPI()
    mostrarNombreId()
    seleccionarFecha()
    seleccionarHora()
    mostrarResumen()
}

function alerta(tipo, mensaje, elemento, hide = true) {
    const selector = document.querySelector(elemento)
    
    const alertaExiste = document.querySelector('.alerta')
    if (alertaExiste) {
        alertaExiste.remove()
    }
    
    const alerta = document.createElement('DIV')
    alerta.classList.add('alerta', `${tipo}`)
    alerta.textContent = `${mensaje}`
    selector.appendChild(alerta)
    if (hide) {
        setTimeout(() => {
            alerta.remove()
        }, 3000); 
    }
}

function tabs() {
    const tabs = document.querySelectorAll('.tabs button')
    
    tabs.forEach(tab => {tab.addEventListener('click', e => {
        paso = parseInt(e.target.dataset.paso)
        mostrarSeccion()
        opacador()
        if (paso === 3) {
            mostrarResumen()
        }
    })})    
}

function mostrarSeccion() {
    const seccionActual = document.querySelector('.mostrar')
    if (seccionActual) {
        seccionActual.classList.remove('mostrar')
    }

    const seccion = document.querySelector(`#paso-${paso}`)
    seccion.classList.add('mostrar')

    const botonActual = document.querySelector('.actual')
    if (botonActual) {
        botonActual.classList.remove('actual')
    }
    
    const boton = document.querySelector(`[data-paso='${paso}'`)
    boton.classList.add('actual')
}

function paginador() {
    const anterior = document.querySelector('#anterior')
    const siguiente = document.querySelector('#siguiente')

    siguiente.addEventListener('click', () => {
        if (paso < 3) {
            paso++;
            mostrarSeccion()
            opacador()
            mostrarResumen()
        }
    })
    anterior.addEventListener('click', () => {
        if (paso > 1) {
            paso--;
            mostrarSeccion()
            opacador()
        }
    })
}

function opacador(){
    const anterior = document.querySelector('#anterior')
    const siguiente = document.querySelector('#siguiente')

    if (paso === 1) {
        anterior.classList.add('opacar')
        siguiente.classList.remove('opacar')
    }else if (paso === 3) {
        siguiente.classList.add('opacar')
        anterior.classList.remove('opacar')
    }else{
        siguiente.classList.remove('opacar')
        anterior.classList.remove('opacar')
    }
}

async function consultarAPI() {
    try {
        const url = '/api/servicios'
        const resultado = await fetch(url)
        const servicios = await resultado.json()
        mostrarServicios(servicios)
    } catch (error) {
        console.log(error)
    }
}

function mostrarServicios(servicios) {
    servicios.forEach(servicio => {
        const {id, nombre, precio} = servicio

        const nombreServicio = document.createElement('P')
        nombreServicio.classList.add('nombre-servicio')
        nombreServicio.textContent = nombre

        const precioServicio = document.createElement('P')
        precioServicio.classList.add('precio-servicio')
        precioServicio.textContent = `€ ${precio}`

        const servicioDIV = document.createElement('DIV')
        servicioDIV.appendChild(nombreServicio)
        servicioDIV.appendChild(precioServicio)
        servicioDIV.classList.add('servicio')
        servicioDIV.dataset.idServicio = id
        servicioDIV.onclick = () => {
            seleccionarServicio(servicio)
        }
        
        document.querySelector('#servicios').appendChild(servicioDIV)
    });
}

function seleccionarServicio(servicio) {
    const {id} = servicio
    const {servicios} = cita
    const divServicio = document.querySelector(`[data-id-servicio="${servicio.id}"]`)
    
    if (servicios.some(added => added.id === id)) {
        cita.servicios = servicios.filter(added => added.id !==id)
        divServicio.classList.remove('opacar')
    } else {
        cita.servicios = [...servicios, servicio]
        divServicio.classList.add('opacar')
    }
}

function mostrarNombreId() {
    cita.nombre = document.querySelector('#nombre').value
    // Se esta pasando el id del cliente
    cita.id = document.querySelector('#nombre').dataset.id
}

function seleccionarFecha() {
    const fecha = document.querySelector('#fecha')
    fecha.addEventListener('input', e => {
        const dia = new Date(e.target.value).getDay()
        if ([0, 6].includes(dia)) {
            e.target.value = ''
            alerta('error', 'Sabado y Domingo no se agendan citas', '#paso-2')
        } else {
            cita.fecha = e.target.value
        }
    })
}

function seleccionarHora() {
    const fecha = document.querySelector('#hora')
    fecha.addEventListener('input', e => {
        const horaCita = e.target.value
        const hora = horaCita.split(':')[0]
        if (hora < 19 && hora > 9) {
            cita.hora = e.target.value
        }else{
            e.target.value = ''
            alerta('error', 'Selecciona la hora correcta 10:00am-18:00pm', '#paso-2')
        }
    })
}

function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen')
    const {nombre, fecha, hora, servicios} = cita
    
    while (resumen.firstChild) {
        resumen.removeChild(resumen.firstChild)
    }
    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        alerta('error', 'Completar todos los campos previos', '.contenido-resumen', false)
        return
    }
    
    const headingServicios = document.createElement('H3')
    headingServicios.textContent = 'Resumen de Servicios'
    resumen.appendChild(headingServicios)

    let total = 0
    servicios.forEach(servicio => {
        const {id, nombre, precio} = servicio
        const serviciosCitas = document.createElement('DIV')
        serviciosCitas.classList.add('contenido-servicio')
        
        const nombreServicio = document.createElement('P')
        nombreServicio.textContent = nombre
        serviciosCitas.appendChild(nombreServicio)
        
        const precioServicio = document.createElement('P')
        precioServicio.innerHTML = `<span>Precio:</span> € ${precio}`
        serviciosCitas.appendChild(precioServicio)   
               
        total += Number(precio)
        resumen.appendChild(serviciosCitas)
    });
    const precioTotal = document.createElement('P')
    precioTotal.innerHTML = `<span>Precio Total:</span> € ${total}`
    
    
    const resumenCita = document.createElement('DIV')
    
    const headingCita = document.createElement('H3')
    headingCita.textContent = 'Resumen de Cita'
    resumenCita.appendChild(headingCita)
    
    const nombreCita = document.createElement('P')
    nombreCita.innerHTML = `<span>Nombre:</span> ${nombre}`
    resumenCita.appendChild(nombreCita)
    
    const fechaCita = document.createElement('P')

    const opcionesFecha = {year: 'numeric', month: 'long', day: 'numeric', weekday: 'long'}
    const fechaFormateada = new Date(fecha).toLocaleDateString('es-ES', opcionesFecha)
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`
    resumenCita.appendChild(fechaCita)
    
    const horaCita = document.createElement('P')
    horaCita.innerHTML = `<span>Hora:</span> ${hora}`
    resumenCita.appendChild(horaCita)

    const botonCita = document.createElement('BUTTON')
    botonCita.classList.add('boton2')
    botonCita.textContent = 'Enviar Cita'
    botonCita.onclick = reservarCita
    
    
    resumen.appendChild(resumenCita)
    resumen.appendChild(precioTotal)
    resumen.appendChild(botonCita)
}

async function reservarCita() {
    const {id, fecha, hora, servicios} = cita
    const serviciosId = servicios.map(servicio => servicio.id)
    const datos = new FormData()
    datos.append('usuarioId', id)
    datos.append('fecha', fecha)
    datos.append('hora', hora)
    datos.append('servicio', serviciosId)

    try {
        const url = '/api/citas'
        const respuesta = await fetch(url, { method: 'POST', body: datos})
    
        const resultado = await respuesta.json()
        if (resultado.resultado) {
            Swal.fire({
                title: "Cita creada con exito!",
                text: "Volviendo a pagina principal",
                icon: "success",
              }).then(() => {window.location.reload()})
        }
        
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Algo salio mal!",
          }).then(() => {
            setTimeout(() => {
                window.location.reload()
            }, 2000);
        })
    }


}