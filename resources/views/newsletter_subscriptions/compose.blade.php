@extends('layouts.admin.app')

@section('header_left')
    <h6 class="h2 text-white d-inline-block mb-0">
        NEWSLETTER SUBSCRIPTIONS
    </h6>
    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span class="ml-2"> Dashboard </span>
                </a>
            </li>
            <li class="breadcrumb-item text-gray">Compose Newsletter</li>
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
                                <div class="form-group">
                                    <label class="form-control-label" for="subject">
                                        Mail Subject
                                    </label>
                                    <input type="text" class="form-control" id="subject" name="subject">
                                </div>

                                <div class="form-group">
                                    <label class="form-control-label" for="message">
                                        Message / Content
                                    </label>
                                    <textarea type="text" class="form-control" id="message" name="message"></textarea>
                                </div>

                                <button class="btn btn-primary btn-block mt-4 w-50" type="submit">
                                    Send to Subscribers
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
