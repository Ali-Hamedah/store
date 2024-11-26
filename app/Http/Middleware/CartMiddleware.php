<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CartMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!auth()->check()) {
            // إذا لم يكن المستخدم مسجلاً الدخول، استخدم cookie_id
            if (!$request->session()->has('cookie_id')) {
                $request->session()->put('cookie_id', (string) \Illuminate\Support\Str::uuid());
            }
        }

        return $next($request);
    }
}
