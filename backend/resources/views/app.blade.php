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
        <router-view></router-view>
    </div>
<script src="{{mix('js/app.js')}}"></script>    
</body>
</html>