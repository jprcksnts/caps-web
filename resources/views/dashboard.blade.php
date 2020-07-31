@extends('layouts.admin.app')

@section('header_left')
    <h6 class="h2 text-white d-inline-block mb-0">
        DASHBOARD
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
    <div class="col">
        <div class="row">
            <div class="col-12">
                <div class="card-wrapper">
                    @include('shared.flash_messages')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0 font-weight-900">Products below re-order points</h3>
                        </div>
                        <div class="table-responsive py-3">
                            <table class="table table-flush table-hover" id="datatable-list" width="100%">
                                <thead class="thead-light">
                                <tr>
                                    @foreach ($table_headers as $header)
                                        <th> {{ strtoupper($header) }} </th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                {{-- Render data list from DataTables --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('styles')
    @include('shared.datatables_css')
@stop

@section('scripts')
    @include('shared.datatables_js')
    <script>
        var DatatableList = (function () {

            var $dtList = $('#datatable-list')

            function init($this) {
                var ajax_url = '/retrieve_list/product_reorder_points'
                var buttons = ["copy", "csv"];
                var options = {
                    bDestroy: true,
                    bAutoWidth: true,
                    lengthChange: true,
                    pageLength: 10,
                    buttons: buttons,
                    language: {
                        paginate: {
                            previous: "<i class='fas fa-angle-left'>",
                            next: "<i class='fas fa-angle-right'>"
                        }
                    },
                    ajax: {
                        "url": ajax_url,
                        "dataType": "json",
                        "type": "GET",
                        "data": {_token: "{{ csrf_token() }}"}
                    },
                    columns: [
                        {data: 'code', name: 'code'},
                        {data: 'name', name: 'name'},
                        {data: 'quantity', name: 'quantity'},
                        {data: 'reorder_point', name: 'reorder_point'},
                    ],
                }

                var table = $this.on('init.dt', function () {
                    $('div.dataTables_length select').removeClass('custom-select custom-select-sm');
                }).DataTable(options)
            }

            if ($dtList.length) {
                init($dtList);
            }
        })()
    </script>
@stop
