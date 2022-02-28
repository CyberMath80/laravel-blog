@extends('layouts.main')
@section('content')
            <div class="row">
                <div class="col-lg-3">
                    @include('includes.sidebar')
                </div> <!-- /.col-lg-3 -->
                <div class="col-lg-9">
@if(session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif
                    <div class="card mt-4">
                        <div class="card-body">
                            <h1 class="card-title">{{ ucfirst($article->title) }}</h1>
                            <p class="card-text">{{ ucfirst($article->content) }}</p>
                            <span class="time">Article posté le {{ $article->created_at->isoFormat('LL') }} à {{  $article->created_at->format('H:i:s') }}</span> <br>
                            <span class="auhtor">Par <a href="{{ route('user.profile', ['user' => $article->user->id]) }}">{{ $article->user->name }}</a> (membre inscrit le {{ $article->user->created_at->isoFormat('LL') }})</span>
                        </div> <!-- /.card-body -->
                    </div> <!-- /.card .articles-list -->
                    <div class="card card-outline-secondary my-4">
                        <div class="card-header">Commentaires</div> <!-- /.card-header -->
                        <div class="card-body">
@forelse($comments as $comment)
                            <p>{{ ucfirst($comment->content) }}</p>
                            <small class="text-muted">Commentaire posté par <a href="{{ route('user.profile', ['user' => $comment->user->id]) }}">{{ ucfirst($comment->user->name) }}</a> le {{ $comment->created_at->isoFormat('LL') }} à {{  $comment->created_at->format('H:i:s') }}</small>
                            <hr>
@empty
                            <p>Il n'y a pas encore de commentaire pour l'instant</p>
@endforelse
@auth
                            <form action="{{ route('post.comment', ['article' => $article->slug]) }}" method="post">
                                @csrf
                                @php echo "\n"; @endphp
                                <div class="form-group mb-3">
                                    <label for="content" class="form-label">Laisser un commentaire</label>
                                    <textarea name="content" id="content" class="form-control" cols="30" rows="5" placeholder="Écrire votre commentaire ici">{{ old('content') }}</textarea>
@error('content')
                                    <div class="error">{{ $message }}</div>
@enderror
                                </div>
                                <button type="submit" class="btn btn-success">Poster mon commentaire</button>
                            </form>
@endauth
@guest
                            <a href="{{ route('login') }}" class="btn btn-success">Laisser un commentaire</a>
@endguest
                        </div> <!-- /.card-body -->
                    </div>
                </div> <!-- /.col-lg-9 -->
            </div> <!-- /.row -->
@stop
