<span class="text-body">
    <b>Branch:</b> {{ $input['branch_name'] ?? 'All Branches' }}</span><br>
<span class="text-body">
    <b>From Date:</b> {{ $input['date_from'] ?? '—' }}</span><br>
<span class="text-body">
    <b>To Date:</b> {{ $input['date_to'] ?? '—' }}</span><br><br>

<table width="100%" cellspacing="0" cellpadding="2">
    <thead>
    <tr class="text-body" style="text-align: left !important;">
        <th>Item Name</th>
        <th>Movement Type</th>
        <th>Quantity</th>
        <th>Running Quantity</th>
        <th>Transaction Date</th>
    </tr>
    </thead>

    <tbody>
    @if ($detail_collection->count() > 0)
        @foreach($detail_collection as $product_type => $detail)
            <tr class="text-body" style="background-color: black; color: white;">
                <td colspan="5"> {{ $product_type }}</td>
            </tr>

            @foreach ($detail as $product_name => $product_movements)
                <tr class="text-body">
                    <td style="padding-left: 25px"> {{ $product_name }} </td>
                </tr>

                @foreach ($product_movements as $movement)
                    <tr class="text-body">
                        <td></td>
                        <td> {{ $movement->movement_type }} </td>
                        <td> {{ $movement->quantity }} </td>
                        <td> {{ $movement->r_quantity }} </td>
                        <td> {{ $movement->created_at }} </td>
                    </tr>
                @endforeach

            @endforeach

        @endforeach
    @else
        <tr class="text-body">
            <td>No results found</td>
        </tr>
    @endif

    </tbody>
    <tfoot>
</table>
