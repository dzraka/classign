<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <title>ClAssign - Platform Manajemen Kelas</title>
    <style>
        .bg-filter {
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: brightness(70%) blur(2px);
            background-color: rgba(0, 0, 0, 0.2);
            z-index: 1;
        }
    </style>
</head>
<body></body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-sm navbar-dark shadow-sm fixed-top" style="background-color: #050d1c;">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="#">
                ClAssign <span class="navbar-text d-none d-sm-inline">for education</span>
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur Utama</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#benefits">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light ms-lg-3 my-1" href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light ms-lg-3 my-1" href="{{ route('register') }}">Daftar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" style="background-image: url('{{ asset('img/bg1.jpg') }}'); background-size: cover; background-position: center; min-height: 100vh;">
        <div class="bg-filter" style="min-height: 100vh;">
            <div class="container position-relative z-1 d-flex align-items-center justify-content-center text-center">
                <div class="px-3" style="max-width: 800px">
                    <img src="{{ asset('img/logo.png') }}" alt="logo" style="max-width: 250px" class="mt-5 img-fluid">
                    <p class="fs-5 fw-light text-white px-2">
                        ClAssign membantu pendidik menciptakan pengalaman belajar yang menarik yang dapat disesuaikan, dikelola, dan diukur. Tim Pengembang dari 3RWork for Education, ClAssign memberdayakan pendidik untuk meningkatkan dampak mereka dan mempersiapkan siswa untuk masa depan.
                    </p>
                    <div class="row justify-content-center g-2 my-3">
                        <div class="col-6 col-md-4">
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg w-100">Masuk</a>
                        </div>
                        <div class="col-6 col-md-4">
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg w-100">Daftar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-4 py-md-5" id="features">
        <div class="container py-2 py-md-4">
            <div class="row mb-4 mb-md-5">
                <div class="col-lg-8 mx-auto text-center px-3">
                    <h2 class="fw-bold mb-3">Fitur Utama</h2>
                    <p class="lead text-muted">ClAssign menawarkan berbagai fitur yang memudahkan proses belajar mengajar.</p>
                </div>
            </div>
            <div class="row g-3 g-md-4">
                <div class="col-md-4">
                    <div class="feature-box text-center p-3">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-book fs-1 text-primary"></i>
                        </div>
                        <h3 class="h5">Manajemen Materi</h3>
                        <p class="small">Upload dan bagikan materi pembelajaran dengan mudah. Siswa dapat mengakses kapan saja dan dimana saja.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box text-center p-3">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-clipboard-check fs-1 text-primary"></i>
                        </div>
                        <h3 class="h5">Pengelolaan Tugas</h3>
                        <p class="small">Buat dan distribusikan tugas, set deadline, dan nilai tugas siswa dalam satu platform.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box text-center p-3">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-calendar-check fs-1 text-primary"></i>
                        </div>
                        <h3 class="h5">Kalender Kelas</h3>
                        <p class="small">Pantau jadwal dan deadline penting dengan fitur kalender terintegrasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- about Section -->
    <section id="about" class="py-4 py-md-5">
        <div class="container">
            <div class="row text-center">
                <div class="col px-3 mx-auto" style="max-width: 900px">
                    <h2 class="mb-3">Tentang Kami</h2>
                    <p class="px-2">
                        ClAssign dikembangkan oleh tim mahasiswa yang peduli terhadap efisiensi dan kenyamanan dalam pendidikan digital. Misi kami adalah membantu pendidik dan siswa dalam menjalani proses pengajaran dan pembelajaran yang lebih terorganisir, menyenangkan, dan produktif.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-white pt-4 pt-md-5" style="background-color: #050d1c">
        <div class="container text-md-start">
            <div class="row">
                {{-- Tentang Aplikasi --}}
                <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
                    <h6 class="fs-5 fs-md-4 fw-bold">ClAssign</h6>
                    <hr class="mb-2 mt-0 d-inline-block mx-auto" style="width: 100px; background-color: #ffffff; height: 2px" />
                    <p class="small">Platform manajemen tugas digital untuk guru dan siswa. Buat dan kumpulkan tugas dengan efisien.</p>
                </div>
                {{-- Kontak --}}
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <h6 class="fs-5 fs-md-4 text-uppercase fw-bold">Hubungi Kami</h6>
                    <hr class="mb-2 mt-0 d-inline-block mx-auto" style="width: 150px; background-color: #ffffff; height: 2px" />
                    <p class="small"><i class="bi bi-envelope me-2"></i> 3RWork@classign.id</p>
                    <p>
                        <a href="#" class="text-white me-3"><i class="bi bi-instagram fs-5"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-linkedin fs-5"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-facebook fs-5"></i></a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>