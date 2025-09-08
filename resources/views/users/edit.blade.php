@extends('layouts.master')

@section('title', 'Edit User')

@section('content')
<main>
    @include('include.page_header')
    <!-- Main page content-->
    <div class="container-xl px-4 mt-4">
        <hr class="mt-0 mb-4" />
        <div class="row">
            <div class="col-lg-8">
                <!-- Edit user card-->
                <div class="card mb-4">
                    <div class="card-header">Edit User</div>
                    <div class="card-body">
                        <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data" onsubmit="validateForm(event, this, 1)" autocomplete="off">
                            @csrf
                            @method('PUT')

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="small mb-1" for="name">Name</label>
                                <input class="form-control" id="name" type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Enter Name" />
                            </div>

                            <div class="mb-3">
                                <label class="small mb-1" for="email">Email</label>
                                <input class="form-control" id="email" type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Enter Email" />
                            </div>

                            <div class="mb-3">
                                <label class="small mb-1" for="role_id">User Role</label>
                                <select class="form-control" id="role_id" name="role_id">
                                    <option value="">Choose Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                            {{ $role->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="small mb-1" for="password">Password (leave blank if not changing)</label>
                                <input class="form-control" id="password" type="password" name="password" placeholder="New Password" />
                            </div>

                            <div class="mb-3">
                                <label class="small mb-1" for="password_confirmation">Confirm Password</label>
                                <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm Password" />
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@push('scripts')
    <script>
        
    </script>
@endpush
@endsection


