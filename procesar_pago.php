<?php
// echo "<pre>";
// die(print_r($_POST));


    // Credenciales de Prueba

    define("SAND_KEY", "TEST-c4c7b2fb-66a4-48ee-ba2e-e9e273a0bcb7");
    define("SAND_TOKEN", "TEST-2508592269752410-070600-a04d2d96ec9836e08c1c96cbb1d27ef4-604099663");
    // Credenciales de Producción
    define("PROD_KEY", "APP_USR-772b243a-a9cc-4878-bb30-88d9cd7193c5");
    define("PROD_TOKEN", "APP_USR-2508592269752410-070600-0e58c982c248ac483e4924ae18014467-604099663");



    require_once 'vendor/autoload.php';

    // Enviamos el Access Token
    MercadoPago\SDK::setAccessToken("TEST-2508592269752410-070600-a04d2d96ec9836e08c1c96cbb1d27ef4-604099663");

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

    // Envía y verifica que el pago se efectue
    if($payment->save()){
        
        if (isset($customer[0])) {// Si existe el cliente, tomamos el ID

            $customer_id = $customer[0]->id; // Guardamos el ID 
        
        } else { // Si no existe el cliente, se crea uno
            
            $customer = new MercadoPago\Customer(); // Instanciamos la clase de Clientes
            $customer->email = $email;              // Agregamos como atributo el Correo
            $customer->save();                      // Guardamos el Cliente
            $customer_id = $customer->id;           // Guardamos el ID 

        }

        // $customer = MercadoPago\Customer::find_by_id($customer_id);
        // $cards = $customer->cards;

        // Almacenamos los datos de la tarjeta y lo asignamos al cliente
        $card = new MercadoPago\Card();             // Instanciamos la clase de Tarjetas
        $card->token = $token;                      // Agregamos como atributo el Token generado de la Tarjeta
        $card->customer_id = $customer_id;          // Agregamos como atributo el ID del Cliente en la Tarjeta
        $card->save();                              // Guardamos la tarjeta

        echo "<pre>";
        die(print_r($card));
    }
    else{
        echo "NO SE PUDO REALIZAR EL PAGO";
    }

    // Se obtiene el estado del pago
    // echo "<pre>";
    //     print_r($payment);
    // echo "</pre>";  
    // echo $payment->status;
