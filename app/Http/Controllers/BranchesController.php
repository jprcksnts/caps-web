<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Core\Branch\BranchController;
use App\Models\Branch\Branch;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;

class BranchesController extends Controller
{
    public function index()
    {
        $table_headers = ['id', 'code', 'name', 'address', 'city', 'updated at', ''];
        return view('branches.index', compact('table_headers'));
    }

    public function create()
    {
        $form_action = [
            'page_title' => 'Create New Branch',
            'route' => route('branches.store')
        ];
        return view('branches.form', compact('form_action'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $response = BranchController::create($input['code'], $input['name'], $input['address'], $input['city']);
        $status = ($response['status_code'] == Response::HTTP_OK) ? 'success' : 'error';

        return redirect(route('branches.index'))
            ->with($status, $response['message']);
    }

    public function edit(Branch $branch)
    {
        $form_action = [
            'page_title' => 'Update Branch ID #' . $branch->id,
            'route' => route('branches.update', ['branch' => $branch->id]),
        ];

        return view('branches.form', compact('form_action', 'branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $input = $request->all();
        $response = BranchController::update($branch->id, $input['code'], $input['name'], $input['address'], $input['city']);
        $status = ($response['status_code'] == Response::HTTP_OK) ? 'success' : 'error';

        return redirect(route('branches.show', ['branch' => $branch->id]))
            ->with($status, $response['message']);
    }

    public function show(Branch $branch)
    {
        return view('branches.show', compact('branch'));
    }

    public function retrieveList()
    {
        $branches = Branch::query();

        return DataTables::eloquent($branches)
            ->addColumn('action_column', function ($branch) {
                $route = route('branches.show', ['branch' => $branch->id]);
                return '<a href="' . $route . '" class="table-action"><i class="fas fa-chevron-right"></i></a>';
            })
            ->rawColumns(['action_column'])
            ->toJson();
    }
}
