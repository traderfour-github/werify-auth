<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Trusted\GetUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class TrustedRoutesController extends Controller
{
    public  function  getUser(GetUserRequest $request)
	{
		return User::where('uuid',$request->hash)->firstOrFail();
	}
}
