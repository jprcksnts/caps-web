@extends('layouts.admin.app')

@section('header_left')
    <h6 class="h2 text-white d-inline-block mb-0">
        PRODUCT ORDERS
    </h6>
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span class="ml-2"> Dashboard </span>
                </a>
            </li>
            <li class="breadcrumb-item text-gray">Transactions</li>
        </ol>
    </nav>
@stop

@section('header_right')
    <a href="{{ URL::previous() }}" class="btn btn-md btn-neutral text-dark">
        <span class="btn-inner--icon mr-2"><i class="fas fa-chevron-left"></i></span>
        Back
    </a>
@stop

@section('content')
    @include('shared.modal_scan_code')
    <div class="col-md-6">
        <div class="row">
            <div class="col">
                <div class="card-wrapper">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0 font-weight-900">{{ $form_action['page_title'] }}</h3>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ $form_action['route'] }}" role="form" id="form-data">
                                @csrf

                                <div class="form-group mb-2">
                                    <label class="form-control-label" for="product_uuid">Product</label>
                                    <select class="form-control" id="product_id" name="product_id">
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" id="{{ $product->id }}">
                                                {{ $product->name }} (ID #{{ $product->id }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4 small">
                                    Select Product via generated code?<a href="#" data-toggle="modal"
                                                                         data-target="#modalScanCode">
                                        <span class="ml-2 text-body-2-custom">Scan QR Code.</span>
                                    </a>
                                </div>

                                <div class="form-group mb-2">
                                    <label class="form-control-label" for="form-date"> Expected Arrival Date * </label>
                                    <input type="text"
                                           class="form-control datepicker @if ($errors->has('expected_arrival_date')) is-invalid @endif"
                                           id="form-date" name="expected_arrival_date"
                                           value="{{ $product_order->expected_arrival_date ?? old('expected_arrival_date') }}">
                                    @if ($errors->has('expected_arrival_date'))
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('expected_arrival_date') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group mb-2">
                                    <label class="form-control-label" for="quantity">
                                        Quantity
                                    </label>
                                    <input type="number" class="form-control" id="quantity" name="quantity"
                                           value="{{ $product_order->quantity ?? old('quantity') }}">
                                </div>

                                <button class="btn btn-primary btn-block mt-4 w-25" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
@endsection
