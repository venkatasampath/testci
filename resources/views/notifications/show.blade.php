@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card-header">
                <div class="row">
                    <div class="float-left col-4">
                        {{ Breadcrumbs::render('notifications.show', $theUser, $notification) }}
                    </div>
                    <div class="col-md-4"><h4>{{ $heading }}</h4></div>
                </div>
            </div>
            <div class="card-body" style="text-align: center">
                @if($notification->type == 'App\Notifications\ExportCompleted')
                    @include('emails.files.exportcompleted')
                @elseif($notification->type == 'App\Notifications\ImportCompleted')
                    @include('emails.files.importcompleted')
                @elseif($notification->type == 'App\Notifications\SpecimenReviewed')
                    @include('emails.specimens.reviewcompleted')
                @elseif($notification->type == 'App\Notifications\SpecimenGroupCreated')
                    @include('emails.specimens.groupcreated')
                @endif
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @parent
    <style>
        .wrapper { font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #f5f8fa; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; }
        .content { font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; }
        .body { font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #FFFFFF; border-bottom: 1px solid #EDEFF2; border-top: 1px solid #EDEFF2; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; }
        .inner-body {  align: center; width: 570px; cellpadding:0; cellspacing: 0; font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background-color: #FFFFFF; margin: 0 auto; padding: 0; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px; }
        .content-cell { font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 35px; }
        .text { font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left; }
        .action {  align:center; width:100%; cellpadding:0; cellspacing:0; font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 30px auto; padding: 0; text-align: center; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; }
        .tooltip-inner { white-space:pre-wrap; max-width: 400px; }
        .table { width: 100%; border:0; cellpadding:0; cellspacing:0; font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; }
        .td { align:center; font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; }
        .footer { align:center; width: 570px; cellpadding: 0; cellspacing: 0; font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0 auto; padding: 0; text-align: center; width: 570px; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px; }
        .content { font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; line-height: 1.5em; margin-top: 0; color: #AEAEAE; font-size: 12px; text-align: center; }
        .button-blue { font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #FFF; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #3097D1; border-top: 10px solid #3097D1; border-right: 18px solid #3097D1; border-bottom: 10px solid #3097D1; border-left: 18px solid #3097D1; }
        .button-green { font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #FFF; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #2ab27b; border-top: 10px solid #2ab27b; border-right: 18px solid #2ab27b; border-bottom: 10px solid #2ab27b; border-left: 18px solid #2ab27b; }
        .link { font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #3869D4; }
    </style>
@endsection