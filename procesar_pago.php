<?php
    // echo "<pre>";
    // die(print_r($_POST));

    require_once 'vendor/autoload.php';

    // Enviamos el Access Token
    MercadoPago\SDK::setAccessToken("TEST-5949627638217334-062600-0189291a7f801899e67b1c29272da613-230435511");
    
    $payment = new MercadoPago\Payment();
    $payment->description = $_POST['description'];  // Descripcion del Producto/Servicio
    $payment->transaction_amount = $_POST['transaction_amount']; // Precio del Producto/Servicio
    $payment->installments = $_POST['installments']; // Cantidad de Cuotas del Pago
    $payment->payer = array(
        "email" => $_POST['email']  // Correo Electronico del Cliente
    );
    $payment->payment_method_id = $_POST['payment_method_id'];  // Tipo Tarjeta, ej: Mastercard, Visa, American Express
    $payment->token = $_POST['token']; // Token Creado

    // Envía el pago a Mercado Pago
    $payment->save();

    // Se obtiene el estado del pago
    // echo "<pre>";
    // die(print_r($payment));
    echo $payment->status;
