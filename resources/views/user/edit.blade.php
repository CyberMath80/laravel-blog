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
@if(session('error'))
                        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
@endif
                    <div class="card card-outline-secondary my-4">
                        <div class="card-header">{{ ucfirst($user->name) }} : Modifier votre Profil ?</div>
                        <div class="card-body">
                            <form action="{{ route('post.user') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @php echo "\n"; @endphp
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Nom d'utilisateur</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
@error('name')
                                    <div class="error">{{ $message }}</div>
@enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
@error('email')
                                    <div class="error">{{ $message }}</div>
@enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="avatar" class="form-label">Avatar</label>
                                    <input type="file" name="avatar" id="avatar" class="btn btn-secondary form-control">
@error('avatar')
                                    <div class="error">{{ $message }}</div>
@enderror
                                </div>
@if(!empty($user->avatar->filename))
                                <div class="mb-3">
                                    <a href="{{ $user->avatar->url }}" target="_blank">
                                        <img class="avatar" src="{{ $user->avatar->thumb_url }}" alt="Avatar appartenant à {{ $user->name }}">
                                    </a>
                                </div>
@endif
                                <button type="submit" class="btn btn-success">Enregistrer mon profil</button>
                            </form>
                            <p class="mt-5"><a href="{{ route('user.password') }}">Modifier mon mot de passe</a></p>
                            <div class="text-right">
                                <form action="{{ route('user.destroy', ['user' => $user->id]) }}" method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="alert alert-danger">Supprimer mon compte</button>
                                </form>
                            </div>
                        </div>
                    </div> <!-- /.card -->
                </div> <!-- /.col-lg-9 -->
            </div> <!-- Page Content -->
@stop
