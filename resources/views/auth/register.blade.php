@extends('layouts.app')
@section('page_title', 'Register Page')
@section('main_content')
    <div class="w-full d-flex align-items-center justify-content-center bg-body-tertiary" style="min-height: 100vh;">
        <div class="card py-2" style="width: 600px;">
            <div class="card-body">
                <h5 class="card-title text-center fw-bold">Register</h5>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" required autofocus>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required autofocus>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="mt-2">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Remember Me
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3" style="--bs-btn-color: #ffff; --bs-btn-bg:#FF6801; --bs-btn-border-color: #FF6801; --bs-btn-hover-bg: #e75c00; --bs-btn-hover-border-color: #e75c00;">Register</button>
                    <p class="mt-2 text-center">Or</p>
                    <div class="mt-2">
                        <a href="{{ route('google.login') }}" class="btn btn-primary w-100" style="--bs-btn-color: #ffff; --bs-btn-bg:#FF6801; --bs-btn-border-color: #FF6801; --bs-btn-hover-bg: #e75c00; --bs-btn-hover-border-color: #e75c00;">
                            Login with Google
                        </a>
                    </div>
                    <div class="mt-3 text-center">
                        <a href="{{ route('login') }}" class="fs-6" style="color: #FF6801;">
                            have an account? Login
                        </a>
                    </div>
                </form>
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-success mt-3">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
