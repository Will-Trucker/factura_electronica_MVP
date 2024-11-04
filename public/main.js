
//datos de los detalles de factura
let datos = [];
window.addEventListener("load", function (event) {
    console.log("Todos los recursos terminaron de cargar!");
    const pagina = location.href;
    const menu = document.getElementById('listamenu');
    if (menu != null) {

        for (let i = 0; i < menu.childElementCount; i++) {

            if(menu.children[i].children[0].href == pagina){
                var pagActual = menu.children[i].children[0];
                console.log(pagActual.href)
                pagActual.className = "nav-link text-white pgActual"

            }

        }
    }
  });

function cambiarSeccion(seccion){
    let section;
    let secciones = document.getElementById("divisiones")
    for (let i = 0; i < secciones.childElementCount; i++) {
        secciones.children[i].className = 'hidden'
    }
    switch (seccion) {
        case 0:
            section = document.getElementById("tipodocsection");
            document.getElementById('token-button').className = "boton ms-3 btn btn-primary"
            break;
        case 1:
            section = document.getElementById("tokenSection");
            document.getElementById('token-button').className = "boton ms-3 btn btn-primary"
            break;
        case 2:
            section = document.getElementById("emisorSection");
            document.getElementById('emisor-button').className = "boton ms-3 btn btn-primary"
            break;
        case 3:
            section = document.getElementById("receptorSection");
            document.getElementById('receptor-button').className = "boton ms-3 btn btn-primary"
            break;
        case 4:
            section = document.getElementById("descripcionSection");
            document.getElementById('description-button').className = "boton ms-3 btn btn-primary"
            break;
        case 5:
            section = document.getElementById("enviarSection");
            document.getElementById('enviar-button').className = "boton ms-3 btn btn-primary"
            break;
        default:
            break;
    }

    section.className = '';

}

function calcularVentas(){
    let tabla = document.getElementById("tablaDetalles");

    for (let i = 0; i < tabla.childElementCount; i++) {
        let fila = tabla.children[i];
        //casilla de ventas = cantidad * precio unitario
        fila.children[5].textContent = fila.children[0].children[0].value*fila.children[2].children[0].value
    }
    calculoDetalles();
}


function traerEmisor() {
    let emisorId = document.getElementById('emisor').value;
    const apiUrl = `/api/emisor/${emisorId}`;

    fetch(apiUrl, {
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
        },
        method: 'GET',
    })
    .then(response => response.json())
    .then(data => {
        ponerdatosEmisor(data);
    })
    .catch(error => {
        console.error('Error fetching emisor:', error);
    });
    // let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    // let emisorId = document.getElementById('emisor').value; // Asumiendo que tienes un elemento con id 'emisor'

    // fetch(`/emisores/${emisorId}`, { // La ruta debe coincidir con la que defines en Laravel
    //     headers: {
    //         "Content-Type": "application/json",
    //         "Accept": "application/json",
    //         "X-Requested-With": "XMLHttpRequest",
    //         "X-CSRF-Token": token,
    //     },
    //     method: 'GET', // Si es solo para obtener datos, usa 'GET'
    // })
    // .then(response => {
    //     if (!response.ok) {
    //         throw new Error('Network response was not ok');
    //     }
    //     return response.json();
    // })
    // .then(data => {
    //     console.log("respuesta", data);
    //     ponerdatosEmisor(data);
    // })
    // .catch(error => {
    //     console.error('Hubo un problema con la petición Fetch:', error);
    // });
}

// function ponerdatosEmisor(data){
//     document.getElementById('emisorNombre').value = data['Nombre'] || '';
//     document.getElementById('nombreComercial').value = data['Nombre Comercial'] || '';
//     document.getElementById('emisornrc').value = data['NRC'] || '';
//     document.getElementById('emisornit').value = data['NIT'] || '';
//     document.getElementById('actividademisor').value = data['Actividad Economica'] || '';
//     document.getElementById('complemento').value = data['Complemento'] || '';
//     document.getElementById('emisordepartamento').value = data['Departamento'] || '';
//     document.getElementById('emisormunicipio').value = data['Municipio'] || '';
//     document.getElementById('emisortelefono').value = data['Telefono'] || '';
//     document.getElementById('emisorcorreo').value = data['Correo'] || '';
// }

