<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm sticky-top">
    <div class="container px-4">
        <a class="navbar-brand fw-bold text-uppercase" href="/">
            <img src="{{ asset('assets/logo_utdf.jpg') }}" alt="Logo" class="navbar-logo img-fluid rounded shadow" />
            <span class="d-inline d-lg-none">UTDF</span>
            <span class="d-none d-lg-inline">UNITED TIMOR DEVELOPMENT FOUNDATION</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active fw-semibold text-white px-3" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3" href="#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3" href="#upcoming-activities">Activities</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3" href="#locations">Locations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3" href="#support">Support</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white px-3" href="#contact">Contact</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link text-white px-3" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i>Admin Panel
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
