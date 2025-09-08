<!-- Header -->
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-light px-3">
    <a class="navbar-brand fw-bold text-dark" href="#">▶ Video Storytelling</a>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link text-dark" href="#">Upload</a></li>
            <li class="nav-item"><a class="nav-link text-dark" href="#">My Videos</a></li>
        </ul>
    </div>

    <!-- Profile Dropdown -->
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
            id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('/assets/img//default.png') }}" alt="profile" width="40" height="40"
                class="rounded-circle me-2">
            <span>Ahsan Danish</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow">
            <li>
                <h6 class="dropdown-header">Welcome, Ahsan</h6>
            </li>
            <li><a class="dropdown-item" href="#">Change Password</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li>
                <form method="POST" action="{{route('logout')}}">
                    @csrf
                    <button class="dropdown-item text-danger" type="submit">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</nav>
