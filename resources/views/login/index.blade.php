@extends('layouts.main')

@section('sidebar')
    
@endsection

@section('container')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show p-3 mb-3" role="alert">
            {{ session('success') }}
            <button type="button" class="p-1 btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>  
        @endif

        @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show p-3 mb-3" role="alert">
            {{ session('error') }}
            <button type="button" class="p-1 btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>  
        @endif

        <main class="form-login">
            <h1 class="h3 mb-3 fw-normal text-center">Login</h1>
            <form action="/login" method="POST">
            @csrf
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
            <button class="w-100 btn btn-lg btn-primary" name="login" type="submit">Login</button>
            </form>
            <small class="d-block text-center mt-3">Not registered? <a href="/register">Register Now!</a></small>
        </main>
    </div>
</div>
@endsection