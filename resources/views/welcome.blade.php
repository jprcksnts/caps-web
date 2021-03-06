@extends('layouts.landing.app')

@section('styles')
    <style>
        /* DISABLE ARROWS ON INPUT TYPE NUMBER */
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endsection

@section('content')
    <div class="main-content">
        <div class="header bg-gradient-header py-7 py-lg-7 pt-lg-6 text-center">
            <div class="container"></div>
        </div>
        <div class="container mt--8">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    @include('shared.flash_messages')
                    <div class="card card-profile bg-gradient-white" style="margin-bottom: 10px;">
                        <div class="card-body pl-5 pr-5">
                            <h2 class="mb-0">
                                Get updated to our new products by subscribing our newsletter!
                            </h2>
                            <p class="mb-3">
                                Please enter your email and contact number to our list.
                            </p>
                            <form class="d-inline" method="POST" action="{{ route('subscribe') }}">
                                @csrf
                                <input type="email" class="form-control mb-2" id="email" name="email"
                                       placeholder="juandelacruz@example.com" required>
                                <input type="number" class="form-control input-number" id="contact_number" name="mobile"
                                       placeholder="09260000000"  required>
                                <button class="btn btn-default btn-block mt-3" type="submit">Subscribe</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // disable input number steps via up/down arrow keys
        var inputElements = document.getElementsByClassName('input-number');
        for (var i = 0; i < inputElements.length; i++) {
            inputElements[i].addEventListener('keydown', function (e) {
                if (e.which === 38 || e.which === 40) {
                    e.preventDefault();
                }
            });
        }

        // function phonenumber(inputtxt) {
        //     var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
        //     if (inputtxt.value.match(phoneno)) {
        //         return true;
        //     } else {
        //         return false;
        //     }
        // }
    </script>
@endsection
