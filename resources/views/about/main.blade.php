@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <v-row align="center" justify="center">
        <v-col cols="12" class="m-0 p-0">
            <about-main
                    applabel="{{trans('labels.application_name')}}"
                    appname="{{config('app.name', 'CoRA')}}"
                    versionlabel="{{trans(trans('labels.version'))}}"
                    version="{{config('app.version')}}"
                    copyrightlabel="{{trans('labels.copyright')}}"
                    copyright="{{trans('messages.copyright', ['yearto' => '2019'])}}"
                    productprotectlabel="{{trans('labels.product_protection')}}"
                    productprotect="{{trans('messages.product_protection')}}"
                    optimizedbrowserlabel="{{trans('labels.optimized_for_browser')}}"
                    optimizedbrowser="{{trans('messages.optimized_for_browser')}}"
                    browserslabel="{{trans('labels.supported_browsers')}}"
                    popupblockerlabel="{{trans('labels.popup_blocker')}}"
                    popupblocker="{{trans('messages.popup_blocker')}}"
                    browsernamelabel="{{trans('labels.browser_name')}}"
                    browserversionlabel="{{trans('labels.browser_version')}}"
                    cookieslabel="{{trans('labels.cookies')}}"
                    languagelabel="{{trans('labels.language')}}"
                    onlinelabel="{{trans('labels.online')}}"
                    productlabel="{{trans('labels.product')}}"
                    oslabel="{{trans('labels.operating_system')}}"
                    useragentlabel="{{trans('labels.user_agent')}}"
                    welcometext="{{trans('messages.welcome_application_purpose')}}">
            </about-main>
        </v-col>
    </v-row>
@endsection
