@extends('layouts.admin.app')

@section('header_left')
    <h6 class="h2 text-white d-inline-block mb-0">
        PRODUCTS
    </h6>
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span class="ml-2"> Dashboard </span>
                </a>
            </li>
            <li class="breadcrumb-item text-gray">Product Management</li>
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
                                    <label class="form-control-label" for="name">
                                        Product Name
                                    </label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ $product->name ?? old('name') }}">
                                </div>

                                <div class="form-group mb-2">
                                    <label class="form-control-label" for="product_type_id">Product Type</label>
                                    @if(count($product_types) > 0)
                                        <select class="form-control" id="product_type_id" name="product_type_id">
                                            @foreach ($product_types as $product_type)
                                                <option value="{{ $product_type->id }}" id="{{ $product_type->id }}"
                                                        @if (isset($product)) @if ($product->product_type_id == $product_type->id)
                                                        selected @endif @endif>
                                                    {{ $product_type->type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <select class="form-control" id="product_type_id" name="product_type_id"
                                                disabled>
                                            <option value="0" id="0">
                                                No product types found.
                                            </option>
                                        </select>
                                    @endif
                                </div>

                                <div class="form-group mb-2">
                                    <label class="form-control-label" for="code">
                                        Code
                                    </label>
                                    <input type="text" class="form-control" id="code" name="code"
                                           value="{{ $product->code ?? old('code') }}">
                                </div>

                                @if ($form_action['action'] == 'create')
                                    <div class="form-group mb-2">
                                        <label class="form-control-label" for="quantity">
                                            Initial Quantity
                                        </label>
                                        <input type="number" class="form-control" id="quantity" name="quantity"
                                               value="{{ $product->quantity ?? old('quantity') }}">
                                    </div>
                                @endif

                                <button class="btn btn-primary btn-block mt-4 w-50" type="submit"
                                        @if(count($product_types) < 1) disabled @endif>
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
