@extends('user.layout.base')
@section('title', 'Verify')

@section('content')
    <div class="dash-content">
        <div class="row no-margin">
            <div class="col-md-12">
                <h4 class="page-title">Verify your account</h4>
            </div>
        </div>
        @include('common.notify')
        <div class="row no-margin">
            <div class="col-md-6">
                @if (Setting::get('twilio_verification', 0) == 1)
                    <form action="{{ url('verifyUserOTP') }}" method="POST">
                        @csrf
                        <div class="input-group dash-form" style="margin-top: 15px;">
                            <input type="text" class="form-control" id="otp-code" name="otp"
                                   placeholder="Enter OTP..." required>
                        </div>
                        <button type="submit" class="full-primary-btn fare-btn">Continue</button>
                    </form>
                @elseif(Setting::get('verification', 0) == 1)
                    <div class="input-group dash-form" style="margin-top: 15px;">
                        @csrf
                        <div class="alert alert-danger hide" id="error-message"></div>
                        <div class="alert alert-success hide" id="sent-message"></div>
                        <input type="hidden" id="phone-number" name="phone-number" value="{{ $user->mobile }}"/>
                        <input type="text" class="form-control" id="otp-code" name="otp" placeholder="Enter OTP..."
                               Required>
                        <div id="recaptcha-container"></div>
                    </div>
                    <button type="button" class="full-primary-btn fare-btn" onclick="otpVerify();">Continue</button>
                    {{-- <button type="button" class="full-primary-btn fare-btn" onclick="otpSend();">Resend OTP</button> --}}
                @endif

            </div>
        </div>
    </div>
@endsection

@section('scripts')

    @if (Setting::get('verification', 0) == 1)
        <script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-app.js"></script>
        <script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-auth.js"></script>
        <script type="text/javascript">
            const config = {
                apiKey: "AIzaSyCkFktSLD7u1-yUuLRs9TIvZRGEFn_bI9g",
                authDomain: "rosalymendez-98499.firebaseapp.com",
                // databaseURL: "XXXXXXXXX.firebaseio.com",
                projectId: "rosalymendez-98499",
                storageBucket: "rosalymendez-98499.appspot.com",
                messagingSenderId: "476898660277",
                appId: "1:476898660277:web:4e1ac4cf7c17142b1013fc",
                measurementId: "G-TLYT3RY9DQ"
            };

            firebase.initializeApp(config);

            // reCAPTCHA widget    
            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
                'size': 'invisible',
                'callback': (response) => {
                    // reCAPTCHA solved, allow signInWithPhoneNumber.
                    onSignInSubmit();
                }
            });

            function otpSend() {
                var phoneNumber = document.getElementById('phone-number').value;

                const appVerifier = window.recaptchaVerifier;
                firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
                    .then((confirmationResult) => {
                        // SMS sent. Prompt user to type the code from the message, then sign the
                        // user in with confirmationResult.confirm(code).
                        window.confirmationResult = confirmationResult;
                        document.getElementById("sent-message").innerHTML = "Message sent succesfully.";
                        document.getElementById("sent-message").classList.remove("hide");
                        document.getElementById("sent-message").classList.add("d-block");
                    }).catch((error) => {
                    document.getElementById("error-message").innerHTML = error.message;
                    document.getElementById("error-message").classList.remove("hide");
                    document.getElementById("error-message").classList.add("d-block");
                });
            }

            otpSend();

            function otpVerify() {
                var code = document.getElementById('otp-code').value;
                confirmationResult.confirm(code).then(function (result) {

                    verifyUser();
                    // User signed in successfully.
                    var user = result.user;
                    verifyUser();

                    document.getElementById("sent-message").innerHTML = "You are succesfully logged in.";
                    document.getElementById("sent-message").classList.remove("hide");
                    document.getElementById("sent-message").classList.add("d-block");

                }).catch(function (error) {
                    document.getElementById("error-message").innerHTML = error.message;
                    document.getElementById("error-message").classList.remove("hide");
                    document.getElementById("error-message").classList.add("d-block");
                });
            }

            function verifyUser() {
                $.post("{{ route('verifyUserOTP') }}", {
                    '_token': $('input[name=_token]').val(),
                }).done(function () {
                    window.location = '/dashboard';
                });
            }
        </script>
    @endif

@endsection
