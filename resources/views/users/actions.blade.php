<button class="btn btn-datatable btn-icon btn-transparent-dark me-2" id="actionDropdown" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="fa-solid fa-ellipsis-vertical"></i>
</button>
<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionDropdown">
    <li><a class="dropdown-item" href="{{ route('user.show', $row->id) }}">View</a></li>
    {{-- Future actions: Edit/Delete --}}
</ul>
