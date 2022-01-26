<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name ="crsfk-token" content="{{csrf_token()}}">
    <title>Mybook</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="header">
            <header-component></header-component>
            <div class="content">
                <div class="logout">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                            this.closest('form').submit();">
                            <div class="logout-content"> 
                                <img src="/images/logout.png">
                                {{ __('') }}
                            </div>
                        </x-dropdown-link>
                    </form>
                </div>
            </div>
        </div>
        <router-view v-bind:user="{{Auth::user()}}"></router-view>
        
    </div>
<script src="{{mix('js/app.js')}}"></script>  
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>  
</body>
</html>