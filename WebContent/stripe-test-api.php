stripe-test-api.php
<br/>
<br/>

<?php

require_once('./stripe-config.php');

if ($_POST) {
    echo "Form data received:<br>\n";
    foreach ($_POST as $key => $value) {
        echo $key . " = " . $value . "<br>\n";
    }
}

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
//\Stripe\Stripe::setApiKey($stripe['secret_key']);
//echo "retrieved Api key: " . \Stripe\Stripe::getApiKey() . "<br><br>\n";


// Token is created using Checkout or Elements!
// $token = "tok_1CsFtJDe6Ik2zG26lCoQxBl0"; // used
// $token = "tok_1CsF8sDe6Ik2zG26P22CWLvN"; // used

// $token = "tok_1CsF0yDe6Ik2zG26mzRV96e2"; // not used
// $token = "tok_1CsDZSDe6Ik2zG26FMSnHJvC"; // not used
// $token = "tok_1CsD6uDe6Ik2zG26JujvFQQz"; // not used
//$token = "tok_1CsVvSDe6Ik2zG26L6KNnhvW"; // not used (update)

//$token = $_POST['stripeToken'];

//echo "token = " . $oken . "<br><br>\n";

//$customer_id = "cus_DJ7qFc6ROzbAfp";
//echo "customer_id = " . $customer_id . "<br><br>\n";

// --------------------------------------------
// update customer details

if ($_POST['updateStripeCustomerDetails']) {
    $customer_id = $_POST['customerId'];
    $email = $_POST['email'];
    $description = $_POST['description'];

try {
    $customerToUpdate = \Stripe\Customer::retrieve($customer_id); // stored in your application
    //$customerToUpdate->source = $token; // obtained with Checkout
    $customerToUpdate->email = $email;
    $customerToUpdate->description = $description;
    $customerToUpdate->save();

    $message = "Your card details have been updated!";
}
catch(\Stripe\Error\Card $e) {

    // Use the variable $error to save any errors
    // To be displayed to the customer later in the page
    $body = $e->getJsonBody();
    $err  = $body['error'];
    $error = $err['message'];

    $message = $error;
}

    echo $message;

}

// --------------------------------------------


// --------------------------------------------
// create a customer, charge and charge again

// Create a Customer:
//echo "Creating Customer with token: " . $token . "...<br>\n";
//$customer = \Stripe\Customer::create([
//    'source' => $token,
//    'email' => 'paying.user@example.com',
//]);
//
//echo "Customer object = " . $customer . "<br><br>\n";

// Charge the Customer instead of the card:
//echo "Charging Customer " . $customer_id . "...<br>\n";
//$charge = \Stripe\Charge::create([
//    'amount' => 1000,
//    'currency' => 'usd',
//    'customer' => $customer_id,
//]);
//
//echo "Charge object = " . $charge . "<br><br>\n";

// YOUR CODE: Save the customer ID and other info in a database for later.

//// When it's time to charge the customer again, retrieve the customer ID.
//$charge = \Stripe\Charge::create([
//    'amount' => 1500, // $15.00 this time
//    'currency' => 'usd',
//    'customer' => $customer_id, // Previously stored, then retrieved
//]);

// --------------------------------------------


// --------------------------------------------
// create a straightforward charge with a token

//    $charge = \Stripe\Charge::create([
//        'amount' => 999,
//        'currency' => 'usd',
//        'description' => 'Example charge',
//        'source' => $token,
//    ]);
//
//    echo "Charge object = " . $charge . "<br><br>\n";

// ---------------------------------------------


// display relevant installed packages
//foreach(get_declared_classes() as $name) {
//    if (strpos($name, "Stripe") > -1 || strpos($name, "Composer") > -1) {
//        echo $name . "<br>\n";
//    }
//}

?>

<br/>
<br/>

