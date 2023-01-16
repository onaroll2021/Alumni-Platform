@extends('master-layout2')
@section('title', 'Application Dashboard - Terry Fox Humanitarian Award Program')

@section('styles')
<link href="/css/style-dashboard.css" rel="stylesheet">
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
    <form>
        {!! csrf_field() !!}
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
                        <div class="col-md-3">
                            <h5>
                                {{$user_basic_info->name_first}} {{$user_basic_info->name_last}}
                            </h5>
                            <p style="font-size: 12px;">
                                {{$user_basic_info->location}}
                            </p>
                        </div>
                        <div class="col-md-3 col-md-offset-6">
                            <a href="/edit-profile" role="button" class="edit_file_button btn btn-primary active btn-lg btn-block" style="background-color: #AF601A;">{{ trans('dashboard.edit_profile') }} 
                                <span class="glyphicon glyphicon-pencil" style="margin-left: 15px;" aria-hidden="true"></span>    
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <p style="font-size: 12px;">
                                {{$user_basic_info->TFHA_alumni_year}}<br>
                                {{$user_basic_info->university_name}}<br>
                                {{$user_basic_info->diploma}}<br>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p style="font-size: 12px;">
                                {{$user_basic_info->short_bio}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="background-color: #F8F9F9; border-top-right-radius: 30px;">
                <div class="col-md-3" style="margin-top: 20px;">
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
                                        <p style="font-size: 12px">{{ trans('dashboard.place_of_birth') }}<br>{{$user_basic_info->place_of_birth}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-md-offset-3">
                                <p style="font-size: 12px">
                                    {{ trans('dashboard.birthday') }}<br>{{$user_basic_info->birthday}}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-md-offset-3">
                                <p style="font-size: 12px">
                                    {{ trans('dashboard.gender') }}<br>{{$user_basic_info->gender}}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-md-offset-3">
                                <p style="font-size: 12px">
                                    {{ trans('dashboard.profession') }}<br>{{$user_basic_info->profession}}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-md-offset-3">
                                <p style="font-size: 12px">
                                    {{ trans('dashboard.ethnicity') }}<br>{{$user_basic_info->ethnicity}}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-md-offset-3">
                                <p style="font-size: 12px">
                                    {{ trans('dashboard.indigenous_identity') }}<br>{{$user_basic_info->indigenous_identity}}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-md-offset-3">
                                <p style="font-size: 12px">
                                    {{ trans('dashboard.visible_minority') }}<br>{{$user_basic_info->visible_minority}}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-md-offset-3">
                                <p style="font-size: 12px">
                                    {{ trans('dashboard.languages') }}<br>{{$user_basic_info->languages}}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-md-offset-3">
                                <p style="font-size: 12px">
                                    {{ trans('dashboard.TFHA_years_in_program') }}<br>{{$user_basic_info->TFHA_years_in_program}}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 col-md-offset-3">
                                <p style="font-size: 12px">
                                    {{ trans('dashboard.total_scholarship_funds') }}<br>{{$user_basic_info->total_scholarship_funds}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6" style="margin-top: 20px; display: flex; flex-direction: column; column-gap: 0px;"> 
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
                                <div class="row">
                                    <div class="col-md-9 col-md-offset-3">
                                        <p style="font-size: 12px">
                                            {{$user_basic_info->primary_address_address}}<br>
                                            {{ $user_basic_info->primary_address_address_2 ? $user_basic_info->primary_address_address_2 ."<br>" : '' }}
                                            {{$user_basic_info->primary_address_city}}<br>
                                            {{$user_basic_info->primary_address_province}}<br>
                                            {{$user_basic_info->primary_address_postal}}<br>
                                        </p>
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
                                <div class="row">
                                    <div class="col-md-9 col-md-offset-3">
                                        <p style="font-size: 12px">
                                            {{$user_basic_info->shipping_address_address}}<br>
                                            {!! $user_basic_info->shipping_address_address_2 ? $user_basic_info->shipping_address_address_2 ."<br>" : '' !!}
                                            {{$user_basic_info->shipping_address_city}}<br>
                                            {{$user_basic_info->shipping_address_province}}<br>
                                            {{$user_basic_info->shipping_address_postal}}<br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" style="border-color: #7b7d7d; border-radius: 0% 0% 20px 20px;">
                            <div class="panel-heading" style="border-radius: 0% 0% 0% 0%; border-color: #7b7d7d;">
                                {{ trans('dashboard.telephone') }} 
                            </div>
                            <div class="panel-body">
                                <div class="row" style="margin-top: 30px;">
                                    <div class="col-md-3" style="display:flex; justify-content:center;">
                                        <span class="glyphicon glyphicon-earphone" aria-hidden="true" style="font-size: 28px;"></span>
                                    </div>
                                    <div class="col-md-9">
                                        <p style="font-size: 12px">
                                            {{trans('dashboard.primary_phone')}}: ({{$user_basic_info->primary_phone_area}}) {{$user_basic_info->primary_phone_number}}
                                        </p>
                                        <p style="font-size: 12px">    
                                            {{trans('dashboard.mobile_phone')}}: ({{$user_basic_info->mobile_phone_area}}) {{$user_basic_info->mobile_phone_number}}
                                        </p>
                                        <p style="font-size: 12px">
                                            {{trans('dashboard.work_phone')}}: ({{$user_basic_info->work_phone_area}}) {{$user_basic_info->work_phone_number}}
                                        </p>
                                        <p style="font-size: 12px">
                                            {{trans('dashboard.other_phone')}}: ({{$user_basic_info->other_phone_area}}) {{$user_basic_info->other_phone_number}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" style="margin-top: 20px; display: flex; flex-direction: column; column-gap: 0px;"> 
                        <div class="panel panel-default" style="margin-bottom: 0; border-radius: 20px 20px 0% 0%; border-color: #7b7d7d; border-bottom: none;">
                            <div class="panel-heading" style="border-radius: 20px 20px 0% 0%;">
                                {{ trans('dashboard.contact_information') }} 
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3" style="display:flex; justify-content:center;">
                                        <span class="glyphicon glyphicon-send" aria-hidden="true" style="font-size: 28px;"></span>
                                    </div>
                                    <div class="col-md-9">
                                        <p style="font-size: 12px">
                                            <strong>{{ trans('dashboard.primary_email') }}: </strong> {{$user_basic_info->primary_email}}<br>
                                        </p>
                                        <p style="font-size: 12px">
                                            <strong>{{ trans('dashboard.alternative_email') }}: </strong> {{$user_basic_info->alternative_email}}<br>
                                        </p>
                                        <p style="font-size: 12px">
                                            <strong>{{ trans('dashboard.work_email') }}: </strong> {{$user_basic_info->work_email}}<br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" style="border-color: #7b7d7d; border-radius: 0% 0% 20px 20px;">
                            <div class="panel-heading" style="border-radius: 0% 0% 0% 0%; border-color: #7b7d7d;">
                                {{ trans('dashboard.online_presence') }} 
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3" style="display:flex; justify-content:center;">
                                        <i class="fa fa-instagram"></i>
                                    </div>
                                    <div class="col-md-9">
                                        <p style="font-size: 12px">
                                            {{$user_basic_info->contact_instagram}}
                                        </p>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-md-3" style="display:flex; justify-content:center;">
                                        <i class="fa fa-facebook"></i>
                                    </div>
                                    <div class="col-md-9">
                                        <p style="font-size: 12px">
                                            {{$user_basic_info->contact_facebook}}
                                        </p>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-md-3" style="display:flex; justify-content:center;">
                                        <i class="fa fa-twitter"></i>
                                    </div>
                                    <div class="col-md-9">
                                        <p style="font-size: 12px">
                                            {{$user_basic_info->contact_twitter}}
                                        </p>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 20px;">
                                    <div class="col-md-3" style="display:flex; justify-content:center;">
                                        <i class="fa fa-linkedin"></i>
                                    </div>
                                    <div class="col-md-9">
                                        <p style="font-size: 12px">
                                            {{$user_basic_info->contact_linkedin}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body" style="border-top: 1px solid black;">
                                <div class="row">
                                    <div class="col-md-3" style="display:flex; justify-content:center;">
                                        <i class="fa fa-external-link fa-2x"></i>
                                    </div>
                                    <div class="col-md-9">
                                        <p style="font-size: 12px">
                                            <strong>{{ trans('dashboard.personal_website') }}:</strong>
                                        </p>
                                        <p style="font-size: 12px">
                                            {{$user_basic_info->personal_website}}
                                        </p>
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
                                        <p style="font-size: 12px">
                                            {{$user_basic_info->link_of_interest_1}}<br>
                                            {!! $user_basic_info->link_of_interest_2 ? $user_basic_info->link_of_interest_2 ."<br>" : '' !!}
                                            {!! $user_basic_info->link_of_interest_3 ? $user_basic_info->link_of_interest_3 ."<br>" : '' !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>
    @endif
</div>
@endsection
@section('javascript')
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
