<?php
    namespace App\Http\Middleware;

    use Closure;

    class CustomAuthMiddleware
    {
        public function handle($request, Closure $next)
        {
            // Validasi atau proses sesuai kebutuhan

            return $next($request);
        }
    }
