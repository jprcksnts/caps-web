@extends('layouts.admin.app')

@section('header_left')
    <h6 class="h2 text-white d-inline-block mb-0">
        PRODUCT SALES
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
    <a href="{{ route('product_sales.index') }}" class="btn btn-md btn-neutral text-dark">
        <span class="btn-inner--icon mr-2"><i class="fas fa-chevron-left"></i></span>
        Back to Data List
    </a>
@stop

@section('content')
    <div class="col-md-6">
        <div class="row">
            <div class="col">
                @include('shared.flash_messages')
                <div class="card-wrapper">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0 font-weight-900">Product Sale Detail</h3>
                        </div>
                        <div class="card-body">
                            <div class="pb-4">
                                <p class="small font-weight-bold"> PRODUCT QR CODE </p>
                                <img src="{{ asset('generated_code/' . $product_sale->product->uuid . '.svg') }}"
                                     class="img-fluid" style="max-height: 160px;">
                            </div>
                            <div class="row">
                                {{-- ID --}}
                                <div class="col-sm-3">
                                    <small class="text-uppercase text-muted font-weight-bold">ID #</small>
                                </div>
                                <div class="col-sm-9">
                                    <p class="font-weight-normal">{{ $product_sale->id }}</p>
                                </div>
                                {{-- Product Name --}}
                                <div class="col-sm-3">
                                    <small class="text-uppercase text-muted font-weight-bold">Product Name</small>
                                </div>
                                <div class="col-sm-9">
                                    <p class="font-weight-normal">{{ $product_sale->product->name }}</p>
                                </div>
                                {{-- Product Code --}}
                                <div class="col-sm-3">
                                    <small class="text-uppercase text-muted font-weight-bold">Product Code</small>
                                </div>
                                <div class="col-sm-9">
                                    <p class="font-weight-normal">{{ $product_sale->product->code }}</p>
                                </div>
                                {{-- Expected Arrival Date --}}
                                <div class="col-sm-3">
                                    <small class="text-uppercase text-muted font-weight-bold">Branch</small>
                                </div>
                                <div class="col-sm-9">
                                    <p class="font-weight-normal">{{ $product_sale->branch->name }}</p>
                                </div>
                                {{-- Quantity --}}
                                <div class="col-sm-3">
                                    <small class="text-uppercase text-muted font-weight-bold">Quantity</small>
                                </div>
                                <div class="col-sm-9">
                                    <p class="font-weight-normal">{{ $product_sale->quantity }}</p>
                                </div>
                                {{-- Created At --}}
                                <div class="col-sm-3">
                                    <small class="text-uppercase text-muted font-weight-bold">Created At</small>
                                </div>
                                <div class="col-sm-9">
                                    <p class="font-weight-normal">{{ $product_sale->created_at }}</p>
                                </div>
                                {{-- Updated At --}}
                                <div class="col-sm-3">
                                    <small class="text-uppercase text-muted font-weight-bold">Updated At</small>
                                </div>
                                <div class="col-sm-9">
                                    <p class="font-weight-normal">{{ $product_sale->updated_at }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('product_sales.edit', ['product_sale' => $product_sale->id]) }}"
                               class="btn btn-link float-left text-link my-auto">
                                Edit Details
                            </a>

                            <form method="post"
                                  action="{{ route('product_sales.delete', ['product_sale' => $product_sale]) }}">
                                @csrf
                                <button type="submit" class="btn btn-link text-link text-danger float-right">
                                    Delete Product Sale
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
