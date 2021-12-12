<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
</head>
<body>
    <div id='app'>
        <header>
            @include('includes.header')
        </header>
        <main>
            @yield('content')
        </main>
        <footer>
            @include('includes.footer')
        </footer>
        <script src="{{mix('js/app.js')}}"></script>
    </div>
</body>
</html>