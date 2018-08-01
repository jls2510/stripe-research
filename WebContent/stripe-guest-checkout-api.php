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


$tokenId = $_POST['tokenId'];
$totalAmount = $_POST['totalAmount'];

echo "tokenId = " . $tokenId . "<br><br>\n";

// --------------------------------------------
// create a straightforward charge with a token

    $charge = \Stripe\Charge::create([
        'amount' => $totalAmount,
        'currency' => 'usd',
        'description' => 'Example charge',
        'capture' => false,
        'source' => $tokenId
    ]);

    echo "Charge object = " . $charge . "<br><br>\n";

// ---------------------------------------------



?>

<br/>
<br/>

