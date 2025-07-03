<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ClAssign</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <style>
        html { height: 100%; scroll-behavior: smooth; }
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            font-family: "Segoe UI", sans-serif;
        }
        main { flex: 1; }
        .hover-shadow:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
            box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body id="page-top" data-bs-spy="scroll" data-bs-target=".navbar" data-bs-offset="80" tabindex="0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-sm shadow-sm fixed-top" style="background-color: #AB9E7A; opacity: .9">
        <div class="container-fluid">
            <button class="navbar-toggler mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon text-white"></span>
            </button>
            <a class="navbar-brand text-white">
                <span class="fw-semibold">ClAssign</span>
                <span class="fw-light small">For Education</span>
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active text-white" aria-current="page" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#features">Fitur Utama</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#about">Tentang Kami</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        {{-- Hero Section --}}
        <section id="home" style="background-image: url('{{ asset('img/bg1.jpg') }}'); background-size: cover; background-position: center; min-height: 100vh;">
            <div class="container position-relative z-1 d-flex align-items-center justify-content-center text-center" style="min-height: 100vh">
                <div class="px-3" style="max-width: 800px">
                    <img src="{{ asset('img/logo.png') }}" alt="logo" style="max-width: 300px" class="mt-5 img-fluid">
                    <p class="fs-5 mb-3 text-white">
                        ClAssign membantu pendidik menciptakan pengalaman belajar yang menarik yang dapat disesuaikan, dikelola, dan diukur. Tim Pengembang dari 3RWork for Education, ClAssign memberdayakan pendidik untuk meningkatkan dampak mereka dan mempersiapkan siswa untuk masa depan.
                    </p>
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <a href="{{ route('login', ['role' => 'pengajar']) }}" class="btn btn-outline-light w-100 my-2">Masuk sebagai Pengajar</a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('login', ['role' => 'siswa']) }}" class="btn btn-outline-light w-100 my-2">Masuk sebagai Siswa</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Features Section --}}
        <section id="features">
            <div class="container py-5">
                <div class="row text-center">
                    <div class="col my-3">
                        <h2 data-aos="fade-up">Key Features</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3" data-aos="zoom-in">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-semibold">Easy Assignment Creation</h5>
                                <p class="card-text">Teachers can easily create and schedule assignments with just a few clicks.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3" data-aos="zoom-in" data-aos-delay="100">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-semibold">Automated Submissions</h5>
                                <p class="card-text">Students can upload assignments before the deadline, and the system manages everything automatically.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3" data-aos="zoom-in" data-aos-delay="200">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-semibold">Integrated Grading</h5>
                                <p class="card-text">Teachers can grade directly in the system with structured and automatic score recaps.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3" data-aos="zoom-in">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-semibold">Deadline Reminders</h5>
                                <p class="card-text">The system notifies students when deadlines are approaching to prevent late submissions.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3" data-aos="zoom-in" data-aos-delay="100">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-semibold">Role-Based Access</h5>
                                <p class="card-text">The system adjusts features and interface based on whether the user is a teacher or student.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3" data-aos="zoom-in" data-aos-delay="200">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-semibold">Assignment & Grade History</h5>
                                <p class="card-text">Students can track their assignment status and grades to monitor learning progress.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- About Section --}}
        <section id="about" class="py-5">
            <div class="container">
                <div class="row text-center">
                    <div class="col px-3 mx-auto" style="max-width: 900px">
                        <h2 data-aos="fade-up" class="mb-3">Tentang Kami</h2>
                        <p data-aos="zoom-in">
                            ClAssign dikembangkan oleh tim mahasiswa yang peduli terhadap efisiensi dan kenyamanan dalam pendidikan digital. Misi kami adalah membantu pendidik dan siswa dalam menjalani proses pengajaran dan pembelajaran yang lebih terorganisir, menyenangkan, dan produktif.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="text-white pt-5" style="background-color: rgba(0, 0, 0, 0.8)">
        <div class="container text-md-start">
            <div class="row">
                {{-- Tentang Aplikasi --}}
                <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mb-4">
                    <h6 class="fs-4 fw-bold">ClAssign</h6>
                    <hr class="mb-2 mt-0 d-inline-block mx-auto" style="width: 100px; background-color: #ffffff; height: 2px" />
                    <p>Platform manajemen tugas digital untuk guru dan siswa. Buat dan kumpulkan tugas dengan efisien.</p>
                </div>
                {{-- Kontak --}}
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                    <h6 class="fs-4 text-uppercase fw-bold">Hubungi Kami</h6>
                    <hr class="mb-2 mt-0 d-inline-block mx-auto" style="width: 200px; background-color: #ffffff; height: 2px" />
                    <p><i class="bi bi-envelope me-2"></i> 3RWork@classign.id</p>
                    <p>
                        <a href="#" class="text-white me-3"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-linkedin"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
