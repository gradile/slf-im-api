<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $r)
    {
        $data = $r->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => 'required|string|min:8',
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email'=> $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        return response()->json(['message' => 'Registered'], 201);
    }
}
