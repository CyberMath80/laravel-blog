<?php

use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\UserController; // syntaxe pour un contrôleur
use App\Http\Controllers\{
    UserController,
    ArticleController,
    RegisterController,
    LoginController,
    LogoutController,
    ForgotController,
    ResetPasswordController,
    CommentController,
    CategoryController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*

Route::get('/', function() {
    return view('welcome');
});

Route::get('/test', function() {
    return view('test');
});

Route::get('/test2', function() {
    return view('test2')->withTitle('PHP');;
});

Route::get('/structures', function() {
    $voitures = ['Mercedes', 'BMW', 'Ford', 'Fiat', 'Skoda'];
    $fruits = ['pomme', 'poire', 'cerise', 'banane'];
    $data = [
        'number' => 2,
        'voitures' => $voitures,
        // 'fruits' => [],
        'fruits' => $fruits
    return view('structures', $data);
});


Route::get('user/{username}', function($username) {
    return 'Bonjour '.$username;
}); // Route avec paramètre d'url
Route::get('register/{name?}', function($name = null) {
    if($name)
        echo 'Bonjour '.$name;
    else
        echo 'Bonjour visiteur !';
}); // Route avec paramètre optionnel : ? dans l'url...
Route::get('articles', function() {
    $articles = ['Article C', 'Article A', 'Article B'];

    // dd = dump die = var_dump() stop...
    // dd($articles);  // n'exécute pas la suite du script
    // dump($articles); // exécute la suite du script
    echo 'Bonjour!';
    $sort = request()->query('sort', 'desc');
    // dd($sort);

    switch($sort) {
        case 'desc':
            rsort($articles);
            break;
        case 'asc':
            sort($articles);
            break;
        default:
            break;
    }

    foreach($articles as $article) {
        echo "<p>$article</p>";
    }
}); // Route avec paramètre query string : ? dans l'url...
*/ // TEST 1 : apprendre les routes
/*
Route::get('test', function() {
    return view('test.index');  // first.second -> first = folder / second = file
}); // Route qui retourne une vue
Route::get('userprofile/{firstname?}/{lastname?}', function($firstname = null, $lastname = null) {
    //return view('profile.index')->with('firstname', $firstname)->with('lastname', $lastname);
    //return view('profile.index')->with(compact('firstname', 'lastname'));
    //return view('profile.index')->withFirstname($firstname)->withLastname($lastname);
    $data = [
        'title'       => 'Mon Super titre',
        'description' => 'Ma description fatale',
        'firstname'   => $firstname,
        'lastname'    => $lastname
    ];
    return view('profile.index', $data);
}); // Passer des paramètres d'url à une vue (segments d'url utilisés pour SEO: titre d'article, etc).
Route::get('test2', function() {
    $firstname = request()->query('firstname', null);
    $lastname = request()->query('lastname', null);
    $data = [
        'title'       => 'Page de '.$firstname,
        'description' => 'Description de '.$firstname.' '.$lastname,
        'firstname'   => $firstname,
        'lastname'    => $lastname
    ];
    return view('test.index2', $data);
}); // Passer des paramètres query string (paramètres get utilisés pour le tri).
*/ // TEST 2 : apprendre les vues

// TEST 3 : apprendre les contrôleurs
Route::get('/', [ArticleController::class, 'index']);
Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::get('login', [LoginController::class, 'index'])->name('login');
Route::get('logout', [LogoutController::class, 'logout'])->name('logout');
Route::get('forgot', [ForgotController::class, 'index'])->name('forgot');

Route::post('comment/{article}', [CommentController::class, 'store'])->name('post.comment');
Route::get('category/{category}', [CategoryController::class, 'show'])->name('category.show');

Route::get('reset/{token}', [ResetPasswordController::class, 'index'])->name('reset');
Route::post('reset', [ResetPasswordController::class, 'reset'])->name('post.reset');

Route::post('register', [RegisterController::class,'register'])->name('post.register');
Route::post('login', [LoginController::class, 'login'])->name('post.login');
Route::post('forgot', [ForgotController::class, 'store'])->name('post.forgot');

Route::get('profile/{user}', [UserController::class, 'profile'])->name('user.profile'); // Lier un contrôleur à sa route
Route::get('user/edit', [UserController::class, 'edit'])->name('user.edit');
Route::post('user/store', [UserController::class, 'store'])->name('post.user');
Route::get('user/password', [UserController::class, 'password'])->name('user.password');
Route::post('post/password', [UserController::class, 'updatePassword'])->name('update.password');
Route::delete('destroy/{user}', [UserController::class, 'destroy'])->name('user.destroy');

Route::resource('articles', ArticleController::class)->except('index');
