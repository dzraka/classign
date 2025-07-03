<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'ClAssign')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <style>
      body {
        overflow-x: hidden;
      }
      .sidebar-lg {
        position: fixed;
        left: 0;
        top: 56px;
        width: 200px;
        height: calc(100% - 56px);
        background-color: #050d1c;
        z-index: 1000;
      }
      .content-lg {
        transition: margin-left 0.3s ease;
      }
      @media (min-width: 992px) {
        .content-lg {
          margin-left: 220px;
        }
        .sidebar-hidden {
          display: none !important;
        }
        .content-lg.full {
          margin-left: 0 !important;
        }
      }
    </style>
    @stack('styles')
  </head>
  <body>
    <nav class="navbar fixed-top navbar-dark" style="background-color: #050d1c; z-index: ">
      <div class="container-fluid">
        <button class="btn d-none d-lg-block me-2" id="toggleSidebar" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <button class="navbar-toggler d-lg-none me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand me-auto" href=""> ClAssign <span class="navbar-text">for education</span> </a>
        <a href="#" class="btn btn-outline-light rounded-5 mx-2 d-none d-lg-block" id="createClass">
        @if(auth()->user() && auth()->user()->role === 'pengajar')
            <i class="bi bi-plus-lg"></i>
        @else
            <i class="bi bi-plus-lg"></i>
        @endif
        </a>
        <div class="navbar-text text-white d-none d-lg-block ms-3 fw-bold fs-3">
          @yield('page-title', 'Beranda')
        </div>
      </div>
    </nav>

    <div id="sidebar" class="sidebar-lg d-none d-lg-block text-white">
      <div class="row my-4">
        <ul class="nav flex-column px-3">
          <li class="nav-item">
            <a class="nav-link text-white mb-3 btn btn-outline-dark rounded-3 text-start" href="#"><i class="bi bi-person me-2"></i> Profil </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white mb-3 btn btn-outline-dark rounded-3 text-start" href="#"><i class="bi bi-house me-2"></i> Beranda </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white mb-3 btn btn-outline-dark rounded-3 text-start" href="#"><i class="bi bi-calendar me-2"></i> Kalender </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white mb-3 btn btn-outline-dark rounded-3 text-start" href="#"><i class="bi bi-archive me-2"></i> Arsip </a>
          </li>
        </ul>
      </div>
      <div class="row position-absolute bottom-0 mb-5">
        <ul class="nav flex-column px-3">
          <li class="nav-item fs-4">
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin keluar?')">
              @csrf
              <button type="submit" class="nav-link text-white d-flex align-items-center px-3 btn btn-link" style="text-decoration:none;">
                <i class="bi bi-box-arrow-left me-3"></i> Keluar
              </button>
            </form>
          </li>
        </ul>
      </div>
    </div>

    <div id="sidebarMobile" class="sidebar-lg d-lg-none text-white collapse" style="background-color: #050d1c; position: fixed; top: 56px; left: 0; width: 300px; height: calc(100% - 56px); z-index: 1050; overflow-y: auto;">
      <div class="row my-5">
        <ul class="nav flex-column px-3">
          <li class="nav-item">
            <a class="nav-link text-white" href="#"><i class="bi bi-person me-2"></i> Profil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="#"><i class="bi bi-house me-2"></i> Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="#"><i class="bi bi-calendar-event me-2"></i> Kalender</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="#"><i class="bi bi-archive me-2"></i> Arsip</a>
          </li>
          <li class="nav-item mt-4 text-center">
            <a href="#" class="btn btn-outline-light rounded-3 w-75" id="createClass">
              <i class="bi bi-plus-lg"></i> Gabung Kelas
            </a>
          </li>
        </ul>
      </div>
      <div class="row position-absolute bottom-0 mb-5 w-100">
        <ul class="nav flex-column px-3">
          <li class="nav-item fs-4">
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin keluar?')">
              @csrf
              <button type="submit" class="nav-link text-white d-flex align-items-center px-3 btn btn-link" style="text-decoration:none;">
                <i class="bi bi-box-arrow-left me-3"></i> Keluar
              </button>
            </form>
          </li>
        </ul>
      </div>
    </div>

    <!-- Konten utama -->
    <div id="mainContent" class="content-lg p-4 mt-5">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.getElementById("toggleSidebar");
        const sidebarMobile = document.getElementById("sidebarMobile");
        if (toggleBtn) {
          toggleBtn.addEventListener("click", function () {
            const sidebar = document.getElementById("sidebar");
            const content = document.getElementById("mainContent");
            sidebar.classList.toggle("sidebar-hidden");
            content.classList.toggle("full");
          });
        }
        // Toggle sidebar mobile
        const navbarToggler = document.querySelector('.navbar-toggler.d-lg-none');
        if (navbarToggler && sidebarMobile) {
          navbarToggler.addEventListener('click', function () {
            sidebarMobile.classList.toggle('show');
          });
        }
        // Optional: close sidebar mobile when clicking outside
        document.addEventListener('click', function(event) {
          if (sidebarMobile && sidebarMobile.classList.contains('show')) {
            if (!sidebarMobile.contains(event.target) && !navbarToggler.contains(event.target)) {
              sidebarMobile.classList.remove('show');
            }
          }
        });
      });
    </script>
    @stack('scripts')
  </body>
</html>