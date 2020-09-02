@extends('layouts.admin.app')

@section('header_left')
    <h6 class="h2 text-white d-inline-block mb-0">
        REPORTS
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

@section('content')
    <div class="col-md-6">
        <div class="row">
            <div class="col">
                <div class="card-wrapper">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0 font-weight-900">Stock Movement - Report</h3>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('reports.generate') }}" role="form" id="form-data">
                                @csrf
                                <div class="form-group mb-2">
                                    <label class="form-control-label">Date From</label>
                                    <div class="input-group">
                                        <input class="form-control datepicker" placeholder="Select date"
                                               name="date_from" type="text">
                                    </div>
                                </div>

                                <div class="form-group mb-2">
                                    <label class="form-control-label">Date To</label>
                                    <div class="input-group">
                                        <input class="form-control datepicker" placeholder="Select date"
                                               name="date_to" type="text">
                                    </div>
                                </div>

                                <div class="form-group mb-2">
                                    <label class="form-control-label" for="branch_id">Branch</label>
                                    <select class="form-control" id="branch_id" name="branch_id">
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}" id="{{ $branch->id }}"
                                                    @if (isset($product_sale)) @if ($product_sale->branch_id == $branch->id)
                                                    selected @endif @endif>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <button class="btn btn-secondary mt-4 w-25" name="action" type="submit" value="pdf">
                                    Generate PDF
                                </button>
                                <button class="btn btn-primary mt-4 w-25" name="action" type="submit" value="excel">
                                    Export to Excel
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="{{ asset('vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
@stop
