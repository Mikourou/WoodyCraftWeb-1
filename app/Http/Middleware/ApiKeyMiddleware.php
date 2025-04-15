<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY'); // Récupère la clé depuis les headers
        $validApiKey = config('app.api_key'); // Récupère la clé API définie dans .env

        if ($apiKey !== $validApiKey) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
