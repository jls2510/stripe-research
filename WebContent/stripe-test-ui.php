<?php
require_once('./stripe-config.php');
?>

stripe-test-ui.php
<br/>

<h1>Stripe R&D</h1>

<!-- Payment ---------------------------------------------------------------------------------------------------------->
<hr>
<h2>Payment Pop-Ups</h2>

<!-- Simple Button ---------------------------------------------------------------------------------------------------->
<h3>Simple Button</h3>

<form action="stripe-test-api.php" method="POST">
    <script src="https://checkout.stripe.com/checkout.js"
            class="stripe-button" data-key="<?php echo $stripe['publishable_key']; ?>"
            data-amount="999"
            data-name="Jansal Valley Website"
            data-description="Test Charge"
            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
            data-locale="auto" data-zip-code="true">
    </script>
</form>

<!-- Custom Button ---------------------------------------------------------------------------------------------------->
<h3>Custom Button</h3>

<script src="https://checkout.stripe.com/checkout.js"></script>

<button id="customButton">Purchase</button>

<script>

    function processToken(token) {
        var token_content = "";
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
    } // processToken()


    var handler = StripeCheckout.configure({
        key: '<?php echo $stripe['publishable_key']; ?>'
    });

    document.getElementById('customButton').addEventListener('click', function (e) {
        // Open Checkout with further options:
        handler.open({
            name: 'Jansal Valley',
            description: 'Website Order',
            zipCode: true,
            billingAddress: true,
            amount: 2000,
            image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
            locale: 'auto',
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

<!-- Update User ------------------------------------------------------------------------------------------------------>
<hr>
<h2>Update User CC Info</h2>

<!-- Simple Update Button --------------------------------------------------------------------------------------------->
<h3>Simple Update Button</h3>

<form action="stripe-test-api.php" method="POST">
    <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="<?php echo $stripe['publishable_key']; ?>"
            data-name="Jansal Valley Website"
            data-panel-label="Update Card Details"
            data-label="Update Card Details"
            data-allow-remember-me=false
            data-locale="auto">
    </script>
</form>

<!-- Custom Update --------------------------------------------------------------------------------------------->
<h3>Custom Update Button</h3>

<?php
$customer_id = "cus_DJ7qFc6ROzbAfp";
echo "customer_id = " . $customer_id . "<br><br>\n";

//\Stripe\Stripe::setApiKey($stripe['secret_key']);
$customerToUpdate = \Stripe\Customer::retrieve($customer_id); // stored in your application
//echo "customer email = " . $customerToUpdate->email;

//foreach ($customerToUpdate as $key => $value) {
//    echo "$key => $value\n";
//}

?>
<h3>Customer Details</h3>
<form action="stripe-test-api.php" method="POST">
    Email: <input type="text" name="email" id="email" value="<?php echo $customerToUpdate->email ?>"><br>
    Description: <input name="description" type="text" id="email" value="<?php echo $customerToUpdate->description ?>"><br>
    <input type="hidden" name="customerId" id="customerId" value="<?php echo $customerToUpdate->id ?>">
    <input type="submit" id="updateStripeCustomerDetails" name="updateStripeCustomerDetails" value="Update Stripe Customer Details">
</form>

<button id="customUpdate">Update Card Details</button>

<script>
</script>





