<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (session('user_role') !== 'admin') {
            return redirect()->route('produk')->with('error', 'Hanya admin yang bisa mengakses dashboard!');
        }
        return $next($request);
    }
}
