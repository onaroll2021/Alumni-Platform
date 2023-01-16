@extends('master-layout')

@section('title', 'Password Reset - Terry Fox Humanitarian Award Program')

@section('styles')
<link href="/css/style-login-register.css" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-offset-3 col-lg-6 col-md-offset-2 col-md-8">

            <div class="panel panel-dialog panel-default">
                <div class="panel-body">
                    <center><img alt="Terry Fox" src="/img/logo.png"></center>
                    <center><h1 style="margin-top: 25px;">{{ trans('auth.reset') }}</h1></center>
                    <hr>

                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if (isset($invalid))
                    <div class="alert alert-danger">
                        <center>Reset token is invalid or has expired.</center>
                    </div>
                    @else
                    <form method="POST" action="">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label>{{ trans('auth.title.password') }}</label>
                            <input type="password" class="form-control input-lg" id="password" name="password" placeholder="{{ trans('auth.placeholder.password') }}">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control input-lg" id="password_confirmation" name="password_confirmation" placeholder="{{ trans('auth.placeholder.password_confirm') }}">
                        </div>
                        <hr>
                        <button type="submit" class="btn btn-submit btn-block btn-primary">{{ trans('auth.reset.button.reset') }}</button>
                    </form>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
