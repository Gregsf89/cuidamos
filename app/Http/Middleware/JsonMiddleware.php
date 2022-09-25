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
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $return = [
            'data' => null,
            'error' => null
        ];
        $response = $next($request);
        if (preg_match("~^2\d+$~", $response->original['code'])) {
            $return['data'] = $response->original;
        } else if (!empty($response->original['error']['code']) && isset($response->original['error']['message'])) {
            $return['error'] = $response->original['error'];
        } else {
            $return['error'] = $response->original;
        }

        return response()->json($return, $response->getStatusCode());
    }
}
