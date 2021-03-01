@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <v-row align="center" justify="center">
        <v-col cols="12" class="m-0 p-0">
            <file-manager></file-manager>
        </v-col>
    </v-row>
{{--    <div class="container-fluid">--}}
{{--        <div class="row">--}}
{{--            <div class="col-md-12">--}}
{{--                <div class="card ">--}}
{{--                    <div class="card-header">--}}
{{--                        <div class="row">--}}
{{--                            <div class="float-left col-md-4">--}}
{{--                                {{ Breadcrumbs::render('exportFileManager') }}--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4"><h4>{{ $heading }}</h4></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="flashMessage"></div>--}}
{{--                        @if (sizeof($userExports) > 0)--}}
{{--                            <div class="table-responsive">--}}
{{--                                <table class="table table-bordered table-striped mav-datatable-list">--}}
{{--                                    <thead>--}}
{{--                                        <th>@lang('labels.export')</th>--}}
{{--                                        <th>@lang('labels.export_type')</th>--}}
{{--                                        <th>@lang('labels.created_by')</th>--}}
{{--                                        <th>@lang('labels.created_at')</th>--}}
{{--                                        <th>@lang('labels.actions')</th>--}}
{{--                                    </thead>--}}
{{--                                    <tbody>--}}
{{--                                    @foreach ($userExports as $userExport)--}}
{{--                                        <tr>--}}
{{--                                            <td class="col-md-4"><div>{{ $userExport->filename }}</div></td>--}}
{{--                                            <td><div>{{ $userExport->export_type }}</div></td>--}}
{{--                                            <td><div>{{ $userExport->created_by }}</div></td>--}}
{{--                                            <td><div>{{ \Carbon\Carbon::parse($userExport->created_at)->diffForHumans() }}</div></td>--}}
{{--                                            <td>--}}
{{--                                                <a dusk="download-button-{{$loop->iteration}}" class="btn btn-success actionBtns" role="button" href="{{ url('/exportFileManager/'.$userExport->export_type.'/download/'.$userExport->id) }}" id="downloadBtn">--}}
{{--                                                    <span><i class="fas fa-btn fa-file-archive"></i>@lang('labels.download')</span>--}}
{{--                                                </a>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        @else--}}
{{--                            <div class="alert alert-info"><h4>@lang('messages.no_files_to_download')</h4></div>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection

@section('footer')
    @include ('common._footer', ['CRUD_Action' => 'List', 'pageType' => 'List', 'orderByColumn' => 4, 'sortOrder' => 'desc', 'includeStyle' => true, 'includeScript' => true, 'initialshow' => false])
@endsection
