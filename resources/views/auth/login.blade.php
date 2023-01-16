<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ trans('common.title') }}</title>

        <link href='https://fonts.googleapis.com/css?family=Lato:400,300,700,900' rel='stylesheet' type='text/css'>
        <link href="/lib/bootstrap-3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/style-print-override.css" rel="stylesheet" media="print">
        <link href="/css/style-dashboard.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link href="/css/page_styles/login.css" rel="stylesheet">

        <link rel="shortcut icon" href="/favicon.ico?v=1">
        <link rel="icon" sizes="16x16 32x32 64x64" href="/favicon.ico?v=1">
        <link rel="icon" type="image/png" sizes="64x64" href="/favicon-64.png?v=1">

        <link href="/css/theme.css" rel="stylesheet">
    </head>
    <body>
        <div class="login-background">
            <div class="welcome-info">
                <p>{{ trans('common.name') }}</p>
                <h1>{{ trans('login.welcome') }}</h1>
            </div>
        </div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        @if (Session::has('error'))
        <div class="alert alert-danger col-md-10 col-md-offset-1">
            <center style="font-size: 15px;">
                @if (Session::get('error') == 'incorrect')
                    <b>{{ trans('auth.alert.error.incorrect.title') }}</b><br>{{ trans('auth.alert.error.incorrect.content') }}
                @elseif (Session::get('error') == 'verify')
                    <b>{{ trans('auth.alert.error.verify.title') }}</b><br>{{ trans('auth.alert.error.verify.content') }}
                @elseif (Session::get('error') == 'unknown')
                    <b>{{ trans('auth.alert.error.general.title') }}</b><br>{{ trans('auth.alert.error.general.content') }}
                @endif
            </center>
        </div>
        @endif
        @if (Session::has('passwordReset'))
            <div class="alert alert-success col-md-10 col-md-offset-1">
                <center style="font-size: 15px;">
                    <b>{{ trans('auth.alert.info.passreset.title') }}</b><br>{{ trans('auth.alert.info.passreset.content') }}
                </center>
            </div>
            @endif

            @if (Session::has('success'))
            <div class="alert alert-success col-md-10 col-md-offset-1">
                <center style="font-size: 15px;">
                    @if (Session::get('success') == 'verified')
                        <b>{{ trans('auth.alert.info.verified.title') }}</b><br>{{ trans('auth.alert.info.verified.content') }}
                    @endif
                </center>
            </div>
            @endif

            @if (Session::has('info'))
            <div class="alert alert-info col-md-10 col-md-offset-1">
                <center style="font-size: 15px;">
                    @if (Session::get('info') == 'verify')
                        <b>{{ trans('auth.alert.info.registered.title') }}</b><br>{{ trans('auth.alert.info.registered.content') }}
                    @endif
                </center>
            </div>
        @endif
        <div class="container">
            <form method="POST" action="/login">
                {!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-3">
                        <p class="title-text">{{ trans('common.login') }}</p>
                        <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="{{ trans('login.email.helper') }}">
                    </div>                    
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <input type="password" class="form-control" name="password" id="password" placeholder="{{ trans('login.password.helper') }}">
                        <input type="checkbox" id="remember" name="remember" value="true">
                        <label for="remember"> {{ trans('login.button.remember') }}</label><br>
                    </div>
                    <div class="col-md-3">
                        <button class="btn-primary login-btns" type="submit">{{ trans('common.login') }}</button>
                        <a href="/login/reset" class="btn btn-warning btn-block login-btns-small">{{ trans('login.button.password.reset') }}</a>
                    </div>
                    <div class="col-md-6">
                        <img alt="Terry Fox" src="/img/logo.png" class="tfha-image">
                    </div>
                </div>
            </form>                
        </div>
    </body>
</html>
