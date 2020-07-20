<?php

namespace App\Http\Controllers;

use App\Models\Branch\Branch;
use App\Models\Inventory\InventoryMovement;
use App\Models\Product\Product;
use App\Models\Product\ProductOrder;
use App\Models\Product\ProductSale;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        $branches = Branch::all();
        return view('reports.index', compact('branches'));
    }

    public function generate(Request $request)
    {
        $input = $request->all();

        /* Date Validations */
        if ($input['date_from'] && $input['date_to']) {
            $from_date = Carbon::createFromFormat('m/d/Y', $input['date_from'])->format('Y-m-d');
            $to_date = Carbon::createFromFormat('m/d/Y', $input['date_to'])->format('Y-m-d');

            if ($from_date > $to_date) {
                $message = 'Please check your date field values.';
                return redirect()->route('reports.index')->with('error', $message);
            }
        } else {
            $from_date = null;
            $to_date = null;
        }

        $detail_collection = $this->reportsQuery($input, $from_date, $to_date);
        $date_printed = Carbon::now();
        $report_details = [
            'report' => 'stock_movement',
            'title' => 'Stock Movement Report',
        ];

        $input['branch_name'] = Branch::find($input['branch_id'])->name;

        $print = PDF::loadView('reports.reports_main', compact('input', 'report_details', 'date_printed',
            'detail_collection'))
            ->setPaper('a4', 'portrait');

        return $print->stream($report_details['report'] . '_' . Carbon::now()->format('YmdHis') . '.pdf');
    }

    public function reportsQuery($input, $from_date, $to_date)
    {
        $inventory_movements = DB::table('inventory_movements')
            ->when($from_date != null && $to_date != null, function ($query) use ($from_date, $to_date) {
                return $query->whereBetween('inventory_movements.created_at', [$from_date, $to_date]);
            })
            ->orderBy('inventory_movements.created_at', 'desc')
            ->get();

        foreach ($inventory_movements as $key => $inventory_movement) {

            $transaction = collect();
            if ($inventory_movement->type == InventoryMovement::$order) {
                $transaction = ProductOrder::find($inventory_movement->tx_id);
                $inventory_movement->movement_type = 'Product Order';

            } else if ($inventory_movement->type == InventoryMovement::$sale) {
                $transaction = ProductSale::find($inventory_movement->tx_id);
                $inventory_movement->movement_type = 'Product Sale';
            }

            if ($transaction->branch_id == $input['branch_id']) {
                $product = Product::find($transaction->product_id);
                $branch = Branch::find($transaction->branch_id);

                $inventory_movement->branch_name = $branch->name;
                $inventory_movement->product_name = $product->name;
                $inventory_movement->product_type = $product->productType->type;

            } else {
                $inventory_movements->forget($key);
            }
        }

        return $inventory_movements->groupBy(['product_type', 'product_name']);
    }
}
