  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
            <img src="{{ asset('/assets/img/public/logo.png') }}" alt="PMYLP" style="height: 40px;">
            <span class="fw-bold text-success" title="Prime Minister Youth Loan Program">PMYLP</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarMenu">
            <ul class="navbar-nav align-items-lg-center gap-2">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active fw-semibold' : '' }}">Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('loan.application') }}" class="btn btn-success px-4 py-2 fw-semibold">
                        <i class="bi bi-pencil-square me-1"></i> Apply
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('track.application') }}" class="nav-link {{ request()->routeIs('track.application') ? 'active fw-semibold' : '' }}">Track</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