function ponerdatosEmisor(data) {
    document.getElementById('emisorNombre').value = data.Nombre || '';
    document.getElementById('nombreComercial').value = data.NombreComercial || '';
    document.getElementById('emisornrc').value = data.NRC || '';
    document.getElementById('emisornit').value = data.NIT || '';
    document.getElementById('actividademisor').value = data.idActividadEconomica;
    document.getElementById('complemento').value = data.Complemento || '';
    document.getElementById('emisordepartamento').value = data.departamento ? data.departamento.codigoDepartamento : '';
    document.getElementById('emisormunicipio').value = data.idMunicipio;
    document.getElementById('emisortelefono').value = data.Telefono || '';
    document.getElementById('emisorcorreo').value = data.Correo || '';
}

function traerReceptor() {
    let receptorId = document.getElementById('receptor').value;
    const apiUrl = `/api/receptor/${receptorId}`;

    fetch(apiUrl, {
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
        },
        method: 'GET',
    })
    .then(response => response.json())
    .then(data => {
        ponerdatosReceptor(data);
    })
    .catch(error => {
        console.error('Error fetching receptor:', error);
    });
}

function ponerdatosReceptor(data) {
    document.getElementById('receptornombre').value = data.Nombre || '';
    document.getElementById('receptorcorreo').value = data.Correo || '';
    document.getElementById('receptorndocumento').value = data.NumDocumento || '';
    document.getElementById('receptornrc').value = data.NRC || '';
    document.getElementById('receptordepartamento').value = data.idDepartamento || '';
    document.getElementById('receptormunicipio').value = data.idMunicipio || '';
    document.getElementById('receptorcomplemento').value = data.Complemento || '';
    document.getElementById('receptortelefono').value = data.Telefono || '';
}


function cambiarTipoDoc(){
    let documento = document.getElementById("tipoDocumento");
    console.log(documento.value);
    document.getElementById('detallesnormal').className = "";

    if (documento.value == "CLE") {
        document.getElementById('liquidacion').className = "";
        document.getElementById('detallesnormal').className = "hidden";
    }else{
        document.getElementById('liquidacion').className = "hidden";
    }

    if (documento.value == "FEXE") {
        document.getElementById('receptorExportacion').className = "";
    }else{
        document.getElementById('receptorExportacion').className = "hidden";
    }

}

function calculoDetalles(){
    let tabla = document.getElementById('tablaDetalles');
    const filas = tabla.childElementCount;

    datos = [];
    for (let i = 0; i < filas; i++) {
        let descripcion = tabla.children[i].children[1].children[0].value;
        if(descripcion != ""){

            let cantidad = tabla.children[i].children[0].children[0].value;
            let preciounitario = tabla.children[i].children[2].children[0].value;
            let ventasexcentas = tabla.children[i].children[3].textContent;
            let ventasnosujetas = tabla.children[i].children[4].textContent;
            let ventasafectas = tabla.children[i].children[5].textContent;
            const registro = {
                'descripcion':descripcion,
                'cantidad':cantidad,
                'preciounitario':preciounitario,
                'ventasexcentas':ventasexcentas,
                'ventasnosujetas':ventasnosujetas,
                'ventasafectas':ventasafectas,
            }

            datos.push(registro);
            console.log(datos);
            calculoTotales();

        }
    }

    document.getElementById('detallesfactura').value = JSON.stringify(datos);
}

