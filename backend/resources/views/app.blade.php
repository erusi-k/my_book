<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name ="crsfk-token" content="{{csrf_token()}}">
    <title>Mybook</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" >
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
</head>
<body>
    <div id="app">
        <div class="content">
            <div class="logout">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault();
                        this.closest('form').submit();">
                        <div class="logout-content">
                            <span>
                                {{ __('ログアウト') }}
                            </span> 
                        </div>
                    </x-dropdown-link>
                </form>
            </div>
        </div>  
        <header-component></header-component>
        <router-view v-bind:user="{{Auth::user()}}"></router-view>
    </div>
<script src="{{mix('js/app.js')}}"></script>  
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>  
</body>
</html>