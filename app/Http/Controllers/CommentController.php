<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Article,
    Comment
};

use App\Http\Requests\CommentRequest;
use App\Events\CommentWasCreated;

class CommentController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function store(CommentRequest $request, Article $article) {
        $validated_data = $request->validated();
        $validated_data['user_id'] = auth()->id();
        $comment = $article->comments()->create($validated_data);

        //dd($comment);
        if(auth()->id() != $article->user_id) { // Si le commentateur n'est pas l'auteur de l'article
            event(new CommentWasCreated($comment));
        }

        $success = 'Commentaire posté';

        return back()->withSuccess($success);
    }
}
