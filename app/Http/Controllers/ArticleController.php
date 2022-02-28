<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    Article,
    Category
};

use Illuminate\Support\Facades\Auth;
use LaravelEmojiOne;
use App\Http\Requests\ArticleRequest;

use Str;

class ArticleController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except('index', 'show');
    }

    protected int $perPage = 5;

    public function index() // Liste des articles
    {
        $articles = Article::orderBy('id','desc')->paginate($this->perPage);

        $data = [
            'title' => 'Les articles de '.config('app.name'),
            'description' => 'Retrouvez tous les articles de '.config('app.name'),
            'articles' => $articles,
        ];

        return view('article.index', $data);

        //$articles = Article::findOrFail(10);
        //$articles = Article::orderByDesc('id')->take(15)->get();
        //$articles = Article::orderByDesc('id')->skip(10)->take(15)->get();
        //$articles = Article::orderByDesc('id')->limit(15)->get();

        /* foreach($articles as $article) {
            dump($article->id." ".$article->title);
        } */
        //$count = Article::count();
        //dd($count);
        //dd($articles);
    }

    public function create() // Création d'article après authentification
    {
        $categories = Category::get();
        $articles = Article::all();

        /* foreach($articles as $article) {
            dump($article->category->name);
        }
        exit; */

        $data = [
            'title' => $description = 'Écrire un nouvel article - '.config('app.name'),
            'description' => $description,
            'categories' => $categories,
        ];

        return view('article.create', $data);
    }

    public function store(ArticleRequest $request) // Traiter les données et les enregistrer en DB
    {
        $validated_data = $request->validated();
        $validated_data['category_id'] = request('category', null);

        $subjects = array($validated_data['title'], $validated_data['content']);
        foreach($subjects as $subject) {
            if (preg_match('/(<script>|&lt;script&gt;)/', $subject)) {
                $error = 'Bien essayé, mais essaie encore !';
                return back()->withError($error);
            }
        }

        $validated_data['title'] = LaravelEmojiOne::toImage(request('title'));
        $validated_data['content'] = LaravelEmojiOne::toImage(request('content'));
        Auth::user()->articles()->create($validated_data);

        //return 'Sauvegarder le nouvel article';
        //dd(request()->all());
        //dump(Auth::id());
        //dd(auth()->id());

        // validation des données avant insertion
        /*$article = Auth::user()->articles()->create(request()->validate([
            'title' => ['required', 'min:3', 'max:191', 'unique:articles,title'],
            'content' => ['required'],
            'category' => ['sometimes', 'nullable', 'exists:categories,id'],
        ]));*/
           /* [
                'title.required' => 'y a pas de titre',
                'title.min' => 'c quoi ce titre trop court',
                'content.required' => 'y a pas de texte',
            ] */

        /*$article->category_id = request('category', null);
        $article->save();*/
        // insertion en DB
        /*$article = Article::create([
            'user_id' => auth()->id(),
            'title' => request('title'),
            'slug' => Str::slug(request('title')),
            'content' => request('content'),
            'category_id' => request('category', null),
        ]);*/

        /*$article = new Article;
        $article->user_id = Auth::id();
        $article->category_id = request('category', null);
        $article->title = ucfirst(request('title'));
        $article->slug = Str::Slug($article->title);
        $article->content = ucfirst(request('content'));
        $article->save();*/

        $success = 'Article enregistré.';

        return back()->withSuccess($success);
    }

    public function show(Article $article) // Afficher l'article
    {
        $data = [
            'title' => ucfirst($article->title).' - '.config('app.name'),
            'description' => ucfirst($article->title).' - '.Str::words($article->content, 10),
            'article' => $article,
            'comments' => $article->comments()->orderByDesc('created_at')->get(),
        ];

        return view('article.show', $data);
    }

    public function edit(Article $article) // Éditer l'article après authentification
    {
        abort_if(auth()->id() != $article->user_id, 403);

        $data = [
            'title' => $description = 'Mise à jour de '.$article->title,
            'description' => $description,
            'article' => $article,
            'categories' => Category::get(),
        ];

        return view('article.edit', $data);
    }

    public function update(ArticleRequest $request, Article $article) // Enregistrer l'article en DB
    {
        abort_if(auth()->id() != $article->user_id, 403);

        $validated_data = $request->validated();
        $validated_data['category_id'] = request('category', null);

        $subjects = array($validated_data['title'], $validated_data['content']);
        foreach($subjects as $subject) {
            abort_if(preg_match('/(<script>|&lt;script&gt;)/', $subject) == true, 403);
        }

        $article = Auth::user()->articles()->updateOrCreate(['id' => $article->id], $validated_data);

        $success = 'Article mis à jour';
        return redirect()->route('articles.edit', ['article' => $article->slug])->withSuccess($success);
    }

    public function destroy(Article $article) // Supprimer l'article après authentification
    {
        abort_if(auth()->id() != $article->user_id, 403);

        $article->delete(); // Supprimer l'article de la DB
        $success = 'Article supprimé';

        return back()->withSuccess($success);
    }
}
