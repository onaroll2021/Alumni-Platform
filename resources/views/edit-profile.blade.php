@extends('master-layout2')
@section('title', 'Application Dashboard - Terry Fox Humanitarian Award Program')

@section('styles')
<link href="/css/style-edit-profile.css" rel="stylesheet">
<link href="/css/bootstrap.vertical-tabs.min.css" rel="stylesheet">
<link href="/css/style-profile.css" rel="stylesheet">
<link href="/css/style-settingsText.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<style media="screen">
.table > tbody > tr.success > td {
    background-color: #dff0d8;
}
.nav-tabs > li > a{
    font-size: 18px;
    -webkit-backface-visibility: hidden;
    transform: translate3d(0,0,0);
}
.text {
	line-height: 1.6;
}
.fields input, label {
	margin-top: 10px;
}
.fields .control-label {
	padding-top: 5px;
}
.fields {
	display: none;
}
</style>
@endsection

@section('content')
<?php
use App\Classes\Common;
 ?>
 
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-success custom-success" style="display: none;">
                <center id="custom-success-text" style="font-size: 16px;"></center>
            </div>
            <div class="alert alert-danger custom-error" style="display: none;">
                <center id="custom-error-text" style="font-size: 16px;"></center>
            </div>
        @if(Session::has('success'))
            <div class="alert alert-success alert-autohide" style="display: none;">
                <center style="font-size: 16px;">{{ Session::get('success') }}</center>
            </div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger alert-autohide" style="display: none;">
                <center style="font-size: 16px;"><b>{{ Session::get('error') }}</b></center>
            </div>
        @endif
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        </div>
    </div>
    <?php
	$data = DB::table('users')
	->where('id', Auth::User()->id)
	->first();
    ?>
    <?php
    $user_basic_info = DB::table('users_basic_info')
    ->where('user_id', Auth::User()->id)
    ->first();
    ?>
    @if ($data == null)

    @else
    <form method="POST" action="/edit-profile">
        {!! csrf_field() !!}
            <div class="row">
                <div class="col-sm-5 pull-right">
                    <h3>{{ trans('edit-profile.edit.helper') }}</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 pull-right">
                    <button type="submit" class="btn btn-success edit-btns">YES <i class="fa fa-share" aria-hidden="true"></i></button>
                    <a class="btn btn-danger edit-btns" href="/dashboard">NO <i class="fa fa-times" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-md-4">
                    <div class="headshot">
                        <img src="dashboard/avatar" class="img-responsive" id="avatar-img">
                        <button type="button" class="icon-camera" style="margin-top: 20px;" onclick="uploadPicture(event);">
                            <i class="fa fa-camera fa-2x" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="col-sm-8 cold-md-8 info">
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-3 col-md-offset-1">
                            <label for="name_first">{{ trans('common.name_first') }}</label>
                            <input type="text" class="form-control form-input" name="name_first" id="name_first" value="{{ old('name_first', $user_basic_info->name_first) }}">
                        </div>
                        <div class="col-md-3">
                            <label for="name_last">{{ trans('common.name_last') }}</label>
                            <input type="text" class="form-control form-input" name="name_last" id="name_last" value="{{ old('name_last', $user_basic_info->name_last)}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-1">
                            <label for="pronouns">{{ trans('common.pronouns') }}</label>
                            <input type="text" class="form-control form-input" name="pronouns" id="pronouns" value="{{ old('pronouns', $user_basic_info->pronouns)}}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-1">
                            <label for="location">{{ trans('common.location') }}</label>
                            <input type="text" class="form-control form-input" name="location" id="location" value="{{ old('location', $user_basic_info->location) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-1">
                            <label for="university_name">{{ trans('common.university') }}</label>
                            <input type="text" class="form-control form-input" name="university_name" id="university_name" value="{{ old('university_name', $user_basic_info->university_name) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-md-offset-1">
                            <label for="diploma">{{ trans('common.diploma') }}</label>
                            <input type="text" class="form-control form-input" name="diploma" id="diploma" value="{{ old('diploma', $user_basic_info->diploma) }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="edit-short-bio col-md-12">
                    <label class="form-text-area-label" for="short_bio">{{ trans('common.bio') }}</label>
                    <textarea class="form-control form-input form-text-area form-limit-words" words="500" id="short_bio" name="short_bio">{{ old('short_bio', $user_basic_info->short_bio) }}</textarea>
                    <div class="edit-short-bio-word-count-button">
                        <button type="button" id="short_bio_words" class="btn btn-default btn-block form-input"></button>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top: 5rem; background-color: #F8F9F9; border-top-right-radius: 30px;">
                <div class="col-md-3" style="margin-top: 30px;">
                    <div class="panel panel-default" style="border-radius: 20px; border-color: #7b7d7d">
                        <div class="panel-heading" style="border-radius: 20px 20px 0% 0%;">
                            {{ trans('dashboard.about_me') }} 
                        </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <span class="glyphicon glyphicon-user" aria-hidden="true" style="font-size: 28px; display:flex; "></span>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p style="font-size: 14px">{{ trans('common.personal_profile_details') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-md-offset-3">
                                <label for="place_of_birth">{{ trans('common.place_of_birth') }}</label>
                                <input type="text" class="form-control form-input" name="place_of_birth" id="place_of_birth" value="{{ old('place_of_birth', $user_basic_info->place_of_birth) }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-md-offset-3">
                                <label for="birthday">{{ trans('dashboard.birthday') }}</label>
                                <input type="text" class="form-control form-input" name="birthday" id="birthday" value="{{ old('birthday', $user_basic_info->birthday) }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-md-offset-3">
                                <label for="gender">{{ trans('dashboard.gender') }}</label>
                                <input type="text" class="form-control form-input" name="gender" id="gender" value="{{ old('gender', $user_basic_info->gender) }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-md-offset-3">
                                <label for="profession">{{ trans('dashboard.profession') }}</label>
                                <input type="text" class="form-control form-input" name="profession" id="profession" value="{{ old('profession', $user_basic_info->profession) }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-md-offset-3">
                                <label for="ethnicity">{{ trans('dashboard.ethnicity') }}</label>
                                <input type="text" class="form-control form-input" name="ethnicity" id="ethnicity" value="{{old('ethnicity', $user_basic_info->ethnicity) }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-md-offset-3">
                                <label for="indigenous_identity">{{ trans('dashboard.indigenous_identity') }}</label>
                                <input type="text" class="form-control form-input" name="indigenous_identity" id="indigenous_identity" value="{{old('indigenous_identity', $user_basic_info->indigenous_identity)}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-md-offset-3">
                                <label for="visible_minority">{{ trans('dashboard.visible_minority') }}</label>
                                <input type="text" class="form-control form-input" name="visible_minority" id="visible_minority" value="{{ old('visible_minority', $user_basic_info->visible_minority) }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-md-offset-3">
                                <label for="languages">{{ trans('dashboard.languages') }}</label>
                                <input type="text" class="form-control form-input" name="languages" id="languages" value="{{ old('languages', $user_basic_info->languages) }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-md-offset-3">
                                <label for="TFHA_years_in_program">{{ trans('dashboard.TFHA_years_in_program') }}</label>
                                <input type="text" class="form-control form-input" name="TFHA_years_in_program" id="TFHA_years_in_program" value="{{ old('TFHA_years_in_program', $user_basic_info->TFHA_years_in_program)}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-md-offset-3">
                                <label for="total_scholarship_funds">{{ trans('dashboard.total_scholarship_funds') }}</label>
                                <input type="text" class="form-control form-input" name="total_scholarship_funds" id="total_scholarship_funds" value="{{ old('total_scholarship_funds', $user_basic_info->total_scholarship_funds) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6" style="margin-top: 30px; display: flex; flex-direction: column; column-gap: 0px;"> 
                        <div class="panel panel-default" style="margin-bottom: 0; border-radius: 20px 20px 0% 0%; border-color: #7b7d7d; border-bottom: none;">
                            <div class="panel-heading" style="border-radius: 20px 20px 0% 0%;">
                                {{ trans('dashboard.address_panel_header') }} 
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3" style="display:flex; justify-content:center;">
                                        <span class="glyphicon glyphicon-home" aria-hidden="true" style="font-size: 28px;"></span>
                                    </div>
                                    <div class="col-md-9" style="font-size: 16px;">
                                        {{ trans('dashboard.primary_address') }}
                                    </div>
                                </div>
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-md-10 col-md-offset-2">
                                        <label class="sr-only">{{ trans('dashboard.primary_address_address') }}</label>
                                        <input type="text" class="form-control form-input" name="primary_address_address" placeholder='{{ trans('common.primary_address_address')}}' value="{{ old('primary_address_address', $user_basic_info->primary_address_address) }}">
                                    </div>
                                </div>
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-md-10 col-md-offset-2">
                                        <label class="sr-only">{{ trans('dashboard.primary_address_address_2') }}</label>
                                        <input type="text" class="form-control form-input" name="primary_address_address_2" placeholder='{{ trans('common.primary_address_address_2')}}' value="{{ old('primary_address_address_2', $user_basic_info->primary_address_address_2) }}">
                                    </div>
                                </div>
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-md-5 col-md-offset-2">
                                        <label class="sr-only">{{ trans('dashboard.primary_address_city') }}</label>
                                        <input type="text" class="form-control form-input" name="primary_address_city" placeholder='{{ trans('common.primary_address_city')}}' value="{{ old('primary_address_city', $user_basic_info->primary_address_city)}}">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="sr-only">{{ trans('dashboard.primary_address_province') }}</label>
                                        <input type="text" class="form-control form-input" name="primary_address_province" placeholder='{{ trans('common.primary_address_province')}}' value="{{ old('primary_address_province', $user_basic_info->primary_address_province) }}">
                                    </div>
                                </div>
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-md-5 col-md-offset-2">
                                        <label class="sr-only">{{ trans('dashboard.primary_address_postal') }}</label>
                                        <input type="text" class="form-control form-input" name="primary_address_postal" placeholder='{{ trans('common.primary_address_postal')}}' value="{{ old('primary_address_postal', $user_basic_info->primary_address_postal) }}">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="sr-only">{{ trans('dashboard.primary_address_country') }}</label>
                                        <input type="text" class="form-control form-input" name="primary_address_country" placeholder='{{ trans('common.primary_address_country')}}' value="{{ old('primary_address_country', $user_basic_info->primary_address_country) }}">
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 30px;">
                                    <div class="col-md-3" style="display:flex; justify-content:center;">
                                        <span class="glyphicon glyphicon-envelope" aria-hidden="true" style="font-size: 28px;"></span>
                                    </div>
                                    <div class="col-md-9" style="font-size: 16px;">
                                        {{ trans('dashboard.shipping_address') }}
                                    </div>
                                </div>
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-md-10 col-md-offset-2">
                                        <label class="sr-only">{{ trans('dashboard.shipping_address_address') }}</label>
                                        <input type="text" class="form-control form-input" name="shipping_address_address" placeholder='{{ trans('common.shipping_address_address')}}' value="{{ old('shipping_address_address', $user_basic_info->shipping_address_address)}}">
                                    </div>
                                </div>
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-md-10 col-md-offset-2">
                                        <label class="sr-only">{{ trans('dashboard.shipping_address_address_2') }}</label>
                                        <input type="text" class="form-control form-input" name="shipping_address_address_2" placeholder='{{ trans('common.shipping_address_address_2')}}' value="{{ old('shipping_address_address_2', $user_basic_info->shipping_address_address_2)}}">
                                    </div>
                                </div>
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-md-5 col-md-offset-2">
                                        <label class="sr-only">{{ trans('dashboard.shipping_address_city') }}</label>
                                        <input type="text" class="form-control form-input" name="shipping_address_city" placeholder='{{ trans('common.shipping_address_city')}}' value="{{ old('shipping_address_city', $user_basic_info->shipping_address_city) }}">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="sr-only">{{ trans('dashboard.shipping_address_province') }}</label>
                                        <input type="text" class="form-control form-input" name="shipping_address_province" placeholder='{{ trans('common.shipping_address_province')}}' value="{{ old('shipping_address_province', $user_basic_info->shipping_address_province)}}">
                                    </div>
                                </div>
                                <div class="row" style="margin-top:10px;">
                                    <div class="col-md-5 col-md-offset-2">
                                        <label class="sr-only">{{ trans('dashboard.shipping_address_postal') }}</label>
                                        <input type="text" class="form-control form-input" name="shipping_address_postal" placeholder='{{ trans('common.shipping_address_postal')}}' value="{{ old('shipping_address_postal', $user_basic_info->shipping_address_postal)}}">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="sr-only">{{ trans('dashboard.shipping_address_country') }}</label>
                                        <input type="text" class="form-control form-input" name="shipping_address_country" placeholder='{{ trans('common.shipping_address_country')}}' value="{{ old('shipping_address_country', $user_basic_info->shipping_address_country)}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" style="border-color: #7b7d7d; border-radius: 0% 0% 20px 20px;">
                            <div class="panel-heading" style="border-radius: 0% 0% 0% 0%; border-color: #7b7d7d;">
                                {{ trans('dashboard.telephone') }} 
                            </div>
                            <div class="panel-body">
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-md-3" style="display:flex; justify-content:center;">
                                        <span class="glyphicon glyphicon-earphone" aria-hidden="true" style="font-size: 28px;"></span>
                                    </div>
                                    <div class="col-md-9">
                                        <label>{{trans('dashboard.primary_phone')}}</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" class="form-control form-input" name="primary_phone_area" placeholder="{{ trans('common.phone_area_code') }}" value="{{ old('primary_phone_area', $user_basic_info->primary_phone_area) }}">
                                            </div>
                                            <div class=col-md-1>
                                                -
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control form-input" name="primary_phone_number" placeholder="{{ trans('common.phone_number') }}" value="{{ old('primary_phone_number', $user_basic_info->primary_phone_number) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-md-offset-3">
                                        <label>{{trans('dashboard.mobile_phone')}}</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" class="form-control form-input" name="mobile_phone_area" placeholder="{{ trans('common.phone_area_code') }}" value="{{ old('mobile_phone_area', $user_basic_info->mobile_phone_area) }}">
                                            </div>
                                            <div class=col-md-1>
                                                -
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control form-input" name="mobile_phone_number" placeholder="{{ trans('common.phone_number') }}" value="{{ old('mobile_phone_number', $user_basic_info->mobile_phone_number) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-md-offset-3">
                                        <label>{{trans('dashboard.work_phone')}}</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" class="form-control form-input" name="work_phone_area" placeholder="{{ trans('common.phone_area_code') }}" value="{{ old('work_phone_area', $user_basic_info->work_phone_area)}}">
                                            </div>
                                            <div class=col-md-1>
                                                -
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control form-input" name="work_phone_number" placeholder="{{ trans('common.phone_number') }}" value="{{ old('work_phone_number', $user_basic_info->work_phone_number)}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-md-offset-3">
                                        <label>{{trans('dashboard.other_phone')}}</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" class="form-control form-input" name="other_phone_area" placeholder="{{ trans('common.phone_area_code') }}" value="{{ old('other_phone_area', $user_basic_info->other_phone_area)}}">
                                            </div>
                                            <div class=col-md-1>
                                                -
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control form-input" name="other_phone_number" placeholder="{{ trans('common.phone_number') }}" value="{{ old('other_phone_number', $user_basic_info->other_phone_number)}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" style="margin-top: 30px; display: flex; flex-direction: column; column-gap: 0px;"> 
                        <div class="panel panel-default" style="margin-bottom: 0; border-radius: 20px 20px 0% 0%; border-color: #7b7d7d; border-bottom: none;">
                            <div class="panel-heading" style="border-radius: 20px 20px 0% 0%;">
                                {{ trans('dashboard.contact_information') }} 
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3" style="display:flex; justify-content:center;">
                                        <span class="glyphicon glyphicon-send" aria-hidden="true" style="font-size: 28px;"></span>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <label for="primary_email">{{ trans('common.primary_email') }}</label>
                                            <input type="text" id="primary_email" class="form-control form-input" name="primary_email" placeholder='{{ trans('common.primary_email')}}' value="{{ old('primary_email', $user_basic_info->primary_email) }}">    
                                        </div>
                                        <div class="row">
                                            <label for="alternative_email">{{ trans('common.alternative_email') }}</label>
                                            <input type="text" id="alternative_email" class="form-control form-input" name="alternative_email" placeholder='{{ trans('common.alternative_email')}}' value="{{ old('alternative_email', $user_basic_info->alternative_email)}}">   
                                        </div>
                                        <div class="row">
                                            <label for="work_email">{{ trans('common.work_email') }}</label>
                                            <input type="text" id="work_email" class="form-control form-input" name="work_email" placeholder='{{ trans('common.work_email')}}' value="{{ old('work_email', $user_basic_info->work_email)}}">   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" style="border-color: #7b7d7d; border-radius: 0% 0% 20px 20px;">
                            <div class="panel-heading" style="border-radius: 0% 0% 0% 0%; border-color: #7b7d7d;">
                                {{ trans('dashboard.online_presence') }} 
                            </div>
                            <div class="panel-body" >
                                <div class="row" style="display: flex; align-items: center;">
                                    <div class="col-md-3" style="display:flex; justify-content:center;">
                                        <i class="fa fa-instagram"></i>
                                    </div>
                                    <div class="col-md-9">
                                        <label class="sr-only">{{ trans('common.contact_instagram') }}</label>
                                        <input type="text" class="form-control form-input" name="contact_instagram" placeholder='{{ trans('common.contact_instagram')}}' value="{{ old('contact_instagram', $user_basic_info->contact_instagram) }}">
                                    </div>
                                </div>
                                <div class="row" style="display: flex; align-items: center;">
                                    <div class="col-md-3" style="display:flex; justify-content:center;">
                                        <i class="fa fa-facebook"></i>
                                    </div>
                                    <div class="col-md-9">
                                            <label class="sr-only">{{ trans('common.contact_facebook') }}</label>
                                            <input type="text" class="form-control form-input" name="contact_facebook" placeholder='{{ trans('common.contactfacebook')}}' value="{{ old('contact_facebook', $user_basic_info->contact_facebook) }}">
                                    </div>
                                </div>
                                <div class="row" style="display: flex; align-items: center;">
                                    <div class="col-md-3" style="display:flex; justify-content:center;">
                                        <i class="fa fa-twitter"></i>
                                    </div>
                                    <div class="col-md-9">
                                        <label class="sr-only">{{ trans('common.contact_twitter') }}</label>
                                        <input type="text" class="form-control form-input" name="contact_twitter" placeholder='{{ trans('common.contact_twitter')}}' value="{{ old('contact_twitter', $user_basic_info->contact_twitter) }}">
                                    </div>
                                </div>
                                <div class="row" style="display: flex; align-items: center;">
                                    <div class="col-md-3" style="display:flex; justify-content:center;">
                                        <i class="fa fa-linkedin"></i>
                                    </div>
                                    <div class="col-md-9">
                                        <label class="sr-only">{{ trans('common.contact_linkedin') }}</label>
                                        <input type="text" class="form-control form-input" name="contact_linkedin" placeholder='{{ trans('common.contact_linkedin')}}' value="{{ old('contact_linkedin', $user_basic_info->contact_linkedin) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body" style="border-top: 1px solid black;">
                                <div class="row">
                                    <div class="col-md-3" style="display:flex; justify-content:center;">
                                        <i class="fa fa-external-link fa-2x"></i>
                                    </div>
                                    <div class="col-md-9">
                                        <p style="font-size: 12px" for="personal_website">
                                            <strong>{{ trans('dashboard.personal_website') }}:</strong>
                                        </p>
                                        <label class="sr-only">{{ trans('common.personal_website') }}</label>
                                        <input type="text" id="personal_website" class="form-control form-input" name="personal_website" placeholder='{{ trans('common.personal_website')}}' value="{{ old('personal_website', $user_basic_info->personal_website) }}">
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-md-3" style="display:flex; justify-content:center;">
                                        <i class="fa fa-link fa-2x"></i>
                                    </div>
                                    <div class="col-md-9">
                                        <p style="font-size: 12px">
                                            <strong>{{ trans('dashboard.links_of_interest') }}:</strong>
                                        </p>
                                        <label class="sr-only">{{ trans('common.link_of_interest_1') }}</label>
                                        <input type="text" class="form-control form-input" name="link_of_interest_1" placeholder='{{ trans('common.link_of_interest_1')}}' value="{{ old('link_of_interest_1', $user_basic_info->link_of_interest_1) }}">
                                        <label class="sr-only">{{ trans('common.link_of_interest_2') }}</label>
                                        <input type="text" class="form-control form-input" name="link_of_interest_2" placeholder='{{ trans('common.link_of_interest_2')}}' value="{{ old('link_of_interest_2', $user_basic_info->link_of_interest_2) }}">
                                        <label class="sr-only">{{ trans('common.link_of_interest_3') }}</label>
                                        <input type="text" class="form-control form-input" name="link_of_interest_3" placeholder='{{ trans('common.link_of_interest_3')}}' value="{{old('link_of_interest_3', $user_basic_info->link_of_interest_3) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-5 pull-right">
                    <h3>{{ trans('edit-profile.edit.helper') }}</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 pull-right">
                    <button type="submit" class="btn btn-success edit-btns">YES <i class="fa fa-share" aria-hidden="true"></i></button>
                    <a class="btn btn-danger edit-btns" href="/dashboard">NO <i class="fa fa-times" aria-hidden="true"></i></a>
                </div>
            </div>
    </form>
    @endif
</div>

@endsection
 
@section('javascript')
<script type="text/javascript">
//Force first level to uppercase.
$(document).ready(function() {
    $('.capFirst').on('keypress', function(event) {
        $(this).val(function(i, v){
            return v.replace(/[a-zA-Z]/, function(c){
                return c.toUpperCase();
            });
        });
    });
});
</script>
<script type="text/javascript">
$(function() {
    setTimeout(function() {
        $(".alert-autohide").slideDown(600);
    }, 600);
    setTimeout(function() {
        $(".alert-autohide").slideUp(900);
    }, 6000);
});
</script>
<script type="text/javascript" src="/js/bootbox.min.js"></script>
<script type="text/javascript">
</script>
<script>
    var dialog;
    function uploadPicture(e){
        e.preventDefault();
        dialog = bootbox.dialog({
            message: "<p>{{ trans('edit-profile.profile.edit.helper') }}</p><form enctype='multipart/form-data' id='info-form' action='/profilepicture' method='post'><input type='hidden' name='_token' value='{{ csrf_token() }}'><input id='file-picker' type='file' name='file'><button type='submit' name='button' style='margin-top: 25px;' class='btn btn-md btn-primary'>{{ trans('edit-profile.profile.edit.upload') }}</button></form>",
            title: "Upload Picture",
            buttons: {
                success: {
                    label: "Cancel",
                    className: "btn-default",
                    callback: function() {
                        return true;
                    }
                },
            }
        });
    }
    $(document).ready(function() {
    $('.form-limit-words').each(function(){
        checkWords(this);
    });
    $('.form-limit-words').on('keyup', function() {
        return checkWords(this);
    });
    function checkWords(element) {
        if (element.value.match(/\S+/g) == null) {
            var words = 0;
        } else {
            var words = element.value.match(/\S+/g).length;
        }
        var words_limit = $(element).attr('words');
        var name = $(element).attr('name');

        if (words > words_limit) {
            var trimmed = $(element).val().split(/\s+/, words_limit).join(" ");
            $(element).val(trimmed + " ");
            return false;
        } else {
            $('#'+name+'_words').html(words + '/' + words_limit);
        }
    }
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    $(document).on('submit', '#info-form', function(e) {
        e.preventDefault();
        var formData = new FormData();
        formData.append('file', $('#file-picker')[0].files[0]);

        $.ajax({
            type: 'POST',
            url: '/profilepicture',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                $('#custom-success-text')[0].innerHTML = "@lang('edit-profile.alert.updated')";
                $('#avatar-img').prop("src", 'dashboard/avatar' + '?' + Math.random());
                setTimeout(function() {
                    $(".custom-success").slideDown(600);
                }, 600);
                setTimeout(function() {
                    $(".custom-success").slideUp(900);
                }, 6000);
                
                setTimeout(function() {
                    $(".custom-success").slideDown(600);
                }, 600);
                dialog.modal('hide');
            },
            error:function(error){
                // Error localzations should be updated if new error message is added
                var translations = {
                    too_large: "@lang('edit-profile.alert.too_large')",
                    invalid: "@lang('edit-profile.alert.invalid')",
                    not_valid: "@lang('edit-profile.alert.not_valid')",
                    no_file: "@lang('edit-profile.alert.no_file')",
                    undefined: "@lang('edit-profile.alert.unknown')",
                };

                // File exceeds what the server can handle
                if (error.status == 413) {
                    $('#custom-error-text')[0].innerHTML = translations.too_large;
                } else if (translations[error.responseText]) {
                    $('#custom-error-text')[0].innerHTML = translations[error.responseText];
                } else {
                    $('#custom-error-text')[0].innerHTML = translations.undefined;
                }
                
                setTimeout(function() {
                    $(".custom-error").slideDown(600);
                }, 600);
                setTimeout(function() {
                    $(".custom-error").slideUp(900);
                }, 6000);
                dialog.modal('hide');
            }
        });
    });
</script>
@endsection