function calculoTotales(){
    //calcula los valores de la tabla donde aparecen los totales de iva y de la compra
    console.log("calculando totales")
    let iva = document.getElementById("iva");
    let vExcenta = document.getElementById("vExcenta");
    let vNosujeta = document.getElementById("vNosujeta");
    let vGravada = document.getElementById("vGravada");
    let Vexcenta = document.getElementById("Vexcenta");
    let Vnosujeta = document.getElementById("Vnosujeta");
    //let Vgravada = document.getElementById("Vgravada");
    let letras = document.getElementById("letras");

    let subtotal = document.getElementById("subtotal");
    let subtotal2 = document.getElementById("subtotal2");
    let total = document.getElementById("total");

    console.log('------------------------------------------------');
    let sumaExcenta = 0,sumaNosujeta = 0, sumaAfectas = 0;

    for (let i = 0; i < datos.length; i++) {
        sumaExcenta += parseFloat(datos[i].ventasexcentas);
        sumaNosujeta += parseFloat(datos[i].ventasnosujetas);
        sumaAfectas += parseFloat(datos[i].ventasafectas);
    }

    vExcenta.innerHTML = sumaExcenta;
    vNosujeta.innerHTML = sumaNosujeta;
    vGravada.innerHTML = (sumaAfectas).toFixed(2);

    let tipoDocumento = document.getElementById("tipoDocumento");

    iva.innerHTML = (sumaAfectas * 0.13).toFixed(2);


    Vexcenta.innerHTML = sumaExcenta;
    Vnosujeta.innerHTML = sumaNosujeta;
    subtotal.innerHTML = (parseFloat(iva.innerHTML) + parseFloat(vGravada.innerHTML)).toFixed(2);

    subtotal2.innerHTML = (parseFloat(subtotal.innerHTML) + sumaExcenta + sumaNosujeta).toFixed(2);

    total.innerHTML = parseFloat(subtotal2.innerHTML).toFixed(2);

    let TotalVenta = document.getElementById("TotalVenta");
    if (TotalVenta != null) {
        TotalVenta.value = parseFloat(subtotal2.innerHTML);

    }


    letras.innerHTML = NumeroALetras(parseFloat(subtotal2.innerHTML));
    document.getElementById('totalLetras').value = NumeroALetras(vGravada.innerHTML);

}


function agregarDetalle(){
    // Obtiene la referencia de la tabla donde se insertará la nueva fila
    tabla = document.getElementById('tablaDetalles');

    // Crea una nueva fila al final de la tabla
    var nuevaFila = tabla.insertRow(tabla.rows.length);
    nuevaFila.classList.add('hover:bg-blue-100'); // Aplica estilo de la fila al pasar el cursor

    // Celda para la cantidad
    var cantidadCell = nuevaFila.insertCell(0);
    var cantidadInput = document.createElement('input');
    cantidadInput.setAttribute('type', 'number');
    cantidadInput.setAttribute('class', 'border rounded-md w-full p-1 cant');
    cantidadInput.setAttribute('onblur', 'calcularVentas()');
    cantidadInput.setAttribute('value', '0');
    cantidadInput.setAttribute('min', '0');
    cantidadCell.classList.add('border', 'border-gray-300', 'px-4', 'py-2'); // Estilos de la celda
    cantidadCell.appendChild(cantidadInput);

    // Celda para la descripción
    var descripcionCell = nuevaFila.insertCell(1);
    var descripcionInput = document.createElement('input');
    descripcionInput.setAttribute('type', 'text');
    descripcionInput.setAttribute('onblur', 'calculoDetalles()');
    descripcionInput.setAttribute('class', 'border rounded-md w-full p-1');
    descripcionCell.classList.add('border', 'border-gray-300', 'px-4', 'py-2'); // Estilos de la celda
    descripcionCell.appendChild(descripcionInput);

    // Celda para el precio unitario
    var precioCell = nuevaFila.insertCell(2);
    var precioInput = document.createElement('input');
    precioInput.setAttribute('type', 'number');
    precioInput.setAttribute('name', 'precio');
    precioInput.setAttribute('class', 'border rounded-md w-full p-1 precios');
    precioInput.setAttribute('onblur', 'calcularVentas()');
    precioInput.setAttribute('value', '0');
    precioInput.setAttribute('min', '0');
    precioInput.setAttribute('step', '0.01');
    precioCell.classList.add('border', 'border-gray-300', 'px-4', 'py-2'); // Estilos de la celda
    precioCell.appendChild(precioInput);

    // Celdas adicionales para Ventas No Sujetas, Ventas Exentas, Ventas Afectas
    for (var i = 3; i < 6; i++) {
      var cell = nuevaFila.insertCell(i);
      cell.innerHTML = "0.0";
      cell.classList.add('border', 'border-gray-300', 'px-4', 'py-2'); // Estilos de la celda
    }
}

