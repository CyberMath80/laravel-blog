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
                    <div class="card card-outline-secondary my-4">
                        <div class="card-header">Modifier mon article : @php echo ucfirst($article->title);@endphp</div>
                        <div class="card-body">
                            <form action="{{ route('articles.update', ['article' => $article->slug]) }}" method="post">
                                @method('PUT') @php echo "\n";@endphp
                                @csrf
                                @php echo "\n"; @endphp
                                <div class="form-group mb-3">
                                    <label for="title" class="form-label">Titre de l'article</label>
                                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $article->title) }}">
@error('title')
                                    <div class="error">{{ $message }}</div>
@enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="content" class="form-label">Contenu de l'article</label>
                                    <textarea name="content" id="content" class="form-control" cols="30" rows="5" placeholder="Écrire mon article ici">{{ old('content', $article->content) }}</textarea>
@error('content')
                                    <div class="error">{{ $message }}</div>
@enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="category" class="form-label">Catégorie</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Choix de la catégorie</option>
@foreach($categories as $category)
                                        <option value="{{ $category->id }}"@if(old('category', $article->category_id ?? '') == $category->id) selected @endif>{{ $category->name }}</option>
@endforeach
                                    </select>
@error('category')
                                    <div class="error">{{ $message }}</div>
@enderror
                                </div>
                                <button type="submit" class="btn btn-success">Poster mon article</button>
                            </form>
                        </div>
                    </div> <!-- /.card -->
                </div> <!-- /.col-lg-9 -->
            </div> <!-- Page Content -->
@stop
