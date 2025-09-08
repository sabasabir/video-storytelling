@extends('layouts.master-blank')

@section('title', 'Forgot Password')

@section('content')
    <div class="form-outer-container">
        <div class="container">

            <!-- Forgot Password Form -->
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-container active">
                <h2>Reset Your Password</h2>
                <p class="extra-text">Enter your registered email address to receive a reset link.</p>

                <form action="{{ route('password.email') }}" method="POST"
                    onsubmit="validateForm(event, this, 'forgot-password')">
                    @csrf

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="required" />
                    </div>

                    <button type="submit" class="btn">Send Reset Link</button>

                    <p class="extra-text">
                        Remembered your password?
                        <a href="{{ route('login') }}">Back to Login</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection
