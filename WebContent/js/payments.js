/**
 * payments.js
 */

const mainElement = document.getElementById('main');
mainElement.classList.add('checkout');

// Retrieve the configuration
const config = getConfig();

// Create references to the main form and its submit button.
const form = document.getElementById('payment-form');
const submitButton = form.querySelector('button[type=submit]');

/**
 * Setup Stripe Elements.
 */
// Create a Stripe client.
const stripe = Stripe(config.stripePublishableKey);

// Create an instance of Elements.
const elements = stripe.elements();

// Prepare the styles for Elements.
const style = {
    base: {
        iconColor: '#666ee8',
        color: '#31325f',
        fontWeight: 400,
        fontFamily:
            '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '15px',
        '::placeholder': {
            color: '#aab7c4'
        },
        ':-webkit-autofill': {
            color: '#666ee8'
        }
    }
};

/**
 * Implement a Stripe Card Element that matches the look-and-feel of the app.
 *
 * This makes it easy to collect debit and credit card payments information.
 */

// Create a Card Element and pass some custom styles to it.
const card = elements.create('card', {style: style});

// Mount the Card Element on the page.
card.mount('#card-element');

// Monitor change events on the Card Element to display any errors.
card.on('change', function (error) {
    console.log("card change event:");
    const cardErrors = document.getElementById('card-errors');
    if (error) {
        cardErrors.textContent = error.message;
        cardErrors.classList.add('visible');
    } else {
        cardErrors.classList.remove('visible');
    }
// Re-enable the Pay button.
    submitButton.disabled = false;
});

/**
 * Handle the form submission.
 *
 * This creates an order and either sends the card information from the Element
 * alongside it, or creates a Source and start a redirect to complete the purchase.
 *
 * Please note this form is not submitted when the user chooses the "Pay" button
 * or Apple Pay, Google Pay, and Microsoft Pay since they provide name and
 * shipping information directly.
 */

// Submit handler for our payment form.
form.addEventListener('submit', function (event) {
    console.log("form submit event");
    event.preventDefault();

    // Disable the Pay button to prevent multiple click events.
    submitButton.disabled = true;

    // Retrieve the user information from the form.
    //const payment = form.querySelector('input[name=payment]:checked').value;
    const name = form.querySelector('input[name=name]').value;
    const email = form.querySelector('input[name=email]').value;
    const address = form.querySelector('input[name=address]').value;
    const city = form.querySelector('input[name=city]').value;
    const state = form.querySelector('input[name=state]').value;
    const postal_code = form.querySelector('input[name=postal_code]').value;

    var ownerInfo = {
        owner: {
            name: name,
            address: {
                line1: address,
                city: city,
                postal_code: postal_code,
                country: 'US'
            },
            email: email
        }
    };

    // Create a Stripe source from the card information and the owner name.
    stripe.createSource(card, ownerInfo).then(function (result) {
        console.log("result = " + result);
        if (result.error) {

            console.log(result.error.message);
        }
        else {
            handleOrder(result.source);
        }
    });
});

// Handle the order and source activation if required
function handleOrder(source, error) {
    console.log("handleOrder()");

    logSourceDetails(source);

    const mainElement = document.getElementById('main');
    const confirmationElement = document.getElementById('confirmation');

    if (error) {
        mainElement.classList.remove('processing');
        mainElement.classList.remove('receiver');
        confirmationElement.querySelector('.error-message').innerText =
            error.message;
        mainElement.classList.add('error');
    }

    submitButton.textContent = 'Processing Payment…';

    // what to do on the server side
    //document.getElementById('action').value = "chargeSource";
    document.getElementById('action').value = "createCustomer";

    document.getElementById('source').value = source;
    document.getElementById('sourceId').value = source.id;
    document.getElementById('totalAmount').value = getOrderTotal();
    document.getElementById('processPaymentForm').submit();

} // handleOrder()


// Format a price (assuming a two-decimal currency like EUR or USD for simplicity).
function formatPrice(amount, currency) {
    console.log("formatPrice()");
    currency = 'USD';
    const price = (amount / 100).toFixed(2);
    const numberFormat = new Intl.NumberFormat(['en-US'], {
        style: 'currency',
        currency: currency,
        currencyDisplay: 'symbol'
    });
    return numberFormat.format(price);
}

// Set the active order ID in the local storage.
function setActiveOrderId(orderId) {
    console.log("setActiveOrderId()");
    localStorage.setItem('orderId', orderId);
}

// Get the active order ID from the local storage.
function getActiveOrderId() {
    console.log("getActiveOrderId()");
    return localStorage.getItem('orderId');
}

// Compute the total for the order based on the line items (SKUs and quantity).
function getOrderTotal() {
    console.log("getOrderTotal()");
    return 1923;
}

// Retrieve the configuration from the API.
function getConfig() {
    console.log("getConfig()");
    try {
        //const response = await fetch('/config');
        //const config = await response.json();
        const config = {
            "stripePublishableKey": "pk_test_fXV7CvLKY2vmEkalqQezZUPc",
            "stripeCountry": "US",
            "country": "US",
            "currency": "eur"
        };

        // const config = {"secret_key": "sk_test_eqsKAOlHzbzvqXnEOd8AEItV",
        //     "publishable_key": "pk_test_fXV7CvLKY2vmEkalqQezZUPc"}
        if (config.stripePublishableKey.includes('live')) {
            // Hide the demo notice if the publishable key is in live mode.
            document.querySelector('#order-total .demo').style.display = 'none';
        }
        return config;
    } catch (err) {
        return {error: err.message};
    }
}

function logSourceDetails(source) {
    for (var key in source) {
        if (source.hasOwnProperty(key)) {
            console.log("source." + key + " -> " + source[key] + "\n");
            if (key === "owner") {
                for (var ownerKey in source.owner) {
                    console.log("source.owner." + ownerKey + " -> " + source.owner[ownerKey] + "\n");
                    if (ownerKey === "address") {
                        for (var addressKey in source.owner.address) {
                            console.log("source.owner.address" + addressKey + " -> " + source.owner.address[addressKey] + "\n");
                        }
                    }
                }
            }
        }
    }
} // logSourceDetails()

// Update the main button to reflect the payment method being selected.
function updateButtonLabel(paymentMethod, bankName) {
    console.log("updateButtonLabel()");
    const amount = formatPrice(getOrderTotal(), config.currency);
    const name = paymentMethods[paymentMethod].name;
    var label = "Pay " + amount;
    if (paymentMethod !== 'card') {
        label = "Pay " + amount + " with " + name;
    }

    submitButton.innerText = label;
}
