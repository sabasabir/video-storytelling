@extends('layouts.master-blank')

@section('title', 'Register')

@section('content')
<style>
    body {
        background-color: #080710;
    }

    .background {
        width: 430px;
        height: 640px; /* taller for register */
        position: absolute;
        transform: translate(-50%, -50%);
        left: 50%;
        top: 50%;
    }

    .background .shape {
        height: 200px;
        width: 200px;
        position: absolute;
        border-radius: 50%;
    }

    .shape:first-child {
        background: linear-gradient(#1845ad, #23a2f6);
        left: -80px;
        top: -80px;
    }

    .shape:last-child {
        background: linear-gradient(to right, #ff512f, #f09819);
        right: -30px;
        bottom: -80px;
    }

    form {
        min-height: 600px;
        width: 430px;
        background-color: rgba(255, 255, 255, 0.13);
        position: absolute;
        transform: translate(-50%, -50%);
        top: 52%;
        left: 50%;
        border-radius: 10px;
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
        padding: 20px 35px;
    }

    form * {
        font-family: 'Poppins', sans-serif;
        color: #ffffff;
        letter-spacing: 0.5px;
        outline: none;
        border: none;
    }

    form h3 {
        font-size: 28px;
        font-weight: 600;
        text-align: center;
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-top: 20px;
        font-size: 14px;
        font-weight: 500;
    }

    input, select {
        display: block;
        height: 45px;
        width: 100%;
        background-color: rgba(255, 255, 255, 0.07);
        border-radius: 3px;
        padding: 0 10px;
        margin-top: 6px;
        font-size: 14px;
        font-weight: 300;
    }

    ::placeholder {
        color: #e5e5e5;
    }

    .form-row {
        display: flex;
        gap: 10px;
    }

    .form-row input {
        flex: 1;
    }

    button {
        margin-top: 30px;
        width: 100%;
        background-color: #ffffff;
        color: #080710;
        padding: 12px 0;
        font-size: 16px;
        font-weight: 600;
        border-radius: 5px;
        cursor: pointer;
    }

    .social {
        margin-top: 20px;
        text-align: center;
    }

    .alert-danger {
        --bs-alert-color: #8b0d00;
        --bs-alert-bg: #76261f;
        --bs-alert-border-color: #89241a;
    }
</style>

<div class="background">
    <div class="shape"></div>
    <div class="shape"></div>
</div>

<form action="{{ route('register') }}" method="POST">
    @csrf
    <div class="d-flex justify-content-center">
        <img src="{{ asset('/assets/img/public/logo.png') }}" class="login-logo" alt="">
    </div>
    <h3>Create Account</h3>

    <!-- Errors -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="form-row">
        <input type="text" name="first_name" placeholder="First name" required>
        <input type="text" name="last_name" placeholder="Last name" required>
    </div>

    <label>Email</label>
    <input type="email" name="email" placeholder="Email address" required>

    <label>Password</label>
    <input type="password" name="password" placeholder="Password" required>

    <label>Confirm Password</label>
    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

    <label>Date of Birth</label>
    <input type="date" name="dob" required>

    <label>Gender</label>
    <div class="form-row">
        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
    </div>

    <button type="submit">Sign Up</button>

    <div class="social">
        <small>Already have an account? <a href="{{ route('login.form') }}" style="color: #23a2f6;">Login</a></small>
    </div>
</form>
@endsection
