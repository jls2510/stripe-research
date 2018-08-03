<?php
?>
<html>

<head>
    <title>Stripe Payments Demo</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/stripe-demo.css">
    <link rel="icon" type="image/png" sizes="104x80" href="/images/logo.png">
</head>

<body>
<div id="main" class="loading">
    <header>
        <a class="shop" href="/">Stripe Payments Demo</a>
    </header>
    <div id="checkout">
        <div id="payment-request">
            <div id="payment-request-button"></div>
        </div>
        <form id="payment-form" method="POST" action="/orders">
            <p class="instruction">Complete your shipping and payment details below</p>
            <section>
                <h2>Shipping &amp; Billing Information</h2>
                <fieldset class="with-state">
                    <label>
                        <span>Name</span>
                        <input name="name" class="field" placeholder="Jenny Rosen" required>
                    </label>
                    <label>
                        <span>Email</span>
                        <input name="email" type="email" class="field" placeholder="jenny@example.com" required>
                    </label>
                    <label>
                        <span>Address</span>
                        <input name="address" class="field" placeholder="185 Berry Street Suite 550">
                    </label>
                    <label>
                        <span>City</span>
                        <input name="city" class="field" placeholder="San Francisco">
                    </label>
                    <label class="state">
                        <span>State</span>
                        <input name="state" class="field" placeholder="CA">
                    </label>
                    <label class="zip">
                        <span>ZIP</span>
                        <input name="postal_code" class="field" placeholder="94107">
                    </label>
                </fieldset>
            </section>
            <section>
                <h2>Payment Information</h2>
                <div class="payment-info card visible">
                    <fieldset>
                        <label>
                            <span>Card</span>
                            <div id="card-element" class="field"></div>
                        </label>
                    </fieldset>
                </div>
            </section>
            <button type="submit">Pay</button>
        </form>
        <div id="card-errors" class="element-errors"></div>
    </div>
    <div id="confirmation">
        <div class="status processing">
            <h1>Completing your order…</h1>
            <p>We’re just waiting for the confirmation from your bank… This might take a moment but feel free to close this page.</p>
            <p>We’ll send your receipt via email shortly.</p>
        </div>
        <div class="status success">
            <h1>Thanks for your order!</h1>
            <p>Woot! You successfully made a payment with Stripe.</p>
            <p class="note">We just sent your receipt to your email address, and your items will be on their way shortly.</p>
        </div>
        <div class="status receiver">
            <h1>Thanks! One last step!</h1>
            <p>Please make a payment using the details below to complete your order.</p>
            <div class="info"></div>
        </div>
        <div class="status error">
            <h1>Oops, payment failed.</h1>
            <p>It looks like your order could not be paid at this time. Please try again or select a different payment option.</p>
            <p class="error-message"></p>
        </div>
    </div>
</div>
<!-- Stripe.js v3 for Elements -->
<script src="https://js.stripe.com/v3/"></script>
<!-- App -->
<script src="/js/payments.js"></script>

<form id="processPaymentForm" action="stripe-payments-demo-server.php" method="POST">
    <input type="hidden" id="sourceId" name="sourceId">
    <input type="hidden" id="totalAmount" name="totalAmount">
</form>

</body>

</html>
