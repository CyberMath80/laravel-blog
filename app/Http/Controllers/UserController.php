<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;

use Nette\Schema\ValidationException;
use Storage, Image, Str, DB;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except('profile');
    }

    public function profile(User $user): string
    {
        //return 'Je suis un utilisateur et mon pseudo est '.$user->name;
        $articles = $user->articles()->withCount('comments')->orderBy('comments_count', 'desc')->paginate(5);
        //dump($articles);

        $data = [
            'title' => 'Profil de '.$user->name.' sur '.config('app.name'),
            'description' => $user->name.' est inscrit depuis le '.$user->created_at->isoFormat('LL').' et a posté '.$user->articles()->count().' articles.',
            'user' => $user,
            'articles' => $articles,
        ];

        // dd($data);
        return view('user.profile', $data);

    }

    public function edit() { // formulaire de mise à jour des infos de l'utilisateur connecté
        $user = auth()->user();

        $data = [
            'title' => $description = 'Éditer mon profil - '.config('app.name'),
            'description' => $description,
            'user' => $user,
        ];

        return view('user.edit', $data);
    }

    public function store() { // enregistrement des infos mises à jour
        //dd(request()->all());
        $user = auth()->user();

        DB::beginTransaction();

        try {
            $user = $user->updateOrCreate([
                'id' => $user->id
            ], request()->validate([
                'name' => ['required', 'min:1', 'max:191', Rule::unique('users')->ignore($user)],
                'email' => ['required', 'email', Rule::unique('users')->ignore($user)],
                'avatar' => ['sometimes', 'nullable', 'file', 'image', 'mimes:jpeg,jpg,png,gif', 'dimensions:min-width:200,min-height:200','max:1024']
            ]));

            if(request()->hasFile('avatar') && request()->file('avatar')->isValid()) {
                // echo 'avatar posté';

                if(Storage::exists('avatars/'.$user->id)) {
                    Storage::deleteDirectory('avatars/'.$user->id);
                }

                $ext = request()->file('avatar')->extension();
                $filename = Str::slug($user->name).'-'.$user->id.'.'.$ext;
                //dd($filename);
                $path = request()->file('avatar')->storeAs('avatars/'.$user->id, $filename);
                //dd($path);

                $thumbnailImage = Image::make(request()->file('avatar'))->fit(200, 200, function($constraint) {
                    $constraint->upsize();
                })->encode($ext, 50);

                $thumbnailPath = 'avatars/'.$user->id.'/thumbnail/'.$filename;
                Storage::put($thumbnailPath, $thumbnailImage);
                $user->avatar()->updateOrCreate(['user_id' => $user->id],
                    [
                        'filename' => $filename,
                        'url' => Storage::url($path),
                        'path' => $path,
                        'thumb_url' => Storage::url($thumbnailPath),
                        'thumb_path' => $thumbnailPath,
                    ]);
            } else {
                if(Storage::exists('avatars/'.$user->id)) {

                    $file = Storage::disk('public')->files('avatars/'.$user->id);
                    $thumbFile = Storage::disk('public')->files('avatars/'.$user->id.'/thumbnail');
                    //dump($file);

                    $dotPosFile = strpos($file[0],'.');

                    //dump('Le . est en '.$dotPos.' position');
                    $ext = substr($file[0], $dotPosFile + 1);
                    //dd($ext);

                    $filename = Str::slug($user->name).'-'.$user->id.'.'.$ext;
                    //dd($filename);

                    Storage::move($file[0], 'avatars/' . $user->id . '/' . $filename);
                    Storage::move($thumbFile[0], 'avatars/' . $user->id . '/thumbnail/' . $filename);

                    $path = 'avatars/'.$user->id.'/'.$filename;
                    $thumbnailPath = 'avatars/'.$user->id.'/thumbnail/'.$filename;

                    $user->avatar()->updateOrCreate(['user_id' => $user->id], [
                        'filename' => $filename,
                        'url' => Storage::url($path),
                        'path' => $path,
                        'thumb_url' => Storage::url($thumbnailPath),
                        'thumb_path' => $thumbnailPath,
                    ]);
                }
            }
        }
        catch(ValidationException $e) {
            DB::rollBack();
            dd($e->getErrors());
        }

        DB::commit();

        $success = 'Profil mis à jour';

        return back()->withSuccess($success);
    }

    public function password() { // formulaire de changement de mot de passe
        $user = auth()->user();

        $data = [
            'title' => $description = 'Modifier mon mot de passe - '.config('app.name'),
            'description' => $description,
            'user' => $user,
        ];

        return view('user.password', $data);
    }

    public function updatePassword() { // enregistrement du nouveau mot de passe
        $user = auth()->user();

        request()->validate([
            'current' => 'required|password',
            'password' => 'required|between:10,30|confirmed',
        ]);

        $user->password = bcrypt(request('password'));
        $user->save();

        $success = 'Nouveau mot de passe mis à jour';

        return back()->withSuccess($success);
    }

    public function destroy(User $user) { // suppression du compte utilisateur
        abort_if($user->id != auth()->id(), 403);
        Storage::deleteDirectory('avatars/'.$user->id);
        $user->delete();

        $success = 'Votre compte a été supprimé.';

        return redirect('/')->withSuccess($success);
    }
}
