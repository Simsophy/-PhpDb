<?php

namespace App\Http\Middleware;
namespace App\Http\Controllers;
use \App\Http\Middleware\Translate;
use Auth;
use Illuminate\Http\Request;
use View;
use DB;
class ExchangeController extends Controller
{
public function __construct()
 {
    $this->middleware(function ($request,$next){
            app()->setLocale(Auth::user()->lang);
             return $next($request);
    });
   

    View::share('active', 'exchange');
   
}

 public function index()
{
    $data['exchange'] = DB::table('exchanges')->where('active', 1)->get();
    $data['olds'] = DB::table('exchanges')->where('active', 0)->get(); // <-- fixed
    return view('exchanges.index', $data);
}

    
}
