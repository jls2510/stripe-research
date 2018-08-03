<?php
/**
 * Created by PhpStorm.
 * User: consultant
 * Date: 8/2/2018
 * Time: 3:14 PM
 */
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
                    <label class="select">
                        <span>Country</span>
                        <div id="country" class="field US">
                            <select name="country">
                                <option value="AU">Australia</option>
                                <option value="AT">Austria</option>
                                <option value="BE">Belgium</option>
                                <option value="BR">Brazil</option>
                                <option value="CA">Canada</option>
                                <option value="CN">China</option>
                                <option value="DK">Denmark</option>
                                <option value="FI">Finland</option>
                                <option value="FR">France</option>
                                <option value="DE">Germany</option>
                                <option value="HK">Hong Kong</option>
                                <option value="IE">Ireland</option>
                                <option value="IT">Italy</option>
                                <option value="JP">Japan</option>
                                <option value="LU">Luxembourg</option>
                                <option value="MX">Mexico</option>
                                <option value="NL">Netherlands</option>
                                <option value="NZ">New Zealand</option>
                                <option value="NO">Norway</option>
                                <option value="PT">Portugal</option>
                                <option value="SG">Singapore</option>
                                <option value="ES">Spain</option>
                                <option value="SE">Sweden</option>
                                <option value="CH">Switzerland</option>
                                <option value="GB">United Kingdom</option>
                                <option value="US" selected="selected">United States</option>
                            </select>
                        </div>
                    </label>
                </fieldset>
                <p class="tip">Select another country to see different payment options.</p>
            </section>
            <section>
                <h2>Payment Information</h2>
                <nav id="payment-methods">
                    <ul>
                        <li>
                            <input type="radio" name="payment" id="payment-card" value="card" checked>
                            <label for="payment-card">Card</label>
                        </li>
                        <li>
                            <input type="radio" name="payment" id="payment-ach_credit_transfer" value="ach_credit_transfer" checked>
                            <label for="payment-ach_credit_transfer">Bank Transfer</label>
                        </li>
                        <li>
                            <input type="radio" name="payment" id="payment-alipay" value="alipay">
                            <label for="payment-alipay">Alipay</label>
                        </li>
                        <li>
                            <input type="radio" name="payment" id="payment-bancontact" value="bancontact">
                            <label for="payment-bancontact">Bancontact</label>
                        </li>
                        <li>
                            <input type="radio" name="payment" id="payment-eps" value="eps">
                            <label for="payment-eps">EPS</label>
                        </li>
                        <li>
                            <input type="radio" name="payment" id="payment-ideal" value="ideal">
                            <label for="payment-ideal">iDEAL</label>
                        </li>
                        <li>
                            <input type="radio" name="payment" id="payment-giropay" value="giropay">
                            <label for="payment-giropay">Giropay</label>
                        </li>
                        <li>
                            <input type="radio" name="payment" id="payment-multibanco" value="multibanco">
                            <label for="payment-multibanco">Multibanco</label>
                        </li>
                        <li>
                            <input type="radio" name="payment" id="payment-sepa_debit" value="sepa_debit">
                            <label for="payment-sepa_debit">SEPA Direct Debit</label>
                        </li>
                        <li>
                            <input type="radio" name="payment" id="payment-sofort" value="sofort">
                            <label for="payment-sofort">SOFORT</label>
                        </li>
                        <li>
                            <input type="radio" name="payment" id="payment-wechat" value="wechat">
                            <label for="payment-wechat">WeChat Pay</label>
                        </li>
                    </ul>
                </nav>
                <div class="payment-info card visible">
                    <fieldset>
                        <label>
                            <span>Card</span>
                            <div id="card-element" class="field"></div>
                        </label>
                    </fieldset>
                </div>
                <div class="payment-info sepa_debit">
                    <fieldset>
                        <label>
                            <span>IBAN</span>
                            <div id="iban-element" class="field"></div>
                        </label>
                    </fieldset>
                    <p class="notice">By providing your IBAN and confirming this payment, you’re authorizing Payments Demo and Stripe, our payment
                        provider, to send instructions to your bank to debit your account. You’re entitled to a refund under the terms
                        and conditions of your agreement with your bank.</p>
                </div>
                <div class="payment-info ideal">
                    <fieldset>
                        <label>
                            <span>iDEAL Bank</span>
                            <div id="ideal-bank-element" class="field"></div>
                        </label>
                    </fieldset>
                </div>
                <div class="payment-info redirect">
                    <p class="notice">You’ll be redirected to the banking site to complete your payment.</p>
                </div>
                <div class="payment-info receiver">
                    <p class="notice">Payment information will be provided after you place the order.</p>
                </div>
                <div class="payment-info wechat">
                    <div id="wechat-qrcode"></div>
                    <p class="notice">Click the button below to generate a QR code for WeChat.</p>
                </div>
            </section>
            <button type="submit">Pay</button>
        </form>
        <div id="card-errors" class="element-errors"></div>
        <div id="iban-errors" class="element-errors"></div>
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
<div id="summary">
    <header>
        <h1>Order Summary</h1>
    </header>
    <div id="order-items"></div>
    <div id="order-total">
        <div class="line-item subtotal">
            <p class="label">Subtotal</p>
            <p class="price" data-subtotal></p>
        </div>
        <div class="line-item shipping">
            <p class="label">Shipping</p>
            <p class="price">Free</p>
        </div>
        <div class="line-item demo">
            <div id="demo">
                <p class="label">Demo in test mode</p>
                <p class="note">This app is running in test mode. You will
                    <em>not</em> be charged.</p>
                <p class="note"> Feel free to test payments using a real card or any
                    <a href="https://stripe.com/docs/testing#cards" target="_blank">Stripe test card</a>. Non-card payments will redirect to test pages.
                </p>
                <p class="note">Run this app locally in live mode with your Stripe account to create real payments and see redirects to banking
                    sites.
                </p>
            </div>
        </div>
        <div class="line-item total">
            <p class="label">Total</p>
            <p class="price" data-total></p>
        </div>
    </div>
</div>
<!-- Stripe.js v3 for Elements -->
<script src="https://js.stripe.com/v3/"></script>
<!-- Library to render QR codes -->
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
<!-- App -->
<script src="/js/store.js"></script>
<script src="/js/payments.js"></script>
</body>

</html>
