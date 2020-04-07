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
@include('partials.__import_modal')
<div id="app">
    <nav class="custom-header navbar navbar-expand-md navbar-dark shadow-sm">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ URL::asset('storage/p2p-logo_White.svg') }}"
                 width="120px" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @auth
            <ul class="navbar-nav mr-auto">
                @can('viewAny', App\Entities\Invoice::class)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle
                                  {{ request()->segment(1) == 'facturas' ? 'active' : '' }}"
                           href="#" data-toggle="dropdown">
                            <i class="fa fa-file-invoice-dollar"></i> {{ __("Facturas") }}
                        </a>
                        <div class="dropdown-menu">
                            <a class="btn btn-info text-info dropdown-item"
                               href="{{ route('invoices.index') }}">
                                <i class="fa fa-eye"></i> {{ __("Ver") }}
                            </a>
                            @can('create', App\Entities\Invoice::class)
                                <a href="{{ route('invoices.create') }}"
                                   class="btn btn-success text-success dropdown-item">
                                    <i class="fa fa-plus"></i> {{ __("Crear") }}
                                </a>
                            @endcan
                            @can('import', App\Entities\Invoice::class)
                                <button type="button" class="btn btn-secondary text-secondary dropdown-item"
                                        data-toggle="modal"
                                        data-target="#importModal"
                                        data-model="App\Entities\Invoice"
                                        data-import_model="App\Imports\InvoicesImport">
                                    <i class="fa fa-file-excel"></i> {{ __("Importar") }}
                                </button>
                            @endcan
                        </div>
                    </li>
                @endcan
                @can('viewAny', App\Entities\Client::class)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle
                                  {{ request()->segment(1) == 'clientes' ? 'active' : '' }}"
                           href="#" data-toggle="dropdown">
                            <i class="fa fa-users"></i> {{ __("Clientes") }}
                        </a>
                        <div class="dropdown-menu">
                            <a class="btn btn-info text-info dropdown-item"
                               href="{{ route('clients.index') }}">
                                <i class="fa fa-eye"></i> {{ __("Ver") }}
                            </a>
                            @can('create', App\Entities\Client::class)
                                <a href="{{ route('clients.create') }}"
                                   class="btn btn-success text-success dropdown-item">
                                    <i class="fa fa-plus"></i> {{ __("Crear") }}
                                </a>
                            @endcan
                            @can('import', App\Entities\Client::class)
                                <button type="button" class="btn btn-secondary text-secondary dropdown-item"
                                        data-toggle="modal"
                                        data-target="#importModal"
                                        data-model="App\Entities\Client"
                                        data-import_model="App\Imports\ClientsImport">
                                    <i class="fa fa-file-excel"></i> {{ __("Importar") }}
                                </button>
                            @endcan
                        </div>
                    </li>
                @endcan
                @can('viewAny', App\Entities\Product::class)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle
                                  {{ request()->segment(1) == 'productos' ? 'active' : '' }}"
                               href="#" data-toggle="dropdown">
                                <i class="fa fa-users"></i> {{ __("Productos") }}
                            </a>
                            <div class="dropdown-menu">
                                <a class="btn btn-info text-info dropdown-item"
                                   href="{{ route('products.index') }}">
                                    <i class="fa fa-eye"></i> {{ __("Ver") }}
                                </a>
                                @can('create', App\Entities\Product::class)
                                    <a href="{{ route('products.create') }}"
                                       class="btn btn-success text-success dropdown-item">
                                        <i class="fa fa-plus"></i> {{ __("Crear") }}
                                    </a>
                                @endcan
                                @can('import', App\Entities\Product::class)
                                    <button type="button" class="btn btn-secondary text-secondary dropdown-item"
                                            data-toggle="modal"
                                            data-target="#importModal"
                                            data-model="App\Entities\Product"
                                            data-import_model="App\Imports\ProductsImport">
                                        <i class="fa fa-file-excel"></i> {{ __("Importar") }}
                                    </button>
                                @endcan
                            </div>
                        </li>
                @endcan
                @can('viewAny', App\Entities\Report::class)
                    <li class="nav-item dropdown">
                        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle
                           {{ request()->segment(1) == 'reportes' ? 'active' : '' }}">
                            <i class="fa fa-registered"></i> {{ __("Reportes") }}
                        </a>
                        <div class="dropdown-menu">
                            @can('viewGeneral', App\Entities\Report::class)
                                <a href="{{ route('reports.general') }}" class="dropdown-item">
                                    <i class="fa fa-registered"></i> {{ __("Generales") }}
                                </a>
                            @endcan
                            @can('viewGenerated', App\Entities\Report::class)
                                <a class="btn btn-primary text-primary dropdown-item"
                                   href="{{ route('reports.generated') }}">
                                    <i class="fa fa-download"></i> {{ __("Generados") }}
                                </a>
                            @endcan
                        </div>
                    </li>
                @endif
            </ul>
            <ul class="navbar-nav ml-auto">
                <notifications></notifications>
                @can('viewAny', App\Entities\User::class)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle
                                  {{ request()->segment(1) == 'usuarios' ? 'active' : '' }}"
                           href="#" data-toggle="dropdown">
                            <i class="fa fa-users"></i> {{ __("Usuarios") }}
                        </a>
                        <div class="dropdown-menu">
                            <a class="btn btn-info text-info dropdown-item"
                               href="{{ route('users.index') }}">
                                <i class="fa fa-eye"></i> {{ __("Ver") }}
                            </a>
                            @can('create', App\Entities\User::class)
                                <a href="{{ route('users.create') }}"
                                   class="btn btn-success text-success dropdown-item">
                                    <i class="fa fa-plus"></i> {{ __("Crear") }}
                                </a>
                            @endcan
                            @can('import', App\Entities\User::class)
                                <button type="button" class="btn btn-secondary text-secondary dropdown-item"
                                        data-toggle="modal"
                                        data-target="#importModal"
                                        data-model="App\Entities\User"
                                        data-import_model="App\Imports\UsersImport">
                                    <i class="fa fa-file-excel"></i> {{ __("Importar") }}
                                </button>
                            @endcan
                        </div>
                    </li>
                @endcan
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ auth()->user()->fullname }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @can('view', auth()->user())
                            <a class="dropdown-item" href="{{ route('users.show', auth()->user()) }}">
                                <i class="fa fa-user-tie"></i> {{ __("Mi perfil") }}
                            </a>
                        @endcan
                        @can('update', auth()->user())
                            <a class="dropdown-item" href="{{ route('users.edit', auth()->user()) }}">
                                <i class="fa fa-user-edit"></i> {{ __("Editar perfil") }}
                            </a>
                        @endcan
                        @can('update', auth()->user())
                            <a class="dropdown-item" href="{{ route('users.edit-password', auth()->user()) }}">
                                <i class="fa fa-key"></i> {{ __("Editar contraseña") }}
                            </a>
                        @endcan
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out-alt"></i> {{ __('Cerrar sesión') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
            @endauth
        </div>
    </nav>
    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>
</div>
<script src="{{ asset(mix('js/manifest.js')) }}"></script>
<script src="{{ asset(mix('js/vendor.js')) }}"></script>
<script src="{{ asset(mix('js/app.js')) }}"></script>
<script src="{{ asset(mix('js/import-modal.js')) }}"></script>
@stack('scripts')
@include('sweet::alert')
</body>
</html>
