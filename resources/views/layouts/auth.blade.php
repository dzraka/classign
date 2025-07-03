<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <style>
      body {
        font-family: "Poppins", sans-serif;
      }
    </style>
    <title>@yield('title', 'Masuk')</title>
</head>
<body style="background-image: url({{ $__env->yieldContent('bg-img', asset('img/bg-signin.jpg')) }}); background-position: center; background-size: cover; background-repeat: no-repeat">
    @if(Auth::check())
        <script>window.location.href = '{{ url('/app') }}';</script>
    @else
        <div class="container-fluid position-relative min-vh-100">
            <div class="row lh-1">
                <div class="my-4 text-white">
                    <p class="fw-semibold fs-5">ClAssign</p>
                    <hr class="rounded-4" style="width: 13rem; border: 1px solid; opacity: 1" />
                    <p>3rwork@classign.id</p>
                </div>
            </div>
            @yield('content')
            <!-- copyright -->
            <div class="row text-center mt-3">
                <div class="col">
                    <p class="text-white small fw-light">Copyright @3rwork2025 | Privacy Policy</p>
                </div>
            </div>
        </div>
    @endif
</body>
</html>
