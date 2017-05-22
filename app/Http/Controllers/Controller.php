<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpFoundation\Request;
use Tymon\JWTAuth\JWTAuth;
//use \Firebase\JWT\JWT;
//use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	/**
	 * @var JWTAuth
	 */
	protected $auth;
	/**
	 * @var
	 */
	public $token;
	/**
	 * @var Request
	 */
	protected $credentials;

	public function __construct(JWTAuth $auth, Request $credentials)
	{
		$this->auth = $auth;
		$this->credentials = $credentials->only('email', 'password');
	}


	protected function getJWT()
	{
		return $this->auth->attempt($this->credentials);
	}

//	protected function getJWT()
//	{
//		$payload = array(
//			'iss' => env('ISS'),
//			'exp' => Carbon::now()->addMinutes(3)->format(\DateTime::ISO8601),
//			'company' => env('COMPANY')
//		);
//
//		$jwt = JWT::encode($payload, env('APP_KEY'), 'HS256', null, null);
//
//		return $jwt;
//	}

}
