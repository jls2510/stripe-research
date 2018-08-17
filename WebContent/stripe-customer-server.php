<?php

echo basename(__FILE__) . "<br><br>\n";

require_once('./stripe-config.php');

if ($_POST) {
    echo "Form data received:<br>\n";
    foreach ($_POST as $key => $value) {
        echo $key . " = " . $value . "<br>\n";
    }
}

//echo "retrieved Api key: " . \Stripe\Stripe::getApiKey() . "<br><br>\n";

$action = "getCustomer"; // default
//if ($_POST['action']) {
//    $action = $_POST['action'];
//}
//echo "action = " . $action . "<br><br>\n";

$customerId = 'cus_DLmpRwTK4G2VDN'; // Elvis
//if ($_POST['customerId']) {
//    $customerId = $_POST['customerId'];
//}
echo "Current Customer ID: " . $customerId . "<br><br>\n";

if ($action == 'getCustomer') {
    $customerJson = getCustomer($customerId);

    $customerJson = str_replace("Stripe\Customer JSON: ", "", $customerJson);
    $customer = json_decode($customerJson, true);

    //echo $customer;

    echo "-----------------------------------<br><br>\n";
    echo "CUSTOMER: <br><br>\n";
    echo "email = " . $customer['email'] . "<br><br>\n";
    echo "CUSTOMER/SOURCES/DATA/0/OWNER: <br><br>\n";
    echo "name = " . $customer['sources']['data'][0]['owner']['name'] . "<br><br>\n";
    echo "email = " . $customer['sources']['data'][0]['owner']['email'] . "<br><br>\n";
    echo "address 1 = " . $customer['sources']['data'][0]['owner']['address']['line1'] . "<br><br>\n";
    echo "CUSTOMER/SOURCES/DATA/0/CARD: <br><br>\n";
    echo "brand: " . $customer['sources']['data'][0]['card']['brand'] . "<br><br>\n";
    echo "last4: " . $customer['sources']['data'][0]['card']['last4'] . "<br><br>\n";
    echo "exp_month: " . $customer['sources']['data'][0]['card']['exp_month'] . "<br><br>\n";
    echo "exp_year: " . $customer['sources']['data'][0]['card']['exp_year'] . "<br><br>\n";

    echo "-----------------------------------<br><br>\n";
    logObject($customer);

    echo "-----------------------------------<br><br>\n";
    echo $customerJson;

}

function logObject($object)
{
    foreach ($object as $key => $value) {
        if (is_array($value)) {
            echo "$key => ..........<br><br>\n";
            logObject($value);
            echo "----------<br><br>\n";
        } else {
            echo "$key => $value<br><br>\n";
        }
    }
} // logObject()

// ---------------------------------------------

function getSource($sourceId)
{

    $source = \Stripe\Source::retrieve($sourceId);

    return $source;

} // getSource()


function getCustomer($customerId)
{
    //echo "getCustomer()<br><br>\n";

    try {
        // Get a Customer:
        echo "Getting Customer with customerId: " . $customerId . "<br><br>\n";
        $customer = \Stripe\Customer::retrieve($customerId);

        $customerId = $customer->id;

        //echo "Customer object = " . $customer . "<br><br>\n";

        //chargeCustomer($customerId, $totalAmount);

    } catch (Exception $e) {
        // Use the variable $error to save any errors
        // To be displayed to the customer later in the page
        //$body = $e->getJsonBody();
        //$err  = $body['error'];
        //$error = $err['message'];
        echo $e . "<br><br>\n";
    }

    return $customer;

} // getCustomer()


function updateCustomer($customer)
{

    $email = $_POST['email'];
    $description = $_POST['description'];

    try {
        //$customerToUpdate->source = $token;
        $customer->email = $email;
        $customer->description = $description;

        $customer->save();

        echo "Your customer details have been updated!<br><br>\n";

    } catch (Exception $e) {
        echo $e . "<br><br>\n";
    }

} // updateCustomer()


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


