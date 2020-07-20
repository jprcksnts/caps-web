<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <title> {{ $report_details['title'] }} </title>

    <style>
        .title {
            font-size: 20px !important;
            padding: 0px !important;
            font-weight: bold;
            display: block;
        }

        .document-title {
            font-size: 16px !important;
            font-weight: bold;
            display: block;
        }

        .sub-title-small {
            font-size: 12px !important;
            display: block;
        }

        .sub-title-date {
            font-size: 10px !important;
        }

        .sub-title {
            font-size: 12px !important;
            display: block;
        }

        .uppercase {
            text-transform: uppercase !important;
        }

        .mg-btm-10 {
            margin-bottom: 10px;
        }

        .mg-btm-15 {
            margin-bottom: 15px;
        }

        .text-body {
            font-size: 10px !important;
        }

        th, td {
            vertical-align: top;
        }

        .table-border {
            border-bottom: 1px solid black;
            border-top: 1px solid black;
        }

        .table-border-bottom {
            border-bottom: 1px solid black;
        }

        .align-right {
            text-align: right !important;
        }
    </style>
</head>

<body>
{{-- Logo Header --}}
<div id="print-header" class="mg-btm-15">
    <table width="100%">
        <tbody>
        <tr>
            <td width="30%"></td>
            <td class="align-right" width="70%">
                <span class="title"> CAPS WEB </span>
                <span class="sub-title"><b> {{ strtoupper($report_details['title']) }} </b></span>
                <span class="sub-title-date"> Date Generated: {{ $date_printed }} </span>
            </td>
        </tr>
        </tbody>
    </table>
</div>

@if ($report_details['report'] == 'stock_movement')
    @include('reports.exports.stock_movement_print')
@endif

</body>

</html>
