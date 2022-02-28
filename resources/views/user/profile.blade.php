@extends('layouts.main')
@section('content')
            <div class="row">
                <div class="col-lg-3">
                    @include('includes.sidebar')
                </div> <!-- /.col-lg-3 -->
                <div class="col-lg-9">
                    <h1 class="text-muted">Profil de {{ $user->name }}</h1>
@if($user->avatar)
                    <div class="mb-3">
                        <a href="{{ $user->avatar->url }}" target="_blank">
                            <img class="avatar" src="{{ $user->avatar->thumb_url }}" alt="Avatar appartenant à {{ $user->name }}">
                        </a>
                    </div>
@endif
@forelse($articles as $article)
                    <div class="card mt-4 articles-list">
                        <div class="card-body">
                            <h2 class="card-title"><a href="{{ route('articles.show', ['article' => $article->slug]) }}"> {{ ucfirst($article->title) }}</a></h2>
                            <p class="card-text">{{ ucfirst(Str::limit($article->content, 75)) }}</p>
                            <span class="time">Article posté le {{ $article->created_at->isoFormat('LL') }} à {{  $article->created_at->format('H:i:s') }}</span> <br>
                            <span class="author">Par <a href="{{ route('user.profile', ['user' => $article->user->id]) }}">{{ ucfirst($article->user->name) }}</a> (membre inscrit le {{ $article->user->created_at->isoFormat('LL') }})</span>
                            <div class="text-right">{{ $article->comments_count  }} commentaire(s)</div>
@if(Auth::check() && Auth::user()->id == $article->user_id)
                                <div class="author">
                                    <a class="btn btn-info mt-3" href="{{ route('articles.edit', ['article' => $article->slug]) }}"><i class="bi bi-pencil-square"></i> Modifier</a>
                                    <form style="display: inline;" action="{{ route('articles.destroy', ['article' => $article->slug]) }}" method="post">
                                        @method('DELETE') @php echo "\n"; @endphp
                                        @csrf @php echo "\n"; @endphp
                                        <button class="btn btn-danger mt-3" type="submit"><i class="bi bi-x-square"></i> Supprimer</button>
                                    </form>
                                </div>
@endif
                        </div> <!-- /.card-body -->
                    </div> <!-- /.card .articles-list -->
@empty
                    <div class="card mt-4 articles-list">
                        <div class="card-body">
                            <p>Aucun article</p>
                        </div>
                    </div>
@endforelse
                    <div class="pagination mt-5"> {{-- Pagination --}}
                        {{ $articles->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div> <!-- /.col-lg-9 -->
            </div> <!-- /.row -->
@stop
