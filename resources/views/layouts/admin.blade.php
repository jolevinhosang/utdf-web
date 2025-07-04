<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - UTDF</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo_utdf.jpg') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #eaf4ea 0%, #ffffff 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .admin-sidebar {
            background: white;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
            min-height: 100vh;
        }
        .admin-header {
            background: linear-gradient(to right, #198754, #20c997);
            color: white;
            padding: 1rem;
        }
        .nav-link {
            color: #495057;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin: 0.25rem 0;
            transition: all 0.3s ease;
        }
        .nav-link:hover, .nav-link.active {
            background: #e9ecef;
            color: #198754;
        }
        .nav-link i {
            width: 20px;
        }
        .main-content {
            padding: 2rem;
        }
        @media (max-width: 991.98px) {
            .main-content {
                padding: 1rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Top Navbar for Mobile -->
    <nav class="navbar navbar-expand-lg navbar-success bg-success d-lg-none">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-white" href="#">
                <img src="{{ asset('assets/logo_utdf.jpg') }}" alt="Logo" style="width:32px;height:32px;object-fit:cover;" class="rounded me-2"> UTDF Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebarOffcanvas" aria-controls="adminSidebarOffcanvas">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <!-- Offcanvas Sidebar for Mobile (moved here) -->
    <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="adminSidebarOffcanvas" aria-labelledby="adminSidebarOffcanvasLabel">
        <div class="offcanvas-header admin-header">
            <h6 class="offcanvas-title" id="adminSidebarOffcanvasLabel">UTDF Admin Panel</h6>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <nav class="nav flex-column p-3">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
                <a class="nav-link" href="{{ route('posts.create') }}">
                    <i class="bi bi-plus-circle me-2"></i>Create Post
                </a>
                <a class="nav-link" href="{{ route('admin.posts') }}">
                    <i class="bi bi-file-text me-2"></i>Manage Posts
                </a>
                <a class="nav-link" href="{{ route('admin.users') }}">
                    <i class="bi bi-people me-2"></i>Users
                </a>
                <hr>
                <div class="mb-2 text-muted small ps-2">Edit Home Page Sections</div>
                <a class="nav-link" href="{{ route('admin.home_sections.edit', 'about') }}"><i class="bi bi-info-circle me-2"></i>Get To Know Us</a>
                <a class="nav-link" href="{{ route('admin.home_sections.edit', 'mission') }}"><i class="bi bi-bullseye me-2"></i>Mission & Vision</a>
                <a class="nav-link" href="{{ route('admin.home_sections.edit', 'management') }}"><i class="bi bi-people-fill me-2"></i>Foundation Management</a>
                <a class="nav-link" href="{{ route('admin.home_sections.edit', 'activities') }}"><i class="bi bi-calendar-event me-2"></i>Upcoming Activities</a>
                <a class="nav-link" href="{{ route('admin.home_sections.edit', 'locations') }}"><i class="bi bi-geo-alt-fill me-2"></i>Locations</a>
                <a class="nav-link" href="{{ route('admin.home_sections.edit', 'reports') }}"><i class="bi bi-file-earmark-bar-graph-fill me-2"></i>Yearly Reports</a>
                <a class="nav-link" href="{{ route('admin.home_sections.edit', 'support') }}"><i class="bi bi-heart-fill me-2"></i>Support</a>
                <a class="nav-link" href="{{ route('admin.home_sections.edit', 'contact') }}"><i class="bi bi-envelope-fill me-2"></i>Contact Us</a>
                <hr>
                <a class="nav-link" href="{{ route('welcome') }}">
                    <i class="bi bi-house me-2"></i>View Website
                </a>
                <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </button>
                </form>
            </nav>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <!-- Sidebar: Offcanvas for mobile, static for desktop -->
            <div class="d-none d-lg-block col-lg-2 px-0">
                <div class="admin-sidebar">
                    <div class="admin-header text-center">
                        <img src="{{ asset('assets/logo_utdf.jpg') }}" alt="UTDF Logo" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                        <h6 class="mb-0 mt-2">Admin Panel</h6>
                    </div>
                    <nav class="nav flex-column p-3">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                        </a>
                        <a class="nav-link" href="{{ route('posts.create') }}">
                            <i class="bi bi-plus-circle me-2"></i>Create Post
                        </a>
                        <a class="nav-link" href="{{ route('admin.posts') }}">
                            <i class="bi bi-file-text me-2"></i>Manage Posts
                        </a>
                        <a class="nav-link" href="{{ route('admin.users') }}">
                            <i class="bi bi-people me-2"></i>Users
                        </a>
                        <hr>
                        <div class="mb-2 text-muted small ps-2">Edit Home Page Sections</div>
                        <a class="nav-link" href="{{ route('admin.home_sections.edit', 'about') }}"><i class="bi bi-info-circle me-2"></i>Get To Know Us</a>
                        <a class="nav-link" href="{{ route('admin.home_sections.edit', 'mission') }}"><i class="bi bi-bullseye me-2"></i>Mission & Vision</a>
                        <a class="nav-link" href="{{ route('admin.home_sections.edit', 'management') }}"><i class="bi bi-people-fill me-2"></i>Foundation Management</a>
                        <a class="nav-link" href="{{ route('admin.home_sections.edit', 'activities') }}"><i class="bi bi-calendar-event me-2"></i>Upcoming Activities</a>
                        <a class="nav-link" href="{{ route('admin.home_sections.edit', 'locations') }}"><i class="bi bi-geo-alt-fill me-2"></i>Locations</a>
                        <a class="nav-link" href="{{ route('admin.home_sections.edit', 'reports') }}"><i class="bi bi-file-earmark-bar-graph-fill me-2"></i>Yearly Reports</a>
                        <a class="nav-link" href="{{ route('admin.home_sections.edit', 'support') }}"><i class="bi bi-heart-fill me-2"></i>Support</a>
                        <a class="nav-link" href="{{ route('admin.home_sections.edit', 'contact') }}"><i class="bi bi-envelope-fill me-2"></i>Contact Us</a>
                        <hr>
                        <a class="nav-link" href="{{ route('welcome') }}">
                            <i class="bi bi-house me-2"></i>View Website
                        </a>
                        <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>
            <!-- Main Content -->
            <div class="col-12 col-lg-10 main-content">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/j73mk6mnqhc1xplmcestnwbx6lwiunb4ib4bwuf13z36qjfg/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    @stack('scripts')
</body>
</html> 