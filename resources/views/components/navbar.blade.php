<header class="navbar">
    <div class="nav-flex">
        <div class="logo">
            <img src="{{ asset('asset/logo TA/logo navbar.png') }}" alt="tirta-amerta-logo" />
            <span class="logo-text">Tirta<span>Amerta</span></span>
        </div>

        <nav class="nav-links">
            <a href="{{ route('home') }}">Beranda</a>

            @php
                $navbars = \App\Models\Navbar::orderBy('id')->get();
            @endphp
            
            @foreach($navbars as $nav)
                <a href="{{ url($nav->slug) }}">
                    {{ $nav->name }}
                </a>
            @endforeach
        </nav>

        <div class="nav-cta">
            <a href="https://wa.me/yournumber" class="btn-outline">Konservasi</a>
        </div>

        <button class="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</header>