@extends('layouts.master')

@section('title', 'Update Password')

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
                    <div class="card-header">Update Password</div>
                    <div class="card-body">
                        <form action="{{ route('change.password') }}" method="POST" enctype="multipart/form-data" onsubmit="validateForm(event, this, 1)" autocomplete="off">
                            @csrf
                            @method('POST')

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
@endsection

@section('scripts')

@endsection
