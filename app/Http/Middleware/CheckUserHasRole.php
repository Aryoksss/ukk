<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah user terautentikasi
        if (Auth::check()) {
            try {
                // Periksa apakah user memiliki role
                if (Auth::user()->roles->isEmpty()) {
                    // Jika akses ke Filament Admin Panel atau dashboard, redirect ke halaman peringatan
                    if ($request->is('admin*') || $request->is('dashboard')) {
                        // Jika belum ada pesan flashed, tambahkan
                        if (!session()->has('warning')) {
                            session()->flash('warning', 'Akun Anda belum mendapatkan peran. Anda tidak dapat mengakses dashboard atau fitur lainnya sampai administrator memberikan peran kepada Anda.');
                        }
                        
                        // Jika mencoba mengakses dashboard, alihkan ke halaman waiting
                        return redirect()->route('waiting-approval');
                    }
                }
            } catch (\Exception $e) {
                // Tangani kesalahan jika ada masalah dengan relasi roles
                // Ini dapat terjadi jika tabel roles belum dibuat atau migrasi belum dijalankan
                report($e);
                session()->flash('error', 'Terjadi kesalahan pada sistem. Silakan hubungi administrator.');
                return redirect()->route('waiting-approval');
            }
        }
        
        return $next($request);
    }
}
