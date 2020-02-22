<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title')</title>
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <link rel="stylesheet" href="{{ mix('css/auth.css') }}">
    </head>
    <body>
        <div class="container">
            <div class="d-flex justify-content-center h-100">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">@yield('title')</h3>
                    </div>
                    <div class="card-body">
                        @yield('body')
                    </div>
                    <div class="card-footer">
                        @yield('footer')
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
