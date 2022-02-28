<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;

class ResetPasswordController extends Controller
{
    public function __construct() {
        $this ->middleware('guest');
    }

    public function index(string $token) { // formulaire de réinitialisation de mot de passe
        $password_reset = DB::table('password_resets')->where('token', $token)->first();
        //dd($password_reset);

        abort_if(!$password_reset, 403);

        $data = [
            'title' => $description = 'Réinitialisation du mot de passe - '.config('app.name'),
            'description' => $description,
            'password_reset' => $password_reset,
        ];

        return view('auth.reset', $data);
    }

    public function reset() { // traiter le formulaire
        //dd(request()->all());
        request()->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|between:10,30|confirmed'
        ]);

        if(!DB::table('password_resets')
            ->where('email', request('email'))
            ->where('token', request('token'))
            ->count()) {
            $error = 'Vérifiez votre adresse email.';
            return back()->withError($error)->withInput();
        }

        $user = User::whereEmail(request('email'))->firstOrFail();
        //dd($user);

        $user->password = bcrypt(request('password'));
        $user->save();
        $success = 'Votre mot de passe a été mis à jour.';

        DB::table('password_resets')->where('email', request('email'))->delete();
        return redirect()->route('login')->withSuccess($success);
    }
}
