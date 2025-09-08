@extends('layouts.master-blank')

@section('title', 'Reset Password')

@section('content')
<div class="background">
    <div class="shape"></div>
    <div class="shape"></div>
</div>
<form action="{{ route('password.update') }}" method="POST">
    <div class="d-flex">
        <img src="{{ asset('/assets/img/public/logo.png') }}" class="login-logo" alt="">
    </div>
    <h3>Reset Password</h3>
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <label for="email">Email</label>
    <input type="email" placeholder="Email" name="email" value="{{ old('email') }}">

    <label for="password">New Password</label>
    <input type="password" placeholder="New Password" name="password">

    <label for="password_confirmation">Confirm Password</label>
    <input type="password" placeholder="Confirm Password" name="password_confirmation">

    <button type="submit">Reset Password</button>

    <div class="extra-links">
        <a href="{{ route('login') }}">Back to Login</a>
    </div>
</form>
@endsection
