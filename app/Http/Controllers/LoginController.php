<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct() {
        $this ->middleware('guest');
    }

    public function index() { // formulaire de login
        $data = [
            'title' => config('app.name').' - Login',
            'description' => 'Connexion à votre compte '.config('app.name'),
        ];

        return view('auth.login', $data);
    }

    public function login() { // traiter les données du formulaire
        //dd(request()->all());
        request()->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //dd(request()->has('remember'));
        $remember = request()->has('remember');

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')], $remember)) {
            //dd(Auth::user());
            return redirect('/');
        }

        return back()->withError('Mauvais identifiants.')->withInput();
    }
}
