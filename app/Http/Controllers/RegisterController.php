<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function __construct() {
        $this ->middleware('guest');
    }

    public function index() { // formulaire d'inscription
        $data = [
            'title' => 'Inscription - '.config('app.name'),
            'description' => 'Inscription sur '.config('app.name'),
        ];

        return view('auth.register', $data);
    }

    public function register(/*Request $request*/) { // traitement du formulaire d'inscription
        //dd(request()->all());
        request()->validate([
            'name' => 'required|min:3|max:191|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|between:10,30',
        ]);

        $user = new User;
        $user->name = request('name');
        $user->email = request('email');
        $user->password = bcrypt(request('password'));

        $user->save();

        $success = "Inscription réussie.";

        return back()->withSuccess($success);
    }
}
