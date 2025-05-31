<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        
        // Cek jika user memiliki role siswa dan mencoba mengakses filament admin
        if ($request->is('admin*') && !Auth::user()->roles->contains('name', 'super_admin')) {
            session()->flash('warning', 'OWWW TIDAK BOLEEEE.');
            return redirect()->route('dashboard');
        }
        
        
        return $next($request);
    }
}
