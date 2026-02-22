<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Ambil role user dari relasi atau langsung dari kolom 'role'
        $user = auth()->user();

        if (!$user) {
            abort(Response::HTTP_FORBIDDEN, 'Akses ditolak: Anda belum login.');
        }

        // Normalisasi nama role agar tidak masalah dengan spasi atau kapital
        $userRole = strtolower(trim($user->role->name ?? $user->role ?? ''));

        // Normalisasi juga daftar role yang diizinkan
        $roles = array_map(fn($r) => strtolower(trim($r)), $roles);

        // Debug opsional (hapus kalau sudah tidak perlu)
        // dd($userRole, $roles);

        if (!in_array($userRole, $roles)) {
            abort(Response::HTTP_FORBIDDEN, 'Akses ditolak: Anda tidak memiliki hak untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
