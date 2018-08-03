
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


//$tokenId = $_POST['tokenId'];
//$totalAmount = $_POST['totalAmount'];
//
//echo "tokenId = " . $tokenId . "<br><br>\n";

// --------------------------------------------
// create a straightforward charge with a token

$message = "Default Message";

try {
//    $charge = \Stripe\Charge::create([
//        'amount' => $totalAmount,
//        'currency' => 'usd',
//        'description' => 'Example charge',
//        'capture' => false,
//        'source' => $tokenId
//    ]);
//
//    $message = "Charge object = " . $charge . "<br><br>\n";
}
catch (Exception $e) {
    // Use the variable $error to save any errors
    // To be displayed to the customer later in the page
    //$body = $e->getJsonBody();
    //$err  = $body['error'];
    //$error = $err['message'];
    
    $message = $e;
    
}

echo $message;

// ---------------------------------------------



?>

<br/>
<br/>

