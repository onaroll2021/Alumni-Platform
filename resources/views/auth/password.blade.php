@extends('master-layout2')

@section('title', 'Password Reset - Terry Fox Humanitarian Award Program')

@section('styles')
<link href="/css/page_styles/password_reset.css" rel="stylesheet">
@endsection

@section('content')
<div class="container password-reset-background">
    <div class="row">
        <div class="col-lg-offset-1 col-lg-6 col-md-offset-2 col-md-5">
            <div class="panel panel-dialog panel-default" style="border-radius: 10px;" >
                <div class="panel-body">
                    <center><img alt="Terry Fox" src="/img/logo.png"></center>
                    <center><h2 style="margin-top: 25px;">{{ trans('common.password_reset') }}</h2></center>
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
                    @if (Session::has('success'))
                    <div class="alert alert-success">
                        <center><h4>Password reset link sent: </h4><p>Please check your mailbox for instructions. Allow 10 -15 minutes for the message to arrive.</p><p>If you do not receive an email, please contact us <u>info@terryfoxawards.ca</u></p></center>
                    </div>
                    @else
                        <form method="POST" action="/login/reset">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label>{{ trans('common.email_address') }}</label>
                                <input type="email" class="form-control input-lg" id="email" name="email" value="{{ old('email') }}" placeholder={{ trans('common.enter_email_address') }}>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-submit btn-block btn-primary">{{ trans('common.send_reset_link') }}</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
