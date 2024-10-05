@extends('layouts.main')

@section('sidebar')
    
@endsection

@section('container')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <main class="form-login">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <h1 class="h3 mb-3 fw-normal text-center">Registration Form</h1>

            <form action="/register" method="POST">
            @csrf
            <div class="form-floating">
                <input type="text" name="name" class="form-control p-2 @error('name') is-invalid @enderror" id="name" placeholder="name@example.com" value="{{ old('name') }}" autofocus required>
                <label class="p-1" for="name">Name</label>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-floating">
                <input type="email" name="email" class="form-control p-2 @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" value="{{ old('email') }}" autofocus required>
                <label class="p-1" for="email">Email address</label>
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control p-2" id="password" placeholder="Password" required>
                <label class="p-1" for="password">Password</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password_confirmation" class="form-control p-2" id="password_confirmation" placeholder="Confirm Password" required>
                <label class="p-1" for="password_confirmation">Confirm Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
            </form>
            <small class="d-block text-center mt-3">Already registered? <a href="/login">Login</a></small>
        </main>
    </div>
</div>
@endsection