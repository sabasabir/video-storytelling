@extends('layouts.master-blank')

@section('title', 'Change Password')

@section('content')
<div class="form-outer-container">
    <div class="container">

        <div class="tabs">
            <div class="tab active">Change Password</div>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-container active">
            <h2>Update Your Password</h2>

            <form action="{{ route('password.change') }}" method="POST" onsubmit="validateForm(event, this, 'change-password')">
                @csrf
                <div class="form-group">
                    <label>Current Password</label>
                    <input type="password" name="current_password" class="required" placeholder="Enter current password">
                </div>

                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="password" class="required" minlength="6" placeholder="Enter new password">
                </div>

                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="required" minlength="6" placeholder="Confirm new password">
                </div>

                <button type="submit" class="btn btn-primary">Update Password</button>
                @include('include.formloader')

                <p class="extra-text mt-3 text-center">
                    <a href="{{ route('dashboard') }}">← Back to Dashboard</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
