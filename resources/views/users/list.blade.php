@extends('layouts.master')

@section('title', $title ?? 'Dashboard')

@section('content')
<main>
    @include('include.page_header')
    <div class="container-xl px-4 mt-4">
        <div class="card card-header-actions mb-4">
            <div class="card-header">
                Users
            <a href="{{route('user.create')}}" class="btn btn-outline-teal">Add New</a>
            </div>
           
            <div class="card-body">
                <table id="users-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    {{-- <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot> --}}
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('user.index') }}', // your route
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'role.title', name: 'role' },
            { data: 'status_label', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],
        dom: 'Bfrtip',
        buttons: ['pageLength','copy','csv','excel','pdf','print'],
        responsive: true,
        pageLength: 10,
        lengthMenu: [
            [10, 50, 100, 500, -1],
            ['10 rows', '50 rows', '100 rows', '500 rows', 'Show all']
        ],
    });
});
</script>
@endpush
