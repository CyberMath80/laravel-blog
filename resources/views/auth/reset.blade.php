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
                        <div class="card-header">Réinitialiser mon mot de passe</div>
                        <div class="card-body">
                            <form action="{{ route('post.reset') }}" method="post">
                                @csrf
                                @php echo "\n"; @endphp
                                <input type="hidden" name="token" value="{{ $password_reset->token }}">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
@error('email')
                                    <div class="error">{{ $message }}</div>
@enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">Votre nouveau mot de passe</label>
                                    <input type="password" name="password" id="password" class="form-control">
@error('password')
                                    <div class="error">{{ $message }}</div>
@enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmez votre nouveau mot de passe</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-success">Envoyer</button>
                            </form>
                        </div>
                    </div> <!-- /.card -->
                </div> <!-- /.col-lg-9 -->
            </div> <!-- Page Content -->
@stop
