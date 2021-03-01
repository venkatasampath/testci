@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="float-left col-4">
                                {{ Breadcrumbs::render('visualization.pairs') }}
                            </div>
                        </div>
                    </div>
                    {!! Form::open(['url' => 'visualizations/pairs', 'class' => 'form-horizontal']) !!}{{ csrf_field() }}
                    <div class="card-body">
                        <div class="card-group" id="accordion">
                            <div class="card">
                                <div class="card-header" style="height: 35px;">
                                    <div class="float-left">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseSE" class="">@lang('labels.pair_visualization')<span class="caret"></span></a>
                                    </div>
                                    <div class="float-right">
                                        <i class="fas fa-spinner fa-spin fas fa-fw" id="report_params_update"></i>
                                        {!! Form::button('<i class="fas fa-btn fa-list"></i>Graph', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                                    </div>
                                </div>
                                <div id="collapseSE" class="card-collapse card-body collapse in">
                                    <div class="col-lg-12 form-group se-search">
                                        <div class="form-group">
                                            {!! Form::label('an', trans('labels.an').':', ['for' => 'an_select', 'class' => 'col-md-4 control-label']) !!}
                                            <div class="col-md-6">
                                                {{ Form::select('an_select', $list_an, $skeletal_an, ['id' => 'an_select', 'class' => 'form-control mav-select', 'placeholder' => trans('messages.select_an')]) }}
                                            </div>
                                            <span class="validity"></span>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('p1', trans('labels.provenance1').':', ['for' => 'p1_select','class' => 'col-md-4 control-label']) !!}
                                            <div class="col-md-6">
                                                {{ Form::select('p1_select', $list_p1, $skeletal_p1, ['id' => 'p1_select', 'class' => 'form-control mav-select', 'placeholder' => trans('messages.select_p1')]) }}
                                            </div>
                                            <span class="validity"></span>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('p2', trans('labels.provenance2').':', ['for' => 'p2_select', 'class' => 'col-md-4 control-label']) !!}
                                            <div class="col-md-6">
                                                {{ Form::select('p2_select', $list_p2, $skeletal_p2, ['id' => 'p2_select', 'class' => 'form-control mav-select', 'placeholder' => trans('messages.select_p2')]) }}
                                            </div>
                                            <span class="validity"></span>
                                        </div>
                                        <div class="form-group required">
                                            {!! Form::label('sb', trans('labels.sb').':', ['for' => 'sb_select', 'class' => 'col-md-4 control-label']) !!}
                                            <div class="col-md-6">
                                                {{ Form::select('sb_select', $list_sb, $skeletal_bone, ['id' => 'sb_select', 'class' => 'form-control mav-select', 'placeholder' => trans('messages.select_bone'), 'required']) }}
                                            </div>
                                            <span class="validity"></span>
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('side', trans('labels.side').':', ['for' => 'side_select', 'class' => 'col-md-4 control-label']) !!}
                                            <div class="col-md-6">
                                                {{ Form::select('side_select', $list_side, $skeletal_side, ['id' => 'side_select', 'class' => 'form-control mav-select', 'placeholder' => trans('messages.select_side')]) }}
                                            </div>
                                            <span class="validity"></span>
                                        </div>
                                        <hr>
                                        <div class="form-group required">
                                            <label class="col-md-4 control-label">@lang('labels.skeletal_elements'):</label>
                                            <div class="col-md-6">
                                                {!! Form::select('skeletal_elements[]', $list_se, $se, ['id' => 'skeletal_elements_select', 'class' => 'form-control mav-select', 'multiple', 'required']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group required">
                                            {!! Form::label('depth', trans('labels.depth').':', ['for' => 'depth_select', 'class' => 'col-md-4 control-label']) !!}
                                            <div class="col-md-6">
                                                {{ Form::select('depth_select', $list_depth, $skeletal_depth, ['id' => 'depth_select', 'class' => 'form-control mav-select', 'placeholder' => trans('messages.select_depth'), 'required']) }}
                                            </div>
                                            <span class="validity"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 alert-info" style="text-align: center">
                                        @lang('messages.slow_search')
                                        <br>
                                        @lang('messages.search_results_limited_to', ['limit' => config('app.ui.search_size_limit')])
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include("visualizations.pairs.graph")
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @parent
    @include ('common._footer', ['pageType' => 'Search', 'includeStyle' => true, 'includeScript' => true])

    <script type="text/javascript">
        var initialshow = '<?php echo $initialshow; ?>';

        $(document).ready(function() {

            $("select[name='an_select']").change(function () {
                var an_select = $(this).val();
                var p1_select = document.getElementById("p1_select").value;
                var p2_select = document.getElementById("p2_select").value;
                var sb_select = document.getElementById("sb_select").value;
                var side_select = document.getElementById("side_select").value;
                $.ajax({
                    url: "{{ route('visualizations.jsonskeletalelements') }}",
                    method: 'POST',
                    data: {an_select: an_select, p1_select: p1_select, p2_select: p2_select, sb_select: sb_select, side_select: side_select},
                    success: function (data) {
                        var Skeletal_Element = $("select[name='skeletal_elements[]']");
                        Skeletal_Element.empty();

                        $.each(data, function (value, key) {
                            Skeletal_Element.append($("<option></option>").attr("value", key).text(value));
                        })
                    }
                })
            })

            $("select[name='p1_select']").change(function () {
                var p1_select = $(this).val();
                var an_select = document.getElementById("an_select").value;
                var p2_select = document.getElementById("p2_select").value;
                var sb_select = document.getElementById("sb_select").value;
                var side_select = document.getElementById("side_select").value;
                $.ajax({
                    url: "{{ route('visualizations.jsonskeletalelements') }}",
                    method: 'POST',
                    data: {an_select: an_select, p1_select: p1_select, p2_select: p2_select, sb_select: sb_select, side_select: side_select},
                    success: function (data) {
                        var Skeletal_Element = $("select[name='skeletal_elements[]']");
                        Skeletal_Element.empty();

                        $.each(data, function (value, key) {
                            Skeletal_Element.append($("<option></option>").attr("value", key).text(value));
                        })
                    }
                })
            })

            $("select[name='p2_select']").change(function () {
                var p2_select = $(this).val();
                var p1_select = document.getElementById("p1_select").value;
                var an_select = document.getElementById("an_select").value;
                var sb_select = document.getElementById("sb_select").value;
                var side_select = document.getElementById("side_select").value;
                $.ajax({
                    url: "{{ route('visualizations.jsonskeletalelements') }}",
                    method: 'POST',
                    data: {an_select: an_select, p1_select: p1_select, p2_select: p2_select, sb_select: sb_select, side_select: side_select},
                    success: function (data) {
                        var Skeletal_Element = $("select[name='skeletal_elements[]']");
                        Skeletal_Element.empty();

                        $.each(data, function (value, key) {
                            Skeletal_Element.append($("<option></option>").attr("value", key).text(value));
                        })
                    }
                })
            })

            $("select[name='sb_select']").change(function () {
                var sb_select = $(this).val();
                var p1_select = document.getElementById("p1_select").value;
                var p2_select = document.getElementById("p2_select").value;
                var an_select = document.getElementById("an_select").value;
                var side_select = document.getElementById("side_select").value;
                $.ajax({
                    url: "{{ route('visualizations.jsonskeletalelements') }}",
                    method: 'POST',
                    data: {an_select: an_select, p1_select: p1_select, p2_select: p2_select, sb_select: sb_select, side_select: side_select},
                    success: function (data) {
                        var Skeletal_Element = $("select[name='skeletal_elements[]']");
                        Skeletal_Element.empty();

                        $.each(data, function (value, key) {
                            Skeletal_Element.append($("<option></option>").attr("value", key).text(value));
                        })
                    }
                })
            })

            $("select[name='side_select']").change(function () {
                var side_select = $(this).val();
                var p1_select = document.getElementById("p1_select").value;
                var p2_select = document.getElementById("p2_select").value;
                var sb_select = document.getElementById("sb_select").value;
                var an_select = document.getElementById("an_select").value;
                $.ajax({
                    url: "{{ route('visualizations.jsonskeletalelements') }}",
                    method: 'POST',
                    data: {an_select: an_select, p1_select: p1_select, p2_select: p2_select, sb_select: sb_select, side_select: side_select},
                    success: function (data) {
                        var Skeletal_Element = $("select[name='skeletal_elements[]']");
                        Skeletal_Element.empty();

                        $.each(data, function (value, key) {
                            Skeletal_Element.append($("<option></option>").attr("value", key).text(value));
                        })
                    }
                })
            })

            if (initialshow != 1) {
                $('a[data-toggle="collapse"]').click();
            }

            document.title = 'CoRA Pairs Visualization';

        });
    </script>
@endsection