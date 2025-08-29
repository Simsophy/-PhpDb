<?php

namespace App\Http\Middleware;
namespace App\Http\Controllers;
use \App\Http\Middleware\Translate;
use View;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
 {
    $this->middleware(function ($request,$next){
            app()->setLocale(Auth::user()->language);
             return $next($request);
    });
    View::share('active','home');

    
 }


    public function index()
    {
        return view('home'); // Make sure you have resources/views/home.blade.php
    }
}
