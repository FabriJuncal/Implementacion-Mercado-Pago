// Agrega campo para ingresar codigo de Nueva Tarjeta
function newCard(event) {

    event.preventDefault();

    // Ocultamos el campo "Metodo de Pago"
    document.querySelector("#tarjetasGuardadas").classList.add("d-none");
    // Eliminamos el contenido HTML
    document.querySelector("#tarjetasGuardadas").innerHTML = "";
    // Oculta la imagen de la tarjeta si no se tienen la cantidad de codigos de la tarjeta necesarias
    document.querySelector('.img-tarjeta').innerHTML = "";
    // Eliminamos la clase que esta ocultando el campo "Número de la tarjeta"
    document.querySelector("#codigoTarjeta").classList.remove("d-none");
    // Agregamos funcion al evento "click" del botón "Nueva Tarjeta +"
    document.getElementById('viewListCard').addEventListener("click", getCards);

    document.getElementById('installments').innerHTML = "";
    document.getElementById('installments').innerHTML = '<select id="installments" class="form-control" name="installments">-- Cargar Nro de Tarjeta --</select>';
    
}


// Funcion Asincrona: 
// Detecta y Muestra las Tarjetas que tenga guardada el cliente
async function getCards(event = null ) {

    // Detectamos si la funcion se ejecuta por medio de un evento
    if (event) {
        // Verificamos que se ejecute mediante el evento "Click"
        if (event.type === "click"){
            // Quitamos la función por defecto del Evento
            event.preventDefault();
        }
    }
    
    // Se crea el FormData, para formatatear los datos y que el Fetch los acepte y envie de manera correcta
    let formData = new FormData();
    formData.append('email', document.querySelector("#email").value)

    // Peticion Fetch
    await fetch("tarjetas_recordadas.php", {
        // Pasamos el Metodo con el que queremos enviar los datos
        method: "POST",
        // Enviamos la informacion del FormData()
        body: formData
    })
        // Transformamos la respuesta en formato TEXT
        //  await Hasta que la peticion no obtenga una respuesta, no se ejecuta la siguiente linea de codigo
        .then( async response => await response.text())
        // Se obtiene como respuesta codigo HTML en formato de Texto
        .then((HTML) => {

            // Inyectamos el HTML que se obtuvo de la petición
            document.querySelector("#tarjetasGuardadas").innerHTML = HTML;

            // Verificamos que exista el nodo del DOM
            if (document.querySelector("#cardId option")) {
                // Verificamos que el elemento "SELECT" del HTML contenga registros
                if (document.querySelector("#cardId option").value) {
                    // Se toma los datos del campo "Metodo de Pago"
                    let codCard = document.querySelector('#cardId > option').attributes[1].value;
                    // Se envia el codigo de la tarjeta para obtener las cuotas en los que se puede realizar el pago
                    guessPaymentMethod(codCard);
                    // En el caso de que exista registros en el "SELECT":

                    // *Eliminamos la clase que esta ocultando el campo "Metodo de Pago"
                    document.querySelector("#tarjetasGuardadas").classList.remove("d-none");

                    // * Agregamos funcion al evento "click" del botón "Nueva Tarjeta +"
                    document.getElementById('newCard').addEventListener("click", newCard);

                    // *Ocultamos el campo "Número de la tarjeta"
                    document.querySelector("#codigoTarjeta").classList.add("d-none");

                    
                } else {
                    // console.log("ENTRO EN ELSE")
                    // En el caso que NO exista registros en el "SELECT":
                    
                    // *Ocultamos el campo "Metodo de Pago"
                    document.querySelector("#tarjetasGuardadas").classList.add("d-none");

                    // *Eliminamos la clase que esta ocultando el campo "Número de la tarjeta"
                    document.querySelector("#codigoTarjeta").classList.remove("d-none");
                    
                // Se carga las funciones de los Eventos:

                    document.getElementById('cardNumber').addEventListener('keyup', ()=>{
                        // En el caso que NO exista registros en el "SELECT":
                        if (!document.querySelector("#cardId option").value){

                            // Se toma los datos del campo "Número de la tarjeta"
                            let codCard = document.getElementById('cardNumber').value;
                            // Se envia el codigo de la tarjeta para obtener las cuotas en los que se puede realizar el pago
                            guessPaymentMethod(codCard);
                        }
                        
                    }, false);

                    document.getElementById('cardNumber').addEventListener('change', () => {
                        // En el caso que NO exista registros en el "SELECT":
                        if (!document.querySelector("#cardId option").value) {

                            // Se toma los datos del campo "Número de la tarjeta"
                            let codCard = document.getElementById('cardNumber').value;
                            // Se envia el codigo de la tarjeta para obtener las cuotas en los que se puede realizar el pago
                            guessPaymentMethod(codCard);
                        }

                    }, false);

                    // Detectamos si la funcion se ejecuta por medio de un evento
                    if (event) {
                        // Verificamos que se ejecute mediante el evento "Click"
                        if (event.type === "click") {
                            // Mostramos un mensaje en el caso que el cliente no tenga tarjetas guardadas
                            alert("El usuario no contiene tarjetas guardadas");
                        }
                    }
                    // Eliminamos la imagen de tipo de tarjeta y las cuotas de forma de pago que contiene
                    deletDataCard();
                }

            }
        })
}

// Elimina la imagen de tipo de tarjeta y las cuotas de forma de pago que contiene
function deletDataCard(){
    // Elimina la imagen de la tarjeta  si no se encuentra tarjeta
    document.querySelector('.img-tarjeta').innerHTML = "";
    // Elimina la forma de pago en cuotas si no se encuentra tarjeta
    document.getElementById('installments').innerHTML = "";
    document.getElementById('installments').innerHTML = '<select id="installments" class="form-control" name="installments">' +
                                                            '<option value = ""> --Cargar Nro de Tarjeta-- </option>' +
                                                        '</select >';
}


