<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(UserRequest $request)
    {
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->email;
        $password = $request->password;
        $type = $request->type;
        $user = User::create(['first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'password' => Hash::make($password), 'type' => $type]);

        return $user->toJson();
    }
}
