<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //

    public function index()
    {
        return User::all();
    }


    public function show(Product $user)
    {
        return User::find($id);
    }

    
    public function createUser($userName, $email, $password, $deposit , $role)
    {
        
        $result = User::createUser($userName, $email, $password, $deposit, $role);
        
        return response()->json($result, 200);
    }
}
