 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Implementacion - Mercado Pago</title>
 </head>
 <style>
     .d-none {
         display: none;
     }
 </style>

 <body>

     <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>

     <!-- Respetar el el formato HTML del formulario para obtener datos de tarjetas de manera segura -->
     <form action="procesar_pago.php" method="post" id="pay" name="pay">
         <fieldset>
             <p>
                 <label for="description">Descripción</label>
                 <input type="text" name="description" id="description" value="Ítem seleccionado" />
             </p>
             <p>
                 <label for="transaction_amount">Monto a pagar</label>
                 <input name="transaction_amount" id="transaction_amount" value="100" />
             </p>
             <p>
                 <label for="email">Email</label>
                 <input type="email" id="email" name="email" value="" />
             </p>
             <p id="tarjetasGuardadas" class="d-none">
                 <!-- TARJETAS DEL CLIENTE GUARDADAS -->
             </p>
             <p id="codigoTarjeta">
                 <label for="cardNumber">Número de la tarjeta</label>
                 <input type="text" id="cardNumber" data-checkout="cardNumber" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off placeholder="5031755734530604" />
                 <button id="viewListCard">Tarjetas Guardadas</button>
                 <div class="img-tarjeta"></div>
             </p>
             <p>
                 <label for="cardholderName">Nombre y apellido</label>
                 <input type="text" id="cardholderName" data-checkout="cardholderName" placeholder="APRO" />
             </p>
             <p>
                 <label for="cardExpirationMonth">Mes de vencimiento</label>
                 <input type="text" id="cardExpirationMonth" data-checkout="cardExpirationMonth" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off placeholder="11" />
             </p>
             <p>
                 <label for="cardExpirationYear">Año de vencimiento</label>
                 <input type="text" id="cardExpirationYear" data-checkout="cardExpirationYear" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off placeholder="25" />
             </p>
             <p>
                 <label for="securityCode">Código de seguridad</label>
                 <input type="text" id="securityCode" data-checkout="securityCode" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off placeholder="123" />
             </p>
             <p>
                 <label for="installments">Cuotas</label>
                 <select id="installments" class="form-control" name="installments">
                     <option value="">-- Cargar Nro de Tarjeta --</option>
                 </select>
             </p>
             <p>
                 <label for="docType">Tipo de documento</label>
                 <select id="docType" data-checkout="docType"></select>
             </p>
             <p>
                 <label for="docNumber">Número de documento</label>
                 <input type="text" id="docNumber" data-checkout="docNumber" />
             </p>

             <input type="hidden" name="payment_method_id" id="payment_method_id" />
             <input type="submit" value="Pagar" />
         </fieldset>
     </form>

 </body>
 <!-- Importamos el SDK.js de Mercado Pago para la seguridad de los datos de tarjetas -->
 <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
 <script src="js/funciones_mercadopago.js"></script>
 <script src="js/main.js"></script>
 <script>
     getCards();

     // Enviamos la Public Key
     window.Mercadopago.setPublishableKey("TEST-c4c7b2fb-66a4-48ee-ba2e-e9e273a0bcb7");
     // Autocompleta el campo "Tipo de documento"
     window.Mercadopago.getIdentificationTypes();

     // Muestra tarjetas del cliente al ingresa el correo electronico
     document.getElementById('email').addEventListener('blur', getCards);

     // Verificamos si existe el elemento HTML antes de asignarle una funcion a su evento
     if (document.getElementById('viewListCard')) {
         // Agregamos funcion al evento "click" del botón "Nueva Tarjeta +"
         document.getElementById('viewListCard').addEventListener("click", getCards);
     }

     // Crea el token de la tarjeta
     // IMPORTANTE: El token tiene una validez de 7 días y solo se pueda usar una vez.
     doSubmit = false;
     document.querySelector('#pay').addEventListener('submit', doPay);
 </script>

 </html>