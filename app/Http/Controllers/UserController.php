<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), User::$rules);

        if ($validator->fails())
        {
            return response($validator->errors(), 409);

        }

        $parameters = $request->only(User::$parameters);

        if($request->exists('password') && $request->exists('password_confirmation'))
        {
            if($request->password != $request->password_confirmation)
            {
                return response(['password conflict'], 409);
            }else{
                $parameters['password'] = bcrypt($parameters['password']);
            }
        }

        return response()->json(User::create($parameters))->header('Authorization', 'Bearer '.$this->getJWT());
    }

	public function login(Request $request)
	{
        $validator = Validator::make($request->all(),
            [
                'email' => 'email|required',
                'password' => 'required'
            ]);

        if ($validator->fails())
        {
            return response($validator->errors(), 409);
        }

        if (\Auth::attempt($request->only('email', 'password'))) {
            return response()->json(\Auth::user())->header('Authorization', 'Bearer '.$this->getJWT());
        }else{
            return response(null, 404);
        }
	}

	public function logout()
	{
		$this->auth->parseToken()->invalidate();

		return response(null, 204);
	}

	public function current()
	{
		return response()->json(\Auth::user())->header('Authorization', 'Bearer '.$this->getJWT());
	}

	public function update(Request $request)
	{
		$request->only(['name', 'email', 'password']);

        $validator = Validator::make($request->all(),
            [
                'email' => 'unique:users|email'
            ]);

        if ($validator->fails())
        {
            return response($validator->errors(), 409);

        }

        $parameters = $request->except('password_confirmation');

        if($request->exists('password') && $request->exists('password_confirmation'))
        {
            if($request->password != $request->password_confirmation)
            {
                return response(['password conflict'], 409);
            }else{
                $parameters['password'] = bcrypt($request->passpassword);
            }
        }

        $user = User::findOrFail(\Auth::user()->id);

        $user->update($parameters);

		return response(null, 200);
	}
}
