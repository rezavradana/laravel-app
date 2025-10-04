<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check jika user terauthentikasi dan memiliki role admin
        if (auth()->check() && auth()->user()->role === 'Admin') {
            return $next($request);
        }

        // Redirect atau abort jika bukan admin
        return redirect('/')->with('error', 'Akses ditolak. Hanya admin yang dapat mengakses fitur ini.');
        
        // Atau bisa menggunakan abort untuk menampilkan error page
        // abort(403, 'Akses ditolak. Hanya admin yang dapat mengakses fitur ini.');
    }
}
