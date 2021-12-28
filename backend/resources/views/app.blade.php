<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name ="crsfk-token" content="{{csrf_token()}}">
    <title>Document</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <header-component></header-component>
        <router-view v-bind:user="{{Auth::user()}}"></router-view>
        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
    </div>
<script src="{{mix('js/app.js')}}"></script>    
</body>
</html>