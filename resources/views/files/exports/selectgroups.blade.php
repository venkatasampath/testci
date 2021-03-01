@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <v-row align="center" justify="center">
        <v-col cols="12" class="m-0 p-0">
            <file-exports></file-exports>
        </v-col>
    </v-row>
{{--    <div class="container-fluid">--}}
{{--        <div class="row">--}}
{{--            <div class="col-md-12">--}}
{{--                <div class="card ">--}}
{{--                    <div class="card-header">--}}
{{--                        <div class="row">--}}
{{--                            <div class="float-left col-md-4">--}}
{{--                                {{ Breadcrumbs::render('exportOptions') }}--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4"><h4>{{ $heading }}</h4></div>--}}
{{--                            <div class="float-right col-4">--}}
{{--                                <span class="page-loading float-right" style="margin: 2px;"><i class="fas fa-spinner fa-spin fas fa-fw"></i></span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="flashMessage"></div>--}}
{{--                        @if (sizeof($exportTypes) > 0)--}}
{{--                            <div class="table-responsive">--}}
{{--                                <table class="table table-bordered table-striped mav-datatable-list">--}}
{{--                                    <thead>--}}
{{--                                        <th>@lang('labels.export_type')</th>--}}
{{--                                        <th>@lang('labels.group')</th>--}}
{{--                                        <th>@lang('labels.description')</th>--}}
{{--                                        <th>@lang('labels.actions')</th>--}}
{{--                                    </thead>--}}
{{--                                    <tbody>--}}
{{--                                    @foreach ($exportTypes as $exportType)--}}
{{--                                        <tr>--}}
{{--                                            <td><div>{{ $exportType->name }} </div></td>--}}
{{--                                            <td><div>{{ $exportType->group }} </div></td>--}}
{{--                                            <td><div>{{ $exportType->description }} </div></td>--}}
{{--                                            <td>--}}
{{--                                                <button dusk="export-button-{{$loop->iteration}}" name="exportBtn" value="{{$exportType->id}}" id="exportBtn" class="btn btn-success actionButtons" onClick="exportGroup(this.value);">--}}
{{--                                                    <span><i class="fas fa-btn fa-file-excel"></i>@lang('labels.export')</span>--}}
{{--                                                </button>--}}
{{--                                                @if(Auth::user()->isAdmin() && is_null($exportType->query))--}}
{{--                                                    <a href="{{ url('/exportType/'.$exportType->id) }}" class="btn btn-primary actionButtons">--}}
{{--                                                        <span><i class="fas fa-btn fa-cog"></i>@lang('labels.advanced')</span>--}}
{{--                                                    </a>--}}
{{--                                                @endif--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        @else--}}
{{--                            <div class="alert alert-info">--}}
{{--                                <h4>@lang('messages.no_records_found', ['model' => 'Export'])</h4>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection

@section('footer')
    @include ('common._footer', ['CRUD_Action' => 'List', 'pageType' => 'List', 'includeStyle' => true, 'includeScript' => true, 'initialshow' => false])
    <script>
        {{--//import Fileexport--}}
        {{--var $loading = $('.page-loading').hide();--}}
        {{--$(document).ready(function() {--}}
        {{--    $(document).ajaxStart(function() {--}}
        {{--        $loading.show();--}}
        {{--    }).ajaxStop(function(){--}}
        {{--        $loading.hide();--}}
        {{--    });--}}
        {{--} );--}}

        {{--function exportGroup(exportTypeId) {--}}
        {{--    var messageText = "File Export started. You will be notified once export is completed";--}}
        {{--    var flashMessage = $(".flashMessage");--}}
        {{--    var alertHtml = '<div class="alert alert-info alert-block" role="alert"> ' +--}}
        {{--        '<button class="close" data-dismiss="alert"></button>' + messageText + '</div>';--}}

        {{--    flashMessage.html(alertHtml).delay(500).fadeIn('normal', function() {--}}
        {{--        $(this).delay(2500).fadeOut();--}}
        {{--    });--}}

        {{--    $.ajax({--}}
        {{--        type: 'post',--}}
        {{--        url: '{{ URL::action ('FileController@exportGroup') }}',--}}
        {{--        data: {'exportTypeId' : exportTypeId},--}}
        {{--        success: function(result) {--}}
        {{--        if(result.success) {--}}
        {{--            console.log("Success - Export Job started");--}}
        {{--            // Reset result to avoid multiple duplicate notifications--}}
        {{--            result = null;--}}
        {{--        }--}}
        {{--        },--}}
        {{--        error: function() {--}}
        {{--            console.log("Failure - Export Job failed to start");--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}
        {{--export default {--}}
        {{--    components: {Fileexport}--}}
        {{--}--}}
    </script>
@endsection