<?php

require_once 'vendor/autoload.php';

// Enviamos el Access Token
MercadoPago\SDK::setAccessToken("TEST-2508592269752410-070600-a04d2d96ec9836e08c1c96cbb1d27ef4-604099663");


// FILTRA Y OBTIENE LOS DATOS POR POST
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

// Se arma el filtro por correo electronico
$filters = array(
    "email" => $email
);

// Buscamos al cliente por su correo electronico
$customer = MercadoPago\Customer::search($filters);

if (isset($customer[0])) { // Si existe el cliente, tomamos el ID

    // Se filtra por el ID del Cliente y se Obtiene los datos de las tarjetas a su nombre
    $customer = MercadoPago\Customer::find_by_id($customer[0]->id);
    $cards = $customer->cards;

    // echo "<pre>";
    // die(print_r($cards));
}
?>

<label>Metodo de Pago:</label>
<select id="cardId" name="cardId" data-checkout='cardId'>
        <option value="<?=$cards[0]->id?>" first_six_digits="<?=$cards[0]->first_six_digits?>" security_code_length="<?=$cards[0]->security_code->length?>">
            <?=$cards[0]->payment_method->name?> termina en: <?=$cards[0]->last_four_digits?>
        </option>
</select>