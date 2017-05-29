<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

	public $primaryKey = 'id';

	protected $table = 'users';

    public static $rules = [
        'name' => 'required',
        'email' => 'unique:users|email|required',
        'password' => 'required',
    ];

	public static $parameters = [
        'name',
        'email',
        'password',
        'password_confirmation'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
	    'created_at',
	    'updated_at',
	    'deleted_at',
    ];
}
