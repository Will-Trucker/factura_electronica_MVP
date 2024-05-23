
let wrapper = document.querySelector('.wrapper'),
    signUpLink = document.querySelector('.link .signup-link'),
    signInLink = document.querySelector('.link .signin-link');

signUpLink.addEventListener('click', () => {
    wrapper.classList.add('animated-signin');
    wrapper.classList.remove('animated-signup');
});

signInLink.addEventListener('click', () => {
    wrapper.classList.add('animated-signup');
    wrapper.classList.remove('animated-signin');
});


//datos de los detalles de factura
let datos = [];


window.addEventListener("load", function (event) {
    console.log("'Todos los recursos terminaron de cargar!");
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
        secciones.children[i].className = 'd-none'
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


function traerEmisor(){
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let emisor = document.getElementById('emisor').value;
    const apiUrl = 'buscaremisor/' + emisor;

    fetch(apiUrl,{
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": token,
        },
        method: 'POST',
        
    })
    .then(response => {
        return response.text();
    })
    .then(text => {
        console.log("respuesta")
        ponerdatosEmisor(JSON.parse(text))
        //return console.log(text);
    })
    .catch(function(error){
        error.json().then((error) => { //changed here
            errorCallback(error)
          });
    });
    

}

function ponerdatosEmisor(data){
    const datos = data;
    document.getElementById('emisorNombre').value=datos.nombre;
    document.getElementById('nombreComercial').value=datos.nombrecomercial;
    document.getElementById('emisornrc').value=datos.nrc;
    document.getElementById('emisornit').value=datos.nit;
    document.getElementById('actividademisor').value=datos.actividad;
    document.getElementById('complemento').value=datos.complemento;
    document.getElementById('emisordepartamento').value=datos.departamento;
    document.getElementById('emisormunicipio').value=datos.municipio;
    document.getElementById('emisortelefono').value=datos.telefono;
    document.getElementById('emisorcorreo').value=datos.correo;
}


function traerReceptor(){
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let receptor = document.getElementById('receptor').value;
    const apiUrl = 'buscareceptor/' + receptor;

    fetch(apiUrl,{
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": token,
        },
        method: 'POST',
        
    })
    .then(response => {
        return response.text();
    })
    .then(text => {
        console.log("respuesta")
        ponerdatosReceptor(JSON.parse(text))
        //return console.log(text);
    })
    .catch(function(error){
        error.json().then((error) => { //changed here
            errorCallback(error)
          });
    });

}

function ponerdatosReceptor(data){
    const datos = data;
    document.getElementById('receptornombre').value=datos.nombre;
    document.getElementById('tipodocumento').value=datos.tipodocumento;
    document.getElementById('receptornrc').value=datos.nrc;
    document.getElementById('receptorcomplemento').value=datos.complemento;
    document.getElementById('receptordepartamento').value=datos.departamento;
    document.getElementById('receptormunicipio').value=datos.municipio;
}


function cambiarTipoDoc(){
    let documento = document.getElementById("tipoDocumento");
    console.log(documento.value);
    document.getElementById('detallesnormal').className = "";

    if (documento.value == "CLE") {
        document.getElementById('liquidacion').className = "";
        document.getElementById('detallesnormal').className = "d-none";
    }else{
        document.getElementById('liquidacion').className = "d-none";
    }

    if (documento.value == "FEXE") {
        document.getElementById('receptorExportacion').className = "";
    }else{
        document.getElementById('receptorExportacion').className = "d-none";
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
    tabla = document.getElementById('tablaDetalles');
    //console.log()
    var nuevaFila = tabla.insertRow(tabla.rows.length);
  
    var cantidadCell = nuevaFila.insertCell(0);
    var cantidadInput = document.createElement('input');
    cantidadInput.setAttribute('type', 'number');
    cantidadInput.setAttribute('class', 'cant');
    cantidadInput.setAttribute('onblur', 'calcularVentas()');
    cantidadInput.setAttribute('value', '0');
    cantidadCell.appendChild(cantidadInput);
    
    var descripcionCell = nuevaFila.insertCell(1);
    var descripcionInput = document.createElement('input');
    descripcionInput.setAttribute('type', 'text');
    descripcionInput.setAttribute('onblur', 'calculoDetalles()');
    descripcionCell.appendChild(descripcionInput);
    
    var precioCell = nuevaFila.insertCell(2);
    var precioInput = document.createElement('input');
    precioInput.setAttribute('type', 'number');
    precioInput.setAttribute('name', 'precio');
    precioInput.setAttribute('class', 'precios');
    precioInput.setAttribute('onblur', 'calcularVentas()');
    precioInput.setAttribute('value', '0');
    precioCell.appendChild(precioInput);
    
    for (var i = 3; i < 6; i++) {
      var cell = nuevaFila.insertCell(i);
      cell.innerHTML = "0.0";
    }
  
}
