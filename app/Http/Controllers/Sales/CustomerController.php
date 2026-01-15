<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function __construct()
    {
        View::share('active', 'customer');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $customer= DB::table('customers')->where('active', 1);

            return DataTables::of($customer)
                ->addIndexColumn() // Adds DT_RowIndex
                
                ->addColumn('action', function($row) {
                    $edit = route('customer.edit', $row->id);
                    $delete = route('customer.delete', $row->id);
                   $btn = "
    <a href='{$edit}' class='btn btn-success btn-sm'>
        <i class='fas fa-edit'></i>
    </a>
    <a href='{$delete}' class='btn btn-danger btn-xs' onclick='return confirm(\"Are you sure you want to delete?\")'>
        <i class='fas fa-trash'></i>
    </a>
";

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('sales.customer.index');
    }
    public function create()
{
    // return a view for creating a customer
    return view('sales.customer.create');
}
public function edit($id)
{
    // Fetch the customer from DB
    $customer = \DB::table('customers')->where('id', $id)->first();

    if (!$customer) {
        return redirect()->route('customer.index')->with('error', 'Customer not found.');
    }

    // Return the edit view
    return view('sales.customer.edit', compact('customer'));
}
public function update(Request $request, $id)
{
    // Validate input
    $request->validate([
        'name' => 'required|string|max:255',
 
    ]);

    // Update customer in DB
    \DB::table('customers')->where('id', $id)->update([
        'name' => $request->name,
       
        'updated_at' => now(),
    ]);

    return redirect()->route('customer.index')->with('success', 'Customer updated successfully.');
}
public function save(Request $request)
{
    // Validate input
    $request->validate([
        'name'    => 'required|string|max:255',
        'gender'  => 'required|string|max:10',
        'phone'   => 'required|string|max:20',
        'address' => 'required|string|max:255',
    ]);

    // Insert into DB
    \DB::table('customers')->insert([
        'name'       => $request->name,
        'gender'     => $request->gender,
        'phone'      => $request->phone,
        'address'    => $request->address,
        'active'     => 1,
        'updated_at' => now()

    ]);

    return redirect()->route('customer.index')->with('success', 'Customer created successfully.');
}

}
