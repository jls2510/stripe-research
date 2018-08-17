<?php

echo basename(__FILE__) . "<br><br>\n";

require_once('./stripe-config.php');

if ($_POST) {
    echo "Form data received:<br>\n";
    foreach ($_POST as $key => $value) {
        echo $key . " = " . $value . "<br>\n";
    }
}

echo "retrieved Api key: " . \Stripe\Stripe::getApiKey() . "<br><br>\n";

$action = $_POST['action'];
echo "action = " . $action . "<br><br>\n";

if ($action == 'chargeSource') {
    chargeSource();
} else if ($action == 'createCustomer') {
    createCustomer();
}

// ---------------------------------------------

function chargeSource()
{
    echo "chargeSource()<br><br>\n";

    $sourceId = $_POST['sourceId'];
    $totalAmount = $_POST['totalAmount'];

    echo "sourceId = " . $sourceId . "<br><br>\n";

    try {
        $charge = \Stripe\Charge::create([
            'amount' => $totalAmount,
            'currency' => 'usd',
            'description' => 'Example charge',
            'capture' => false,
            'source' => $sourceId
        ]);

        echo "Charge object = " . $charge . "<br><br>\n";

    } catch (Exception $e) {
        // Use the variable $error to save any errors
        // To be displayed to the customer later in the page
        //$body = $e->getJsonBody();
        //$err  = $body['error'];
        //$error = $err['message'];
        echo $e . "<br><br>\n";
    }

} // chargeSource()


function getSource($sourceId) {

    $source = \Stripe\Source::retrieve($sourceId);

    return $source;

} // getSource()


function createCustomer()
{
    echo "createCustomer()<br><br>\n";

    $sourceId = $_POST['sourceId'];
    $totalAmount = $_POST['totalAmount'];

    echo "sourceId = " . $sourceId . "<br><br>\n";

    $source = getSource($sourceId);
    $source = str_replace("Stripe\Source JSON: ", "", $source);
    $source = json_decode($source, true);

    $email = "test@kogentservices.com";
    if ($source['owner']['email']) {
        $email = $source['owner']['email'];
    }
    //echo "email = " . $email . "<br><br>\n";

    try {
        // Create a Customer:
        echo "Creating Customer with sourceId: " . $sourceId . "<br><br>\n";
        $customer = \Stripe\Customer::create([
            'source' => $sourceId,
            'email' => $email,
        ]);

        $customerId = $customer->id;

        echo "Customer object = " . $customer . "<br><br>\n";

        chargeCustomer($customerId, $totalAmount);

    } catch (Exception $e) {
        echo "Caught Exception" . "<br><br>\n";
        // Use the variable $error to save any errors
        // To be displayed to the customer later in the page
        //$body = $e->getJsonBody();
        //$err  = $body['error'];
        //$error = $err['message'];
        echo $e . "<br><br>\n";
    }

} // createCustomer()


function chargeCustomer($customerId, $amount)
{
    echo "chargeCustomer()<br><br>\n";

    try {
        // Charge the Customer instead of the card:
        echo "Charging Customer " . $customerId . ": amount: " . $amount . "<br><br>\n";
        $charge = \Stripe\Charge::create([
            'amount' => $amount,
            'currency' => 'usd',
            'capture' => false,
            'customer' => $customerId,
        ]);

        echo "Charge object = " . $charge . "<br><br>\n";

        captureCharge($charge->id);

    } catch (Exception $e) {
        // Use the variable $error to save any errors
        // To be displayed to the customer later in the page
        //$body = $e->getJsonBody();
        //$err  = $body['error'];
        //$error = $err['message'];
        echo $e . "<br><br>\n";
    }

} // chargeCustomer()

function captureCharge($chargeId)
{
    echo "captureCharge()<br><br>\n";

    try {
        // Charge the Customer instead of the card:
        echo "Capturing Charge " . $chargeId . "<br><br>\n";
        $charge = \Stripe\Charge::retrieve($chargeId);
        $charge->capture();

        echo "Charge object = " . $charge . "<br><br>\n";

    } catch (Exception $e) {
        // Use the variable $error to save any errors
        // To be displayed to the customer later in the page
        //$body = $e->getJsonBody();
        //$err  = $body['error'];
        //$error = $err['message'];
        echo $e . "<br><br>\n";
    }

} // captureCharge()

?>

<br/>
<br/>

