// ========== Inicio - Obtiene método de pago de la tarjeta ==========
// ===================================================================
function guessPaymentMethod(setCardNumber = null) {
    if (setCardNumber != null){
        let cardnumber = setCardNumber;

        if (cardnumber.length >= 6) {
            let bin = cardnumber.substring(0, 6);
            window.Mercadopago.getPaymentMethod({
                "bin": bin
            }, setPaymentMethod);

        }

    }

};

function setPaymentMethod(status, response) {
    if (status == 200) {
        let paymentMethodId = response[0].id;
        let element = document.getElementById('payment_method_id');
        element.value = paymentMethodId;
        // Autocompleta el campo "Cuotas"
        getInstallments();

        // Muestra la imagen de la tarjeta que se este ingresando
        document.querySelector('.img-tarjeta').innerHTML = `<img src="${response[0].thumbnail}" alt="Imagen de tarjeta ${response[0].name}">`

    } else {
        alert(`payment method info error: ${response}`);
    }
}

//Autocompleta el campo "Cuotas"
function getInstallments() {
    window.Mercadopago.getInstallments({
        "payment_method_id": document.getElementById('payment_method_id').value,
        "amount": parseFloat(document.getElementById('transaction_amount').value)

    }, function (status, response) {
        if (status == 200) {
            document.getElementById('installments').options.length = 0;
            response[0].payer_costs.forEach(installment => {
                let opt = document.createElement('option');
                opt.text = installment.recommended_message;
                opt.value = installment.installments;
                document.getElementById('installments').appendChild(opt);
            });
        } else {
            alert(`installments method info error: ${response}`);
        }
    });
}



// ================ Inicio -  Crea el token de la tarjeta =============
// ====================================================================
function doPay(event) {
    event.preventDefault();
    if (!doSubmit) {
        var $form = document.querySelector('#pay');

        console.log($form);

        window.Mercadopago.createToken($form, sdkResponseHandler);

        return false;
    }
};

function sdkResponseHandler(status, response) {

    if (status != 200 && status != 201) {
        alert("verify filled data");
    } else {
        var form = document.querySelector('#pay');
        var card = document.createElement('input');
        card.setAttribute('name', 'token');
        card.setAttribute('type', 'hidden');
        card.setAttribute('value', response.id);
        console.log(card);
        form.appendChild(card);
        doSubmit = true;
        form.submit();
    }
};