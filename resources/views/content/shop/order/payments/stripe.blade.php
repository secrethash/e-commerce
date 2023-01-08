@extends('layouts.app')

@section('content')
    <div class="col-12 card p-md-5">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center mb-2"><span class="fw-light">Amount to Pay</span> {{$amounts->formattedTotal}}</h5>
                <div class="card-text">
                    <form id="payment-form">
                        <div id="link-authentication-element">
                            <!--Stripe.js injects the Link Authentication Element-->
                        </div>
                        <div id="payment-element">
                            <!--Stripe.js injects the Payment Element-->
                        </div>
                        <button id="submit" class="btn w-100 btn-danger btn-lg mt-3" disabled="disabled">
                            <div class="spinner hidden" id="spinner"></div>
                            <span id="button-text">Pay now</span>
                        </button>
                        <div id="payment-message" class="hidden"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // This is your test publishable API key.
        const stripe = Stripe("{{config('services.stripe.key')}}");
        let elements;

        initialize();
        checkStatus();

        document
            .querySelector("#payment-form")
            .addEventListener("submit", handleSubmit);

        var fullName = "{{$order->customer->full_name}}";
        var emailAddress = "{{$order->customer->email}}";
        // Fetches a payment intent and captures the client secret
        async function initialize() {
            const clientSecret = "{{$clientSecret}}";

            elements = stripe.elements({ clientSecret });

            const linkAuthenticationElement = elements.create("linkAuthentication");
            linkAuthenticationElement.mount("#link-authentication-element");

            const paymentElementOptions = {
                layout: "tabs",
                defaultValues: {
                    billingDetails: {
                        email: emailAddress,
                    },
                    email: emailAddress,
                },
                // fields: {
                //     billingDetails: 'never',
                // },
            };

            const paymentElement = elements.create("payment", paymentElementOptions);
            await paymentElement.mount("#payment-element");
            $('#submit').attr('disabled', false);
        }
        async function handleSubmit(e) {
            e.preventDefault();
            setLoading(true);

            const { error } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    // Make sure to change this to your payment completion page
                    return_url: "{{route('shop.checkout.payments.stripe.capture', ['order' => encrypt($order->id)])}}",
                    receipt_email: emailAddress,
                    payment_method_data: {
                        billing_details: {
                            name: fullName,
                            email: emailAddress,
                        },
                    },
                },
            });

            // This point will only be reached if there is an immediate error when
            // confirming the payment. Otherwise, your customer will be redirected to
            // your `return_url`. For some payment methods like iDEAL, your customer will
            // be redirected to an intermediate site first to authorize the payment, then
            // redirected to the `return_url`.
            if (error.type === "card_error" || error.type === "validation_error") {
                showMessage(error.message);
            } else {
                showMessage("An unexpected error occurred.");
            }

            setLoading(false);
        }

        // Fetches the payment intent status after payment submission
        async function checkStatus() {
            const clientSecret = new URLSearchParams(window.location.search).get(
                "payment_intent_client_secret"
            );

            if (!clientSecret) {
                return;
            }

            const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);

            switch (paymentIntent.status) {
                case "succeeded":
                    showMessage("Payment succeeded!");
                break;
                case "processing":
                    showMessage("Your payment is processing.");
                break;
                case "requires_payment_method":
                    showMessage("Your payment was not successful, please try again.");
                break;
                default:
                    showMessage("Something went wrong.");
                break;
            }
        }

        // ------- UI helpers -------

        function showMessage(messageText) {
            const messageContainer = document.querySelector("#payment-message");

            messageContainer.classList.remove("hidden");
            messageContainer.textContent = messageText;

            setTimeout(function () {
                messageContainer.classList.add("hidden");
                messageText.textContent = "";
            }, 4000);
        }

        // Show a spinner on payment submission
        function setLoading(isLoading) {
            if (isLoading) {
                // Disable the button and show a spinner
                document.querySelector("#submit").disabled = true;
                document.querySelector("#spinner").classList.remove("hidden");
                document.querySelector("#button-text").classList.add("hidden");
            } else {
                document.querySelector("#submit").disabled = false;
                document.querySelector("#spinner").classList.add("hidden");
                document.querySelector("#button-text").classList.remove("hidden");
            }
        }
    </script>
@endsection
