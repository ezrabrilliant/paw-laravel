<nav class="py-4 navbar navbar-expand-lg navbar-dark fixed-top navbar-pawcare">
    <div class="container px-4 px-lg-5 text-white">
        <a class="navbar-brand" style="height: 52px;" href="{{ auth()->check() && auth()->user()->admin_access === 1 ? url('/admin') : url('/') }}">
            PAWCARE
            <img src="{{ asset('images/pawcare.png') }}" alt="PAWCARE Logo" class="img-fluid" style="max-height: 50px;margin-top: -2px;height: 100%;object-fit: cover;">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse align-items-center" id="navbarSupportedContent">
            <!-- Check if the user is authenticated -->
            @if(auth()->check())
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 align-items-center">

                    @if (auth()->user()->admin_access === 1)
                        <li class="nav-item me-4"><a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" aria-current="page" href="{{ url('/admin') }}">ADMIN DASHBOARD</a></li>
                    @else
                        <li class="nav-item me-4"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" aria-current="page" href="{{ url('/') }}">HOME</a></li>
                        <li class="nav-item me-4"><a class="nav-link {{ request()->is('grooming') ? 'active' : '' }}" aria-current="page" href="{{ url('/grooming') }}">GROOMING</a></li>
                        <li class="nav-item me-4"><a class="nav-link {{ request()->is('penitipan') ? 'active' : '' }}" aria-current="page" href="{{ url('/penitipan') }}">PENITIPAN</a></li>
                        <li class="nav-item me-4"><a class="nav-link {{ request()->is('history') ? 'active' : '' }}" aria-current="page" href="{{ url('/history') }}">HISTORY ORDER</a></li>
                        <li class="nav-item me-4"><a class="nav-link" aria-current="page" href="{{ url('/whatsapp') }}">CHAT DRIVER</a></li>
                        <li class="nav-item me-4"><a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">ABOUT</a></li>
                    @endif
                </ul>
                <ul class="navbar-nav align-items-center">
                    <ul class="nav-link dropdown-toggle">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ auth()->check() && auth()->user()->admin_access === 1 ? url('/admin') : '/' }}" id="userDropdown" role="button">
                                Welcome, {{ auth()->user()->username }}
                            </a>
                            <ul class="nav-pawcare-dropdown dropdown-menu nav-pawcare border border-white" style="padding:0;" aria-labelledby="userDropdown">
                                @if(auth()->check() && auth()->user()->admin_access === 1)

                                @else
                                    <li><a class="dropdown-item dropdown-top" href="/edit-profile">
                                        <i class="bi bi-person-circle"></i> Edit Profile</a></li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button class="dropdown-item dropdown-bottom" type="submit">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>


                        </li>
                    </ul>
                </ul>
            @else
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 align-items-center">
                    <li class="nav-item me-4"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" aria-current="page" href="{{ url('/') }}">HOME</a></li>
                    <li class="nav-item me-4"><a class="nav-link" aria-current="page" href="{{ url('/login') }}">GROOMING</a></li>
                    <li class="nav-item me-4"><a class="nav-link" aria-current="page" href="{{ url('/login') }}">PENITIPAN</a></li>
                    <li class="nav-item me-4"><a class="nav-link" href="{{ url('/about') }}">ABOUT</a></li>
                </ul>
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item me-4">
                        <a href="{{ url('/login') }}" class="nav-link">
                            <button class="btn btn-outline-light {{ request()->is('login') ? 'active' : '' }}" type="button">Login</button>
                        </a>
                    </li>
                    <li class="nav-item me-4">
                        <a href="{{ url('/signup') }}" class="nav-link">
                            <button class="btn btn-outline-light {{ request()->is('signup') ? 'active' : '' }}" type="button">Sign up</button>
                        </a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</nav>
