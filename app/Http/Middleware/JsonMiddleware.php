<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JsonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $return = [
            'data' => null,
            'error' => null
        ];

        $response = $next($request);
        if (!empty($response->original['code']) && isset($response->original['message'])) {
            $return['error'] = $response->original;
        } else if (!empty($response->original['error']['code']) && isset($response->original['error']['message'])) {
            $return['error'] = $response->original['error'];
        } else {
            $return['data'] = $response->original;
        }

        return response()->json($return, $response->getStatusCode());
    }
}
