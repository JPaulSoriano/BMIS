
<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="BMIS">
        <meta name="author" content="Arzatech">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>BMIS</title>

        <!-- Fonts -->
        <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

        <!-- Favicon -->
        <link href="{{ asset('img/favicon.png') }}" rel="icon" type="image/png">
    </head>
<body>
    <div class="border d-flex justify-content-center" style="height: 100vh;">
        <div class="card align-self-center">
                <div class="card-body p-4 text-center">
                    <h4 class="card-title">You are unauthorized! Entry forbidden!</h4>
                    <p class="card-text">
                        <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </p>
                </div>
        </div>
    </div>
</div>
</body>
</html>
