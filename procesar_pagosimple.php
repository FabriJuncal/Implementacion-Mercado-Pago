<?php
// echo "<pre>";
// die(print_r($_POST));

require_once 'vendor/autoload.php';

// Enviamos el Access Token
MercadoPago\SDK::setAccessToken("TEST-3566230077754908-071823-49c8f8f8a6317745a07c283bf999e56a-611853972");

// FILTRA Y OBTIENE LOS DATOS POR POST

// Descripcion del Producto/Servicio
$description = filter_input(INPUT_POST, 'description', FILTER_DEFAULT);
// Precio del Producto/Servicio
$transaction_amount = filter_input(INPUT_POST, 'transaction_amount', FILTER_DEFAULT);
// Cantidad de Cuotas del Pago
$installments = filter_input(INPUT_POST, 'installments', FILTER_DEFAULT);
// Correo Electronico del Cliente
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
// Tipo Tarjeta, ej: Mastercard, Visa, American Express
$payment_method_id = filter_input(INPUT_POST, 'payment_method_id', FILTER_DEFAULT);
// Token Creado
$token = filter_input(INPUT_POST, 'token', FILTER_DEFAULT);

// Se arma el filtro por correo electronico
$filters = array(
    "email" => $email
);

// Buscamos al cliente por su correo electronico
$customer = MercadoPago\Customer::search($filters);

// SE REALIZA EL PAGO
$payment = new MercadoPago\Payment();
$payment->description = $description;
$payment->transaction_amount = $transaction_amount;
$payment->installments = $installments;
$payment->payer = array(
    "email" => $email
);
$payment->payment_method_id = $payment_method_id;
$payment->token = $token;
$payment->save();


// Se obtiene el estado del pago
echo "<pre>";
    print_r($payment);