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
        <div class="container" style="margin-bottom: 100px;">
            <div class="row">
                <div class="col-md-4">
                  <a href="/login" class="btn-primary login-btns">{{ trans('common.login') }}</a>
                  <a href="/register" class="btn-success login-btns">{{ trans('common.register') }}</a>
                </div>
                <div class="col-md-8">
                    <img alt="Terry Fox" src="/img/logo.png" class="tfha-image">
                </div>
            </div>
        </div>
    </body>
</html>
