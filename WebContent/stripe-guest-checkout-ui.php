<?php
require_once('./stripe-config.php');

// this stuff will come in from elsewhere
$totalAmount = 1923;

?>

stripe-guest-ckeckout-ui.php
<br/>

<h1>Stripe R&D - Guest Checkout</h1>

<!-- Custom Button ---------------------------------------------------------------------------------------------------->
<h3>Custom Button</h3>

<script src="https://checkout.stripe.com/checkout.js"></script>

<button id="guestCheckoutButton">Guest Checkout Payment</button>

<form id="processPaymentForm" action="stripe-guest-checkout-api.php" method="POST">
    <input type="hidden" id="tokenId" name="tokenId">
    <input type="hidden" id="totalAmount" name="totalAmount">
</form>

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

        document.getElementById('tokenId').value=token.id;
        document.getElementById('totalAmount').value=<?php echo $totalAmount ?>;
        document.getElementById('processPaymentForm').submit();

    } // processToken()


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

