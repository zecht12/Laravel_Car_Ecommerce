<!DOCTYPE html>
<html>
    <head>
        <title>@yield('page_title', 'Default Title')</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <script src="https://kit.fontawesome.com/b2c786f9ad.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">


        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>

        <style>
            .btn-outline-primary:hover .fa-plus {
                color: #fff !important;
            }
            .card:hover {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease;
            }
        </style>
    </head>

    <body style="background-color: rgb(233, 233, 233); width:100%; margin: 0;">
    @php
        use Illuminate\Support\Facades\Auth;
        use Illuminate\Support\Str;

        $user = Auth::user();
        $imagePath = 'user-solid.svg';

        if ($user && $user->photo) {
            if (is_string($user->photo) && str_starts_with($user->photo, '[')) {
                $decoded = json_decode($user->photo, true);
                if (json_last_error() === JSON_ERROR_NONE && isset($decoded[0])) {
                    $imagePath = 'storage/' . $decoded[0];
                }
            } elseif (Str::startsWith($user->photo, 'http')) {
                $imagePath = $user->photo;
            } else {
                $imagePath = 'storage/' . $user->photo;
            }
        }

    @endphp

        <header>
            @include('components.navbar')
        </header>
        <div style="height: 100%">
            @yield('main_content')
        </div>
    </body>
    <script>
        $(function () {
            $('.datepicker').datepicker({
                format: "mm/dd/yyyy",
                autoclose: true,
                todayHighlight: true,
                orientation: "bottom"
            });
        });
    </script>
</html>
