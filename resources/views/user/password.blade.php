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
                        <div class="card-header">{{ ucfirst($user->name) }} : Modifier votre mot de passe ?</div>
                        <div class="card-body">
                            <form action="{{ route('update.password') }}" method="post">
                                @csrf
                                @php echo "\n"; @endphp
                                <div class="form-group mb-3">
                                    <label for="current" class="form-label">Mot de passe actuel</label>
                                    <input type="password" name="current" id="current" class="form-control">
@error('current')
                                    <div class="error">{{ $message }}</div>
@enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">Votre nouveau password</label>
                                    <input type="password" name="password" id="password" class="form-control">
@error('password')
                                    <div class="error">{{ $message }}</div>
@enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmez votre nouveau password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-success">Enregistrer mon password</button>
                            </form>
                            <p class="mt-5"><a href="{{ route('user.edit') }}">Modifier mon profil</a></p>
                        </div>
                    </div> <!-- /.card -->
                </div> <!-- /.col-lg-9 -->
            </div> <!-- Page Content -->
@stop
