<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek jika belum login
        if (!$request->user()) {
            return redirect()->route('login')
                ->withErrors(['Silakan login terlebih dahulu.']);
        }

        $userRole = $request->user()->role->name;

        // 2. Ambil role user & ubah ke huruf kecil
        $userRole = strtolower($request->user()->role->name ?? '');
        $roles = array_map('strtolower', $roles);

        // 3. Cek apakah role sesuai
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized');
        }

        // 4. Lanjutkan request (PENTING biar gak merah & gak 403)
        return $next($request);
    }
}
