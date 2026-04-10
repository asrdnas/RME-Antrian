<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('asset/css/Home.css') }}" />
     @yield('styles')
    <link rel="icon" type="image/png" href="{{ asset('asset/logo TA/logo klinik.png') }}" />
  </head>
  <body>
    <!-- navbar -->
    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    <!-- Footer-->
    @include('components.footer')

    <!-- overlay konsul -->
    <a href="https://wa.me/6281249340040" class="fab-whatsapp">
      <i class="fab fa-whatsapp"></i>
      <span>Konsultasi</span>
    </a>

    <script src="{{ asset ('asset/js/dokter.js') }}"></script>
    <script src="{{ asset ('asset/js/facility.js') }}"></script>
    <script src="{{ asset ('asset/js/menu-nav.js') }}"></script>
    <script src="{{ asset ('asset/js/team.js') }}"></script>
    <script src="{{ asset ('asset/js/welcoming.js') }}"></script>

     {{-- JS khusus halaman --}}
    @yield('scripts')
  </body>
</html>
