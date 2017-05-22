<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWTAuth;

class Authentication
{
	protected $auth;

	public function __construct(JWTAuth $auth)
	{
		$this->auth = $auth;
	}

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		    try {

			    if (! $user = $this->auth->parseToken()->authenticate()) {
				    return response('User not found.', 404);
			    }

		    } catch (TokenExpiredException $e) {

			    return response('Token expired.', $e->getStatusCode());

		    } catch (TokenInvalidException $e) {

			    return response('Token invalid.', $e->getStatusCode());

		    } catch (JWTException $e) {

			    return response('Token absent.', $e->getStatusCode());
		    }

        return $next($request)
	        ->header('Access-Control-Allow-Origin', '*')
	        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}
