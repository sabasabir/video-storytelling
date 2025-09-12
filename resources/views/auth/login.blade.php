@extends('layouts.master-blank')

@section('title', 'login')

@section('content')
    <div class="form-outer-container">
        <div class="container">
            <!-- Tabs -->
            <div class="tabs">
                <div class="tab active" id="login-tab">Login</div>

                <div class="tab" id="signup-tab">Signup</div>
            </div>

            <!-- Login Form -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-container active" id="login-form">
                <h2>Welcome Back</h2>

                <form action="{{ route('login') }}" method="POST" onsubmit="validateForm(event, this, 'login')">
                    @csrf
                    <div class="form-group">
                        <label>Email</label>

                        <input type="email" id="login-email" name="email" class="required" />
                    </div>

                    <div class="form-group">
                        <label>Password</label>

                        <input type="password" id="login-password" name="password" class="required" />

                    </div>
                    <div class="text-end mb-2">
                        <a href="{{ route('password.request') }}">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn">Login</button>
                    <div class="text-center mt-3">
                                OR
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('google.login') }}" class="btn btn-danger w-100">
                            <i class="bi bi-google"></i> Login with Google
                        </a>
                    </div>

                    <p class="extra-text">
                        Don't have an account?
                        <a href="#" onclick="switchTab('signup')">Sign up</a>
                    </p>
                </form>
            </div>

            <!-- Signup Form -->

            <div class="form-container" id="signup-form">
                <h2>Create Account</h2>

                <form action="{{ route('register') }}" method="POST" onsubmit="validateForm(event, this, 'signup')">
                    <!-- First & Last Name in one row -->
                    @csrf
                    <div class="form-row">
                        <div class="form-group" style="flex: 1; margin-right: 10px;">
                            <label>First Name</label>
                            <input type="text" id="firstName" name="first_name" class="required" />
                        </div>

                        <div class="form-group" style="flex: 1;">
                            <label>Last Name</label>
                            <input type="text" id="lastName" name="last_name" class="required" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="signupEmail" name="email" class="required" />
                    </div>

                    <!-- Password & Confirm Password in one row -->
                    <div class="form-row">
                        <div class="form-group" style="flex: 1; margin-right: 10px;">
                            <label>Password</label>
                            <input type="password" id="signup-password" name="password" class="required" minlength="6" />
                        </div>

                        <div class="form-group" style="flex: 1;">
                            <label>Confirm Password</label>
                            <input type="password" id="signup-password-confirm" name="password_confirmation"
                                class="required" minlength="6" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" id="dob" name="dob" class="required" />
                    </div>

                    <div class="form-group">
                        <label>Gender</label>
                        <select id="gender" name="gender" class="required">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <button type="submit" class="btn">Sign Up</button>

                    <p class="extra-text">
                        Already have an account?
                        <a href="#" onclick="switchTab('login')">Login</a>
                    </p>
                </form>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        const loginTab = document.getElementById("login-tab");
        const signupTab = document.getElementById("signup-tab");
        const loginForm = document.getElementById("login-form");
        const signupForm = document.getElementById("signup-form");

        // Switch Tabs
        function switchTab(tab) {
            if (tab === "login") {
                loginTab.classList.add("active");
                signupTab.classList.remove("active");
                loginForm.classList.add("active");
                signupForm.classList.remove("active");
            } else {
                signupTab.classList.add("active");
                loginTab.classList.remove("active");
                signupForm.classList.add("active");
                loginForm.classList.remove("active");
            }
        }

        loginTab.addEventListener("click", () => switchTab("login"));
        signupTab.addEventListener("click", () => switchTab("signup"));
    </script>
@endpush
