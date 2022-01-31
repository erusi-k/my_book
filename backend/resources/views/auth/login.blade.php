@extends('layouts.base')
@section('content')      

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4 form_error" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="login">
                    <div class="login_title">
                        <p class="login_title_content">ログイン</p>
                    </div>
                <div class="login-input" >
                    <x-input class="login-input_content" type="email" name="email" :value="old('email')" placeholder="メールアドレス" required autofocus />
                </div>
                <div class="login-input">
                    <x-input class="login-input_content" 
                                    type="password"
                                    name="password"
                                    placeholder="パスワード"
                                    required autocomplete="current-password" />
                </div>
                <div class="login-btn">
                    <button class="login-btn_content">
                        {{ __('ログイン') }}
                    </button>        
                </div>
            </div>   
        </form>
        <p class="link">アカウントをお持ちでない方はこちらから</p>
        <a class="link-url" href="{{url('/register')}}">会員登録</a>
@endsection
