@extends('layouts.admin.app')

@section('header_left')
    <h6 class="h2 text-white d-inline-block mb-0">
        BRANCHES
    </h6>
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span class="ml-2"> Dashboard </span>
                </a>
            </li>
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
                                        Branch Name
                                    </label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ $branch->name ?? old('name') }}">
                                </div>

                                <div class="form-group mb-2">
                                    <label class="form-control-label" for="address">
                                        Address
                                    </label>
                                    <input type="text" class="form-control" id="address" name="address"
                                           value="{{ $branch->address ?? old('address') }}">
                                </div>

                                <div class="form-group mb-2">
                                    <label class="form-control-label" for="city">
                                        City
                                    </label>
                                    <input type="text" class="form-control" id="city" name="city"
                                           value="{{ $branch->city ?? old('city') }}">
                                </div>

                                <button class="btn btn-primary btn-block mt-4 w-50" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
