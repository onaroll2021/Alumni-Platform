@extends('master-layout')
@section('title', trans('common.title'))
@section('styles')
<link href="/css/page_styles/register.css" rel="stylesheet">
@endsection

@section('content')
    <div class="login-background-large">
        <div class="welcome-info-large">
            <p>{{ trans('common.name') }}</p>
            <h1>{{ trans('login.welcome') }}</h1>
            <p class="register-welcome-text">{{ trans('login.welcome.register1') }}</p>
            <p class="register-welcome-text">{{ trans('login.welcome.register2') }}</p>
        </div>
    </div>
    <div class="container" style="margin-bottom: 100px;">

    @if(count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="/register">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <div class="form-group">
                    <label class="sr-only">{{ trans('register.new_email') }}</label>
                    <input type="email" class="form-control input-register-lg" id="email" name="email" value="{{ old('email') }}" placeholder="{{ trans('register.new_email') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="email" class="form-control input-register-lg" id="email_confirmation" name="email_confirmation" placeholder="{{ trans('register.new_email_confirmation') }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                <div class="form-group">
                    <label class="sr-only">{{ trans('register.enter_password') }}</label>
                    <input type="password" class="form-control input-register-lg" id="password" name="password" placeholder="{{ trans('register.enter_password') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="password" class="form-control input-register-lg" id="password_confirmation" name="password_confirmation" placeholder="{{ trans('register.confirm_password') }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="radio col-md-6 col-md-offset-4">
                <label>
                    <input type="checkbox" name="marketing" id="marketing" value="yes" checked>
                    {{ trans('register.receive_newsletter') }}
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <center><p style="margin-top: 15px;">{!! trans('register.agree_policy') !!}</p></center>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 col-md-offset-8" style="margin-top: 15px;">
                <button type="submit" class="btn btn-submit btn-block btn-success btn-lg">{{ trans('register.register_button') }}</button>
            </div>    
        </div>
        <div class="row">
            <div class ="col-md-10 col-md-offset-1" style="margin-top: 50px; text-align: center;">
                <span class="help_info">{{ trans('register.help_info') }}</span><span class="help_info" style="text-decoration: underline; color: #337AB7;">{{ trans('register.help_info_email') }}</span>
            </div>
        </div>
    </form>
    </div>
@endsection
