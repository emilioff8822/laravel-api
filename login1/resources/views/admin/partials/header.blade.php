<header class="bg-dark">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.home') }}">
                BOOLPRESS
            </a>


            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" target="_blank" href="{{ route('home') }}">Vai al sito</a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Registrati</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown d-flex">

                            <form action="{{ route('admin.posts.index') }}" class="d-flex" method="GET">
                                <input type="text" class="form-control me-2" name="search" type="text"
                                    placeholder="Post da cercare">
                                <button class="btn btn-primary me-3"><i class="fa fa-search"></i></button>


                            </form>

                            <span class="text-white" me-2>{{ Auth::user()->name }}</span>


                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>
