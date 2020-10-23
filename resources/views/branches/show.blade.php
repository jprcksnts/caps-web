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
    <a href="{{ route('branches.index') }}" class="btn btn-md btn-neutral text-dark">
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
                            <h3 class="mb-0 font-weight-900">Branch Detail</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{-- ID --}}
                                <div class="col-sm-3">
                                    <small class="text-uppercase text-muted font-weight-bold">ID #</small>
                                </div>
                                <div class="col-sm-9">
                                    <p class="font-weight-normal">{{ $branch->id }}</p>
                                </div>
                                {{-- Branch Code --}}
                                <div class="col-sm-3">
                                    <small class="text-uppercase text-muted font-weight-bold">Branch Code</small>
                                </div>
                                <div class="col-sm-9">
                                    <p class="font-weight-normal">{{ $branch->code }}</p>
                                </div>
                                {{-- Branch Name --}}
                                <div class="col-sm-3">
                                    <small class="text-uppercase text-muted font-weight-bold">Branch Name</small>
                                </div>
                                <div class="col-sm-9">
                                    <p class="font-weight-normal">{{ $branch->name }}</p>
                                </div>
                                {{-- Address --}}
                                <div class="col-sm-3">
                                    <small class="text-uppercase text-muted font-weight-bold">Address</small>
                                </div>
                                <div class="col-sm-9">
                                    <p class="font-weight-normal">{{ $branch->address }}</p>
                                </div>
                                {{-- City --}}
                                <div class="col-sm-3">
                                    <small class="text-uppercase text-muted font-weight-bold">City</small>
                                </div>
                                <div class="col-sm-9">
                                    <p class="font-weight-normal">{{ $branch->city }}</p>
                                </div>
                                {{-- Created At --}}
                                <div class="col-sm-3">
                                    <small class="text-uppercase text-muted font-weight-bold">Created At</small>
                                </div>
                                <div class="col-sm-9">
                                    <p class="font-weight-normal">{{ $branch->created_at }}</p>
                                </div>
                                {{-- Updated At --}}
                                <div class="col-sm-3">
                                    <small class="text-uppercase text-muted font-weight-bold">Updated At</small>
                                </div>
                                <div class="col-sm-9">
                                    <p class="font-weight-normal">{{ $branch->updated_at }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('branches.edit', ['branch' => $branch->id]) }}"
                               class="btn btn-link float-left text-link my-auto">
                                Edit Details
                            </a>
                            <form method="post"
                                  action="{{ route('branches.delete', ['branch' => $branch]) }}">
                                @csrf
                                <button type="submit" class="btn btn-link text-link text-danger float-right">
                                    Delete Branch
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
