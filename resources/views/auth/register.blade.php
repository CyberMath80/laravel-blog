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
                        <div class="card-header">Inscription</div>
                        <div class="card-body">
                            <form action="{{ route('post.register') }}" method="post">
                                @csrf
                                @php echo "\n"; @endphp
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Nom d'utilisateur</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
@error('name')
                                    <div class="error">{{ $message }}</div>
@enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
@error('email')
                                    <div class="error">{{ $message }}</div>
@enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">Mot de passe</label>
                                    <input type="password" name="password" id="password" class="form-control">
@error('password')
                                    <div class="error">{{ $message }}</div>
@enderror
                                </div>
                                <button type="submit" class="btn btn-success">Inscription</button>
                            </form>
                            <p class="mt-5"><a href="{{ route('login') }}">J'ai déjà un compte</a></p>
                        </div>
                    </div> <!-- /.card -->
                </div> <!-- /.col-lg-9 -->
            </div> <!-- Page Content -->
@stop
