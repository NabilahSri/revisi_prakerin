<?php

namespace App\Http\Middleware;

use App\Models\LogAktivitas;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogDeleteActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            LogAktivitas::create([
                'username' => $user->username,
                'level' => $user->level,
                'aktivitas' => 'hapus',
                'waktu' => Carbon::now()->timezone('Asia/Jakarta')
            ]);
        }
        return $next($request);
    }
}
