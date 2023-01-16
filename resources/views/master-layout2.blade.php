<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>@yield('title')</title>

	<link href='https://fonts.googleapis.com/css?family=Lato:400,300,700,900' rel='stylesheet' type='text/css'>
	<link href="/lib/bootstrap-3.3.5/css/bootstrap.min.css" rel="stylesheet">
	<link href="/css/style.css" rel="stylesheet">
	<link href="/css/style-print-override.css" rel="stylesheet" media="print">
	<link href="/css/style-dashboard.css" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

	<link rel="shortcut icon" href="/favicon.ico?v=1">
	<link rel="icon" sizes="16x16 32x32 64x64" href="/favicon.ico?v=1">
	<link rel="icon" type="image/png" sizes="64x64" href="/favicon-64.png?v=1">

    @yield('styles')

	<link href="/css/theme.css" rel="stylesheet">
</head>
<body>
	<section id="navigation">
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container">
                <div class="row">
                <div class="col-md-offset-8">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
						<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="http://terryfoxawards.ca">
						<img alt="Terry Fox" src="/img/logo.png">
					</a>
                </div>
				</div>

                <div class="col-md-offset-10">
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								@if (Auth::check())
								<li class="{{ (Request::segment(1) == 'dashboard') ? 'active' : '' }}"><a href="/dashboard"><i class="fa fa-sign-out"></i> {{ trans('common.dashboard') }}</a></li>
								<li class="{{ (Request::segment(1) == 'logout') ? 'active' : '' }}"><a href="/logout"><i class="fa fa-sign-out"></i> {{ trans('common.logout') }}</a></li>
								@else
								<li class="{{ (Request::segment(1) == 'login') ? 'active' : '' }}"><a href="/login">{{ trans('auth.login') }}</a></li>
								<li class="{{ (Request::segment(1) == 'register') ? 'active' : '' }}"><a href="/register">{{ trans('auth.register') }}</a></li>
								@endif
							</ul>
						</li>
					</ul>
                    {{-- <ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-globe"></i> <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li class="{{ (App::getLocale() == 'en') ? 'active' : '' }}"><a href="/locale/english">English</a></li>
								<li class="{{ (App::getLocale() == 'fr') ? 'active' : '' }}"><a href="/locale/french">Français</a></li>
							</ul>
						</li>
					</ul> --}}
				</div>
                </div>
			</div>

			<div id="notification" class="title-banner bg-success" style="display: none; background-color: #28a745; color: white; padding-top: 10px;">
				<div class="container">
					<a style="color: white;" href="#" onclick="closeNotification();" class="pull-right"><i class="fa fa-times"></i></a>
					<center><p id="notification-text" style="font-size: 17px; font-weight: 500;"></p></center>

				</div>
			</div>
            </div>
		</nav>
	</section>

    @yield('content')

	<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="/lib/bootstrap-3.3.5/js/bootstrap.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>

	@yield('javascript')

</body>
</html>
