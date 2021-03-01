@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <div class="row">
                            <div class="float-left col-4">
                                {{ Breadcrumbs::render('reports.consolidatedAccession.search') }}
                            </div>
                            <div><h4 style="text-align:center;">{{$heading}}</h4></div>
                        </div>
                    </div>
                     {!! Form::open(['url' => 'reports/consolidatedAccession/results', 'class' => 'form-horizontal']) !!}{{ csrf_field() }}
                        {{--<div class='card-body'>--}}
                        @include('common.errors')
                        @include('common.flash')

                        <div class="card-group" id="accordion">
                            <div class="card">
                                <div class="card-header">
                                    <div class="float-left">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseSE"
                                           class="">@lang('labels.consolidatedAccession_search')<span class="caret"></span></a>
                                    </div>
                                    <div class="float-right">
                                        <i class="fas fa-spinner fa-spin fas fa-fw" id="report_params_update"></i>
                                        {!! Form::button('<i class="fas fa-btn fa-list"></i>Generate', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                                    </div>
                                </div>

                                <div class="card card-body">
                                    <div id="collapseSE" class="collapse show">
                                        <div class="col-lg-12 form-group se-search">
                                            <!-- search input -->
                                            <div class="col-lg-12 form-group required form-group refits">
                                                <label class="col-md-4 control-label">@lang('labels.consolidated_accession_number')</label>
                                                {!! Form::select('consolidatedAccessions[]', $list_accessions, null, ['id' => 'consolidated', 'class' => 'form-control consolidated mav-select', 'multiple', 'style' => 'width: 60%; margin-top: 10px;']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 alert-info" style="text-align: center">
                                @lang('messages.slow_search')
                                <br>
                                @lang('messages.search_results_limited_to', ['limit' => config('app.ui.search_size_limit')])
                            </div>
                        </div>
                </div>
                {!! Form::close() !!}


                @if(isset($results) && count($results) > 0)
                    @include('reports.consolidatedAccession.results')
                @else
                    @if (!$initialshow)
                        <div class="alert alert-info">
                            <h4>@lang('messages.no_records_found_refine_search', ['model' => 'Specimen'])</h4>
                            <h4>@lang('messages.search_default_help')</h4>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

@section('footer')
    @parent
    @include ('common._footer', ['pageType' => 'Report', 'includeStyle' => true, 'includeScript' => true])

    <script>
        $(document).ready(function ($) {
        });
    </script>
@endsection

