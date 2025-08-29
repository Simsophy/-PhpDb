<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Translate
{
    public function handle(Request $request, Closure $next): Response
    {
        $lang = 'en';
        $supported = ['en','km'];

        if ($request->session()->has('locale') && in_array($request->session()->get('locale'), $supported)) {
            $lang = $request->session()->get('locale');
        }

        return $next($request);
    }
}
