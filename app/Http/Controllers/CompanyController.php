<?php

namespace App\Http\Middleware;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    
        public function __construct()
{

        View::share('active', 'company');
    }

 public function index()
{
    if(!check('company','list')){
       return view ('permissions.no');
     }
        
    $data['companies'] = DB::table('companies')->get();
    return view('companies.index', $data);
}
public function edit()
{
   $company = DB::table('companies')->find(1);
   return view('companies.edit', ['company' => $company]);
}




public function update(Request $r)
{
    $r->validate([
        'name' => 'required|min:3'
    ]);

    $data = [
        'name' => $r->name,
        'phone' => $r->phone,
        'email' => $r->email,
        'address' => $r->address,
        'website' => $r->website,
        'vattin' => $r->vattin,
        'map_url' => $r->map_url, // ✅ fixed here
        'description' => $r->description,
    ];

    if ($r->logo) {
        $data['logo'] = $r->file('logo')->store('uploads/companies/', 'custom_disk_name');
    }

    $x = DB::table('companies')
        ->where('id', 1)
        ->update($data);

    if ($x) {
        return redirect()->route('company.index')
            ->with('success', config('app.success'));
    } else {
        return redirect()->route('company.edit')
            ->with('fail', config('app.fail'));
    }
}

}

