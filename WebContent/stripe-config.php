<?php

// Composer autoloading
include __DIR__ . '/../vendor/autoload.php';



$stripe = array(
    "secret_key"      => "sk_test_eqsKAOlHzbzvqXnEOd8AEItV",
    "publishable_key" => "pk_test_fXV7CvLKY2vmEkalqQezZUPc"
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);

?>