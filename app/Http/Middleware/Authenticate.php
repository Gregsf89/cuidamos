<?php

namespace App\Http\Middleware;

use Closure;
use Error;
use Exception;
use App\Helpers\JwtHelper;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use App\Repositories\AccountRepository;
use App\Repositories\UserRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param mixed ...$guards
     * @return mixed
     * @throws HttpException
     * @throws NotFoundHttpException|Exception
     */
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $token = $request->bearerToken();
            if (empty($token)) {
                throw new NotFoundHttpException('token_not_found');
            }
            $tokenInfo = JwtHelper::decodeToken($token);

            $account = AccountRepository::getByUid($tokenInfo->sub);
            auth()->setUser($account);

            $request->setUserResolver(function () use ($account) {
                return $account;
            });
        } catch (Exception | Error $e) {
            if ($e instanceof NotFoundHttpException) {
                abort(401, 'token_not_found');
            }
            abort(401, 'invalid_token');
        }
        return $next($request);
    }
}
