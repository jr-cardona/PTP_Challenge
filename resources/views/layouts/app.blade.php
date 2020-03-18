<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('css/custom.css') }}">
</head>
<body style="background-color: floralwhite">
    @stack('modals')
    <div id="app" class="container">
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm" style="background-color: #0c5460;">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="https://dev.placetopay.com/web/wp-content/uploads/2019/02/p2p-logo_White.svg" class="attachment-120x120 size-120x120" width="120px">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                @auth
                <ul class="navbar-nav mr-auto">
                    @can('index', App\Invoice::class)
                        <li class="nav-item">
                            <a href="{{ route('invoices.index') }}"
                               class="nav-link {{ request()->segment(1) == 'facturas' ? 'active' : '' }}">
                                <i class="fa fa-file-invoice-dollar"></i> {{ __("Facturas") }}
                            </a>
                        </li>
                    @endcan
                    @can('index', App\Client::class)
                        <li class="nav-item">
                            <a href="{{ route('clients.index') }}"
                               class="nav-link {{ request()->segment(1) == 'clientes' ? 'active' : '' }}">
                                <i class="fa fa-users"></i> {{ __("Clientes") }}
                            </a>
                        </li>
                    @endcan
                    @can('index', App\Product::class)
                        <li class="nav-item">
                            <a href="{{ route('products.index') }}"
                               class="nav-link {{ request()->segment(1) == 'productos' ? 'active' : '' }}">
                                <i class="fa fa-barcode"></i> {{ __("Productos") }}
                            </a>
                        </li>
                    @endcan
                    @if(auth()->user()->can('View any reports') || auth()->user()->hasRole('Admin'))
                        <li class="nav-item">
                            <a href="{{ route('reports.index') }}"
                               class="nav-link {{ request()->segment(1) == 'reportes' ? 'active' : '' }}">
                                <i class="fa fa-registered"></i> {{ __("Reportes") }}
                            </a>
                        </li>
                    @endif
                </ul>
                @endauth
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        @can('index', App\User::class)
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}"
                                   class="nav-link {{ request()->segment(1) == 'usuarios' ? 'active' : '' }}">
                                    <i class="fa fa-user-tie"></i> {{ __("Usuarios") }}
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @can('view', auth()->user())
                                    <a class="dropdown-item" href="{{ route('users.show', auth()->user()) }}">
                                        <i class="fa fa-user-tie"></i> {{ __("Mi perfil") }}
                                    </a>
                                @endcan
                                @can('edit', auth()->user())
                                    <a class="dropdown-item" href="{{ route('users.edit', auth()->user()) }}">
                                        <i class="fa fa-user-edit"></i> {{ __("Editar perfil") }}
                                    </a>
                                @endcan
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out-alt"></i> {{ __('Cerrar sesión') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @include('partials.session-message')
                @yield('content')
            </div>
        </main>
    </div>
    <script src="{{ asset(mix('js/manifest.js')) }}"></script>
    <script src="{{ asset(mix('js/vendor.js')) }}"></script>
    <script src="{{ asset(mix('js/app.js')) }}"></script>
    @stack('scripts')
</body>
</html>
