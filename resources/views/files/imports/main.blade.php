@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <v-row align="center" justify="center">
        <v-col cols="12" class="m-0 p-0">
            <file-import></file-import>
        </v-col>
    </v-row>

    {{--    <div class="container-fluid">--}}
    {{--        <div class="row">--}}
    {{--            <div class="col-md-12">--}}
    {{--                <div class="card ">--}}
    {{--                    <div class="card-header">--}}
    {{--                        <div class="row">--}}
    {{--                            <div class="float-left col-md-4">--}}
    {{--                                {{ Breadcrumbs::render('importFile') }}--}}
    {{--                            </div>--}}
    {{--                            <div class="col-md-4"><h4>{{ $heading }}</h4></div>--}}
    {{--                            <div class="float-right col-4">--}}
    {{--                                <span class="page-loading float-right" style="margin: 2px;"><i class="fas fa-spinner fa-spin fas fa-fw"></i></span>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                    <div class="card-body">--}}
    {{--                    @include('common.errors')--}}
    {{--                    @include('common.flash')--}}
    {{--                    {{ Form::open(['method' => 'POST', 'url' => 'uploadFile', 'files' => true, 'id' => 'uploadFile', 'enctype' => 'multipart/form-data']) }}--}}
    {{--                    <!-- File upload -->--}}
    {{--                        <div class="row" id="browseFiles">--}}
    {{--                            <div class="form-group required col-md-8 col-md-offset-2">--}}
    {{--                                {!! Form::label('importFileType', 'Choose an import file type', ['for'=>'importFileType','class'=>'control-label col-md-10', 'style' => 'padding-left:0']) !!}--}}
    {{--                                {!! Form::select('importFileType', $importTypes, null, ['class' => "form-control col-md-3 selectImportForm mav-select", 'placeholder' => "Select Import Type", 'required' => 'required', 'dusk' => 'import-type-select']) !!}--}}
    {{--                                {!! Form::button('<i class="fas fa-btn fa-arrow-alt-circle-down"></i> Download Template',array('class' => 'btn btn-primary actionBtns', 'id' => 'downloadBtn', 'onClick' => 'downloadTemplate()', 'disabled' => 'disabled', 'download' => 'download')) !!}--}}
    {{--                                {!! Form::button('<i class="far fa-btn fa-file-archive"></i> Download All Templates',array('class' => 'btn btn-secondary actionBtns float-right', 'id' => 'downloadAllBtn', 'onClick' => 'downloadAllTemplates()')) !!}--}}
    {{--                            </div>--}}
    {{--                            <br> <br>--}}
    {{--                            <div class="col-md-8 col-md-offset-2" style="margin-top: 1rem">--}}
    {{--                                <div class="input-group">--}}
    {{--                                    <label class="input-group-btn">--}}
    {{--                                        <span class="btn btn-info">--}}
    {{--                                            <i class="fas fa-btn fa-search-minus" aria-hidden="true"></i>@lang('labels.browse')--}}
    {{--                                            <input type="file" name="importAttachment" id="importAttachmentUpload" style="display: none">--}}
    {{--                                        </span>--}}
    {{--                                    </label>--}}
    {{--                                    <input type="text" id="upload-file-info" class="form-control" readonly>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                        <!-- Button to upload a CSV file. -->--}}
    {{--                        <div class="row" style="margin-top:20px;">--}}
    {{--                            <div class="col-md-12 text-center">--}}
    {{--                                {!! Form::button('<i class="fas fa-btn fa-cloud-upload-alt"></i> Upload',array('type' => 'submit', 'class' => 'btn btn-success', 'id' => 'uploadFileBtn', 'onClick' => 'storeUploadedFile()')) !!}--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                        {{ Form::close() }}--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

@endsection

@section('footer')
    <script>
        {{--    var $loading = $('.page-loading').hide();--}}
        {{--    $(document).ready(function() {--}}
        {{--        $(document).ajaxStart(function() {--}}
        {{--            $loading.show();--}}
        {{--        }).ajaxStop(function(){--}}
        {{--            $loading.hide();--}}
        {{--        });--}}
        {{--    } );--}}

        {{--    $('#importAttachmentUpload').change(function() {--}}
        {{--        var filename = $(this).val().split('\\').pop();--}}
        {{--        $("#upload-file-info").val(filename);--}}
        {{--        console.log(filename);--}}
        {{--    });--}}

        {{--    $('.selectImportForm').on('change', function() {--}}
        {{--        if($(this).val()) {--}}
        {{--            $('#downloadBtn').removeAttr('disabled');--}}
        {{--        } else {--}}
        {{--            $('#downloadBtn').attr('disabled', 'disabled');--}}
        {{--        }--}}
        {{--    });--}}

        {{--    $('#downloadBtn').on('click', function(e) {--}}
        {{--        if(!($('.selectImportForm').val())) {--}}
        {{--            e.preventDefault();--}}
        {{--        }--}}
        {{--    });--}}

        {{--    $('#uploadFileBtn').on('click', function(e) {--}}
        {{--        if(!($('.selectImportForm').val())) {--}}
        {{--            e.preventDefault();--}}
        {{--        }--}}
        {{--    });--}}

        {{--    var formTemplateDownload = $('#uploadFile');--}}
        {{--    function downloadTemplate() {--}}
        {{--        var importTypeId = $('.selectImportForm').val();--}}
        {{--        var url = '/importFile/' + importTypeId + '/downloadTemplate';--}}
        {{--        formTemplateDownload.attr('action', url);--}}
        {{--        formTemplateDownload.submit();--}}
        {{--    }--}}

        {{--    function downloadAllTemplates() {--}}
        {{--        var url = '/importFile/downloadAllTemplates';--}}
        {{--        formTemplateDownload.attr('action', url);--}}
        {{--        formTemplateDownload.submit();--}}
        {{--    }--}}

        {{--    function storeUploadedFile() {--}}
        {{--        var url = '/uploadFile';--}}
        {{--        formTemplateDownload.attr('action', url);--}}
        {{--        if(!($('.selectImportForm').val()) || !$("#upload-file-info").val()) {--}}
        {{--            return false;--}}
        {{--        }--}}
        {{--        formTemplateDownload.submit();--}}
        {{--    }--}}
    </script>
@endsection

{{--        <script>--}}
{{--            import FileImport from "../../../assets/js/components/Import/fileImport";--}}
{{--            export default {--}}
{{--                components: {FileImport}--}}
{{--            }--}}
{{--        </script>--}}