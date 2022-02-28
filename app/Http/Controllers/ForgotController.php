<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\PasswordResetNotification;
use App\Models\User;
use Str, DB;

class ForgotController extends Controller
{
    public function __construct() {
        $this ->middleware('guest');
    }

    public function index() { //formulaire d'oubli
        $data = [
            'title' => $description = 'Oubli du mot de passe - '.config('app.name'),
            'description' => $description,
        ];

        return view('auth.forgot', $data);
    }

    public function store() { //vérification des datas et envoi du lien de réinitialisation du mot de passe
        request()->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::uuid();

        DB::table('password_resets')->insert([
            'email' => request('email'),
            'token' => $token,
            'created_at' => now(),
        ]);

        // Envoi de la notification
        $user = User::whereEmail(request('email'))->firstOrFail();
        $user->notify(new PasswordResetNotification($token));
        $success = 'Vérifiez votre boîte email et suivez les instructions contenues dans l\'email.';

        return back()->withSuccess($success);
    }
}
