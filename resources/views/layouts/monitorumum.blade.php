<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Antrian Umum</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset('asset/css/umum.css') }}" />
    <link rel="icon" type="image/png" href="{{ asset('asset/logo TA/LOGO KLINIK PRATAMA TIRTA AMERTA NEW.png') }}">
     @livewireStyles
  </head>
  <body>
     @yield('content')

   {{-- wajib untuk Livewire --}}
   @livewireScripts
  </body>
</html>
