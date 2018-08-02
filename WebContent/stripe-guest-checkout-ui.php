<?php
require_once('./stripe-config.php');

// this stuff will come in from elsewhere
$totalAmount = 1923;

echo basename(__FILE__);

?>
<head>
    <link rel="stylesheet" href="stripe.css">
</head>

<script>
    function logTokenDetails(token) {
        for (var key in token) {
            if (token.hasOwnProperty(key)) {
                console.log("token." + key + " -> " + token[key] + "\n");
                if (key === "card") {
                    for (var cardKey in token.card) {
                        console.log("token.card." + cardKey + " -> " + token.card[cardKey] + "\n");
                        if (cardKey === "metadata") {
                            for (var metaKey in token.card.metadata) {
                                console.log("token.card.metadata." + metaKey + " -> " + token.card.metadata[metaKey] + "\n");
                            }
                        }
                    }
                }
            }
        }
    } // logTokenDetails()


    function processToken(token) {

        logTokenDetails(token);

        document.getElementById('tokenId').value = token.id;
        document.getElementById('totalAmount').value =<?php echo $totalAmount ?>;
        document.getElementById('processPaymentForm').submit();

    } // processToken()

</script>

<br/>

<h1>Stripe R&D: Guest Checkout</h1>

<hr>
<h2>Stripe Elements</h2>

<script src="https://js.stripe.com/v3/"></script>

<form action="/charge" method="post" id="payment-form">
    <table width="500">
        <tr>
            <td>

                <div class="form-row">
                    <label for="card-element">
                        Credit or debit card
                    </label>
                    <br>
                    <div id="card-element" class="StripeElement">
                        <!-- A Stripe Element will be inserted here. -->
                    </div>

                    <!-- Used to display form errors. -->
                    <div id="card-errors" role="alert"></div>
                </div>

                <br>
                <button class="StripeElement">Submit Payment</button>

            </td>
        </tr>
    </table>
</form>


<script>
    // Create a Stripe client.
    var stripe = Stripe('pk_test_fXV7CvLKY2vmEkalqQezZUPc');

    // Create an instance of Elements.
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
        base: {
            //color: '#32325d',
            color: '#32325d',
            lineHeight: '18px',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                //color: '#aab7c4'
                color: '#6665c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    // Create an instance of the card Element.
    var card = elements.create('card', {style: style});

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

    // Handle real-time validation errors from the card Element.
    card.addEventListener('change', function (event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Handle form submission.
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        stripe.createToken(card).then(function (result) {
            if (result.error) {
                // Inform the user if there was an error.
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                // Send the token to your server.
                processToken(result.token);
            }
        });
    });
</script>

<hr>

<!-- Custom Button ---------------------------------------------------------------------------------------------------->
<h3>Custom Button</h3>

<script src="https://checkout.stripe.com/checkout.js"></script>

<button id="guestCheckoutButton">Guest Checkout Payment</button>

<form id="processPaymentForm" action="stripe-guest-checkout-server.php" method="POST">
    <input type="hidden" id="tokenId" name="tokenId">
    <input type="hidden" id="totalAmount" name="totalAmount">
</form>

<script>

    var handler = StripeCheckout.configure({
        key: '<?php echo $stripe['publishable_key']; ?>'
    });

    document.getElementById('guestCheckoutButton').addEventListener('click', function (e) {
        // Open Checkout with further options:
        handler.open({
            name: 'Jansal Valley',
            description: 'Website Order Guest Checkout',
            zipCode: true,
            billingAddress: true,
            amount: <?php echo $totalAmount ?>,
            image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
            locale: 'auto',
            allowRememberMe: false,
            token: function (token) {
                // You can access the token ID with `token.id`.
                // Get the token ID to your server-side code for use.
                processToken(token);
            }
        });
        e.preventDefault();
    });

    // Close Checkout on page navigation:
    window.addEventListener('popstate', function () {
        handler.close();
    });
</script>

<br>
<br>

