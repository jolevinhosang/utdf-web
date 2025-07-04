<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="United Timor Development Foundation (UTDF) – Supporting communities in Indonesia and Timor-Leste through sanitation, education, and agriculture." />
        <meta name="author" content="UTDF" />
        <title>United Timor Development Foundation (UTDF)</title>
        <link rel="icon" type="image/x-icon" href="assets/logo_utdf.jpg" />
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
        <style>
            .hero-img-standout, #heroCarousel .carousel-item img {
                max-width: 100%;
                max-height: 650px;
                min-height: 350px;
                width: 100%;
                height: 480px;
                object-fit: cover;
                border: 8px solid #198754;
                box-shadow: 0 0 60px 0 rgba(25,135,84,0.25);
                margin-bottom: 2rem;
            }
            @media (min-width: 992px) {
                .hero-img-standout, #heroCarousel .carousel-item img {
                    max-width: 90vw;
                    min-height: 350px;
                    max-height: 650px;
                    height: 480px;
                }
            }
        </style>
    </head>
    <body>
        @include('layouts.navigation')
        @php
            $heroPost = $hero ?? $posts->first();
        @endphp
        <!-- Hero Section -->
        <section class="py-5 bg-light border-top border-bottom" id="hero" style="background: linear-gradient(to right, #eaf4ea, #ffffff);">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-lg-7 mb-4 mb-lg-0 d-flex align-items-center justify-content-center">
                        @if($heroPost && $heroPost->images && is_array($heroPost->images) && count($heroPost->images) > 1)
                            <div id="heroCarousel" class="carousel slide w-100" data-bs-ride="carousel">
                                <div class="carousel-inner rounded-4 shadow">
                                    @foreach($heroPost->images as $idx => $img)
                                        <div class="carousel-item{{ $idx === 0 ? ' active' : '' }}">
                                            <img src="{{ asset('storage/' . $img) }}" alt="{{ $heroPost->title }} Image {{ $idx+1 }}" class="img-fluid hero-img-standout w-100" />
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        @elseif($heroPost && $heroPost->images && is_array($heroPost->images) && count($heroPost->images) > 0)
                            <img src="{{ asset('storage/' . $heroPost->images[0]) }}"
                                alt="{{ $heroPost->title }}"
                                class="img-fluid rounded shadow feature-image hero-img-standout" />
                        @else
                            <img src="{{ asset('assets/logo_utdf.jpg') }}" alt="UTDF" class="img-fluid rounded shadow feature-image hero-img-standout" />
                        @endif
                    </div>
                    <div class="col-lg-5">
                        <div class="p-4 bg-white bg-opacity-90 rounded-4 shadow-sm mb-4 hero-text-card">
                            <h1 class="fw-bold text-success mb-3 display-5" style="line-height:1.1;">{{ $heroPost ? $heroPost->title : 'Welcome to UTDF' }}</h1>
                            @if($heroPost && $heroPost->date)
                                <div class="mb-2 text-muted small">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    {{ $heroPost->date->format('F j, Y') }}
                                </div>
                            @endif
                            <p class="mb-4 text-muted fs-5" style="min-height: 80px;">{{ $heroPost ? $heroPost->description : 'United Timor Development Foundation (UTDF) – Supporting communities in Indonesia and Timor-Leste through sanitation, education, and agriculture.' }}</p>
                            @if($heroPost)
                            <a class="btn btn-success px-4 py-2 fw-semibold shadow-sm" href="{{ route('posts.show', $heroPost->slug) }}">
                                Read More
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Post Previews Section -->
        <section class="py-5" id="post-previews">
            <div class="container px-4 px-lg-5">
                <h2 class="fw-bold text-success text-uppercase mb-4 text-center">
                    <i class="bi bi-newspaper me-2"></i>Latest Posts
                </h2>
                <div class="row gx-4 gy-4">
                    @foreach($posts as $post)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            @if($post->images && is_array($post->images) && count($post->images) > 0)
                                <img src="{{ asset('storage/' . $post->images[0]) }}"
                                    class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                            @else
                                <img src="{{ asset('assets/logo_utdf.jpg') }}" class="card-img-top" alt="UTDF" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $post->title }}</h5>
                                <div class="mb-2 text-muted small">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    {{ $post->date ? $post->date->format('F j, Y') : '' }}
                                </div>
                                <p class="card-text text-muted">{{ $post->subtitle ?? Str::limit($post->description, 80) }}</p>
                                <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-outline-success btn-sm">
                                    Read More
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <a href="{{ route('posts.all') }}" class="btn btn-lg btn-outline-success px-5 py-2 fw-semibold">
                        <i class="bi bi-list-ul me-2"></i>See All Posts
                    </a>
                </div>
            </div>
        </section>

        <!-- Get To Know Us -->
        <section class="py-5 bg-light" id="about">
            <div class="container px-4 px-lg-5">
                <div class="row mb-5">
                    <div class="col-lg-12">
                        <div class="card shadow border-0 rounded-4 bg-white p-4">
                        <div class="card-body">
                            <h2 class="text-success fw-bold mb-3">
                            <i class="bi bi-info-circle-fill me-2"></i> Get To Know Us
                            </h2>
                            {!! $homeSections['about']->content ?? '<p>About section not set.</p>' !!}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission & Vision -->
        <section class="py-5" id="mission-vision">
            <div class="container px-4 px-lg-5">
            <div class="row">
            <div class="col-lg-12">
                <div class="card shadow border-0 rounded-4 bg-white text-center p-4">
                <div class="card-body">
                    <h2 class="text-success fw-bold mb-3">
                    <i class="bi bi-bullseye me-2"></i> Mission & Vision
                    </h2>
                    <hr class="border border-success border-2 w-25 mx-auto">
                    {!! $homeSections['mission']->content ?? '<p>Mission & Vision section not set.</p>' !!}
                    <hr class="border border-success border-2 w-25 mx-auto">
                </div>
                </div>
            </div>
            </div>
            </div>
            </div>
        </section>

        <!-- Foundation Management Section -->
        <section class="py-5 bg-light" id="management">
            <div class="container">
                <h2 class="text-center fw-bold text-success text-uppercase mb-5">
                    <i class="bi bi-people-fill me-2"></i>FOUNDATION MANAGEMENT
                </h2>
                @php
                    $mgmtMembers = json_decode($homeSections['management']->content ?? '', true);
                @endphp
                @if(is_array($mgmtMembers) && count($mgmtMembers))
                    <div class="row">
                        @foreach($mgmtMembers as $member)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm text-center">
                                    @if(!empty($member['photo']))
                                        <img src="{{ asset('storage/' . $member['photo']) }}" class="card-img-top rounded-top mx-auto d-block" alt="{{ $member['name'] }}" style="width: 180px; height: 180px; object-fit: cover; margin-top: 20px;" />
                                    @else
                                        <div class="bg-light rounded-top mx-auto d-block" style="width: 180px; height: 180px; margin-top: 20px;"></div>
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">{{ $member['name'] }}</h5>
                                        <div class="card-text text-muted">{{ $member['role'] }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {!! $homeSections['management']->content ?? '<p>Management section not set.</p>' !!}
                @endif
            </div>
        </section>

        <!-- Upcoming Activities Section -->
        <section class="py-5" id="upcoming-activities">
            <div class="container">
                <h2 class="card-title text-success text-center text-uppercase fw-bold mb-5">
                    <i class="bi bi-calendar-event-fill me-2"></i>Upcoming Activities
                </h2>
                @php
                    $activities = json_decode($homeSections['activities']->content ?? '', true);
                @endphp
                @if(is_array($activities) && count($activities))
                    <div class="row g-4 justify-content-center">
                        @foreach($activities as $activity)
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 shadow border-0 rounded-4">
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <div>
                                            <h5 class="fw-bold text-success mb-2">
                                                <i class="bi bi-calendar-event me-2"></i>{{ $activity['title'] }}
                                            </h5>
                                            <p class="text-muted mb-0">{{ $activity['description'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info text-center mt-4">No upcoming activities at the moment. Please check back soon!</div>
                @endif
            </div>
        </section>

        <!-- Locations Section -->
        <section class="py-5 bg-light" id="locations">
            <div class="container">
                <!-- Title & Intro -->
                <div class="row mb-5">
                    <div class="col-12 text-center">
                        <h2 class="card-title text-success text-uppercase fw-bold mb-3">
                            <i class="bi bi-geo-alt-fill me-2"></i>Locations of the United Timor Development Foundation
                        </h2>
                        @php
                            $locationData = json_decode($homeSections['locations']->content ?? '', true);
                        @endphp
                        @if(is_array($locationData) && isset($locationData['description']))
                            <div class="fst-italic text-muted">
                                {!! $locationData['description'] !!}
                            </div>
                        @else
                        <p class="fst-italic text-muted">
                            {!! $homeSections['locations']->content ?? 'Locations section not set.' !!}
                        </p>
                        @endif
                    </div>
                </div>

                <!-- Map -->
                <div class="row mb-5 justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="card border-0 shadow-sm">
                            @if(is_array($locationData) && isset($locationData['map_image']))
                                <img src="{{ asset('storage/' . $locationData['map_image']) }}" alt="UTDF Map" class="img-fluid rounded-top">
                            @else
                            <img src="assets/PETA_LOKASI_UTDF.jpg" alt="UTDF Map" class="img-fluid rounded-top">
                            @endif
                            <div class="card-body text-center">
                                <p class="fst-italic mb-0">
                                    <!-- You can add static or dynamic map/area info here if needed -->
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Area Cards -->
                <div class="row gy-5">
                    <!-- Timor Indonesia -->
                    <div class="col-lg-6">
                        <h4 class="text-success fw-bold text-uppercase mb-4">
                            <i class="bi bi-flag-fill me-2"></i>Areas in Timor Indonesia
                        </h4>

                        @if(is_array($locationData) && isset($locationData['timor_indonesia']) && count($locationData['timor_indonesia']) > 0)
                            @foreach($locationData['timor_indonesia'] as $idx => $location)
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-body">
                                        <h6 class="fw-bold text-uppercase mb-2">
                                            <i class="bi bi-pin-map-fill me-2 text-primary"></i>{{ $idx + 1 }}. {{ $location['title'] ?? '' }}
                                        </h6>
                                        <p class="mb-0">
                                            {!! $location['description'] ?? '' !!}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- Fallback to static content -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold text-uppercase mb-2">
                                    <i class="bi bi-pin-map-fill me-2 text-primary"></i>1. Belu District
                                </h6>
                                <p class="mb-0">
                                    <strong>Atambua</strong> of Belu, is about 20 km from the border of <em>Timor L'Este (TLE)</em>. The influx of TLE refugees started in 1999 which quickly made Atambua a big town, the second largest on West Timor behind Kupang, and the fourth largest in NTT. The District of Belu covers an area of 1,127.3 km².
                                </p>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold text-uppercase mb-2">
                                    <i class="bi bi-pin-map-fill me-2 text-primary"></i>2. Malaka District
                                </h6>
                                <p class="mb-0">
                                    <strong>Betun</strong> of Malaka, borders with Belu District in the northern part, with TTU and TTS on the western part. In the southern part Malaka borders with the Timor Sea and on the eastern part, with TLE and therefore also recipient of TLE refugees. Malaka District covers an area of 1,109.2 km².
                                </p>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="fw-bold text-uppercase mb-2">
                                    <i class="bi bi-pin-map-fill me-2 text-primary"></i>3. North Central Timor
                                </h6>
                                <p class="mb-0">
                                    <strong>Kefamenanu</strong>, capital of TTU (<em>Timor Tengah Utara</em>), borders with the enclave of TLE in Oekusi/Ambeno. The city hosts less TLE refugees except in the areas closest to the TLE border. Its topography consists of both mountainous and flat areas. TTU covers an area of 623.2 km².
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Timor Leste -->
                    <div class="col-lg-6">
                        <h4 class="text-success fw-bold text-uppercase mb-4">
                            <i class="bi bi-flag-fill me-2"></i>Areas in Timor Leste
                        </h4>

                        @if(is_array($locationData) && isset($locationData['timor_leste']) && count($locationData['timor_leste']) > 0)
                            @foreach($locationData['timor_leste'] as $idx => $location)
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-body">
                                        <h6 class="fw-bold text-uppercase mb-2">
                                            <i class="bi bi-pin-map-fill me-2 text-primary"></i>{{ $idx + 1 }}. {{ $location['title'] ?? '' }}
                                        </h6>
                                        <p class="mb-0">
                                            {!! $location['description'] ?? '' !!}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- Fallback to static content -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold text-uppercase mb-2">
                                    <i class="bi bi-pin-map-fill me-2 text-primary"></i>4. Maliana
                                </h6>
                                <p class="mb-0">
                                    <strong>Maliana</strong> is the capital of Bobonaro District in Timor-Leste (TLE), located near the western border with Indonesia, adjacent to the Belu District. It is one of the key agricultural centers in Timor-Leste, known for its rice production due to the fertile plains and irrigation systems in the area. Maliana town itself covers an area of 239 km².
                                </p>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold text-uppercase mb-2">
                                    <i class="bi bi-pin-map-fill me-2 text-primary"></i>5. Oekusi
                                </h6>
                                <p class="mb-0">
                                    <strong>Oekusi</strong> (also spelled Oecusse), officially known as the Oecusse-Ambeno Special Administrative Region, is an exclave of Timor-Leste (TLE) located within Indonesian territory. The region includes both coastal lowlands and hilly interior terrain. Oekusi covers an area of approximately 814 km².
                                </p>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="fw-bold text-uppercase mb-2">
                                    <i class="bi bi-pin-map-fill me-2 text-primary"></i>6. Dili
                                </h6>
                                <p class="mb-0">
                                    <strong>Dili</strong> the capital city of Timor-Leste (TLE), is situated on the northern coast of the island along the Ombai Strait. As the largest city and main port of the country, Dili serves as the political, economic, and cultural center of Timor-Leste. Dili covers area of about 368 km².
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>


        <!-- Yearly Report Section -->
        <section class="py-5" id="yearly-report">
            <div class="container">
                <div class="text-center mb-5">
                <h2 class="text-success fw-bold">
                    <i class="bi bi-file-earmark-bar-graph-fill me-2"></i>Yearly Reports
                </h2>
                </div>
                @php
                    $reports = json_decode($homeSections['reports']->content ?? '', true);
                @endphp
                @if(is_array($reports) && count($reports))
                    <div class="row g-4 justify-content-center">
                        @foreach($reports as $report)
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 shadow border-0 rounded-4">
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <div>
                                            <h5 class="fw-bold text-success mb-2">
                                                <i class="bi bi-calendar-event me-2"></i>{{ $report['year'] }}
                                            </h5>
                                            <p class="text-muted mb-3">{{ $report['description'] }}</p>
                                        </div>
                                        @if(!empty($report['file']))
                                            <div class="mt-auto">
                                                <a href="{{ route('download.report', basename($report['file'])) }}" 
                                                   class="btn btn-outline-success w-100">
                                                    <i class="bi bi-download me-2"></i>Download Report
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info text-center mt-4">
                        {!! $homeSections['reports']->content ?? 'No yearly reports available at the moment. Please check back soon!' !!}
                    </div>
                @endif
            </div>
        </section>

        <!-- Support Section -->
        <section class="py-5 bg-light" id="support">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-success text-uppercase mb-3">
                        <i class="bi bi-heart-fill me-2"></i>Support Our Mission
            </h2>
                    <div class="w-75 mx-auto">
                        @php
                            $supportData = json_decode($homeSections['support']->content ?? '', true);
                        @endphp
                        @if(is_array($supportData) && isset($supportData['description']))
                            <div class="lead text">
                                {!! $supportData['description'] !!}
                            </div>
                        @else
                            <div class="lead text-muted">
                {!! $homeSections['support']->content ?? '<p>Support section not set.</p>' !!}
                            </div>
                        @endif
                    </div>
                </div>

                @if(is_array($supportData) && isset($supportData['cards']) && count($supportData['cards']) > 0)
                    <div class="row justify-content-center g-3">
                        @foreach($supportData['cards'] as $card)
                            <div class="col-md-8 col-lg-6 col-xl-4">
                                <div class="card border-0 shadow-sm rounded-3">
                                    <div class="card-header bg-success text-white text-center py-2">
                                        <h6 class="fw-bold mb-0">
                                            <i class="bi bi-bank me-2"></i>{{ $card['bank_name'] ?? 'Bank Account' }}
                                        </h6>
                                    </div>
                                    <div class="card-body p-3">
                                        <div class="row g-2">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="bg-success bg-opacity-10 rounded-circle p-1 me-2">
                                                        <i class="bi bi-person-fill text-success small"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <small class="text-muted fw-semibold text-uppercase">Account Name</small>
                                                        <div class="fw-bold text-dark small">{{ $card['account_name'] ?? '' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="bg-success bg-opacity-10 rounded-circle p-1 me-2">
                                                        <i class="bi bi-credit-card-fill text-success small"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <small class="text-muted fw-semibold text-uppercase">Account Number</small>
                                                        <div class="fw-bold text-dark font-monospace small">{{ $card['account_number'] ?? '' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="bg-success bg-opacity-10 rounded-circle p-1 me-2">
                                                        <i class="bi bi-building-fill text-success small"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <small class="text-muted fw-semibold text-uppercase">Branch Code</small>
                                                        <div class="fw-bold text-dark small">{{ $card['branch_code'] ?? '' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-success bg-opacity-10 rounded-circle p-1 me-2">
                                                        <i class="bi bi-globe text-success small"></i>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <small class="text-muted fw-semibold text-uppercase">SWIFT Code</small>
                                                        <div class="fw-bold text-dark font-monospace small">{{ $card['swift_code'] ?? '' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Fallback to static content if no cards -->
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6 col-xl-4">
                            <div class="card border-0 shadow-sm rounded-3">
                                <div class="card-header bg-success text-white text-center py-2">
                                    <h6 class="fw-bold mb-0">
                                        <i class="bi bi-bank me-2"></i>Bank Mandiri
                                    </h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="bg-success bg-opacity-10 rounded-circle p-1 me-2">
                                                    <i class="bi bi-person-fill text-success small"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <small class="text-muted fw-semibold text-uppercase">Account Name</small>
                                                    <div class="fw-bold text-dark small">Yayasan Colin Barlow Ria</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="bg-success bg-opacity-10 rounded-circle p-1 me-2">
                                                    <i class="bi bi-credit-card-fill text-success small"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <small class="text-muted fw-semibold text-uppercase">Account Number</small>
                                                    <div class="fw-bold text-dark font-monospace small">181-00-0220381-9</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="bg-success bg-opacity-10 rounded-circle p-1 me-2">
                                                    <i class="bi bi-building-fill text-success small"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <small class="text-muted fw-semibold text-uppercase">Branch Code</small>
                                                    <div class="fw-bold text-dark small">KC ATAMBUA 18102</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success bg-opacity-10 rounded-circle p-1 me-2">
                                                    <i class="bi bi-globe text-success small"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <small class="text-muted fw-semibold text-uppercase">SWIFT Code</small>
                                                    <div class="fw-bold text-dark font-monospace small">BMRIIDJA</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Call to Action -->
                <div class="text-center mt-5">
                    <div class="bg-white rounded-4 shadow-sm p-4 d-inline-block">
                        <h5 class="text-success fw-bold mb-2">
                            <i class="bi bi-hand-heart-fill me-2"></i>Make a Difference Today
                        </h5>
                        <p class="text-muted mb-0">Your support helps us continue our mission of community development and empowerment.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="py-5" id="contact">
            <div class="container">
                <div class="text-center mb-4">
                <h2 class="fw-bold text-success text-uppercase">
                    <i class="bi bi-envelope-fill me-2"></i>Contact Us
                </h2>
                    @php
                        $contactData = json_decode($homeSections['contact']->content ?? '', true);
                    @endphp
                    @if(is_array($contactData) && isset($contactData['description']))
                        <div class="mb-4">
                            {!! $contactData['description'] !!}
                        </div>
                    @else
                    {!! $homeSections['contact']->content ?? '<p>Contact section not set.</p>' !!}
                    @endif
                </div>
                
                @if(is_array($contactData) && isset($contactData['contacts']) && count($contactData['contacts']) > 0)
                    <div class="row justify-content-center">
                        @foreach($contactData['contacts'] as $contact)
                            <div class="col-md-6 mb-3">
                                <div class="border rounded-3 shadow-sm p-4 bg-white">
                                    <div class="mb-3">
                                        <h5 class="fw-bold">{{ $contact['name'] ?? '' }}</h5>
                                        <p class="text-muted mb-1">{{ $contact['role'] ?? '' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <i class="bi bi-telephone-fill text-success me-2"></i>
                                        <a href="tel:{{ $contact['phone'] ?? '' }}" class="text-decoration-none text-dark">{{ $contact['phone'] ?? '' }}</a>
                                    </div>
                                    <div>
                                        <i class="bi bi-envelope-fill text-success me-2"></i>
                                        @php
                                            $emails = explode(',', $contact['emails'] ?? '');
                                            $emails = array_map('trim', $emails);
                                        @endphp
                                        @foreach($emails as $email)
                                            @if(!empty($email))
                                                <a href="mailto:{{ $email }}" class="text-decoration-none text-dark d-block">{{ $email }}</a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Fallback to static content if no contacts -->
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="border rounded-3 shadow-sm p-4 bg-white">
                            <div class="mb-3">
                                <h5 class="fw-bold">Dr. Ria Gondowarsito</h5>
                                <p class="text-muted mb-1">Founder – United Timor Development Foundation</p>
                            </div>
                            <div class="mb-3">
                                <i class="bi bi-telephone-fill text-success me-2"></i>
                                <a href="tel:+61431371669" class="text-decoration-none text-dark">+61 431 371 669</a>
                            </div>
                            <div>
                                <i class="bi bi-envelope-fill text-success me-2"></i>
                                <a href="mailto:colinbarlowria@gmail.com" class="text-decoration-none text-dark d-block">colinbarlowria@gmail.com</a>
                                <a href="mailto:ria081954@gmail.com" class="text-decoration-none text-dark d-block">ria081954@gmail.com</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </section>

        @include('layouts.footer')

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
