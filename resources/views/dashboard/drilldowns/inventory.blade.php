@extends('layouts.app')

@section('content')
    <style>
        div.dataTables_wrapper .dataTables_length .form-control{height: auto !important;}
    </style>

    <div class="container-fluid" style="margin-top: 20px">
        <div>
            <div id="dashboard" class="card">
                <div class="card-header" style="margin:0 0 15px 0 ">
                    <div class="row">
                        <div class="float-left col-4">
                            {{ Breadcrumbs::render('drilldown', $user->getCurrentProject()->name) }}
                        </div>
                        <div class="col-4">
                            <h4 class="dashboard-title">Dashboard Details: Inventory</h4>
                        </div>
                        <div class="float-right col-4">
                            <span class="float-right">
                                <a href="javascript:history.back()" class="btn btn-primary" role="button" aria-pressed="true" style="margin-right: 13px;">Back to Dashboard</a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="container-fluid" style="text-align: center; margin-bottom: 15px;">
                    {{ Form::open(array('action' => array('HomeController@inventory_filter', $currentProject->id))) }}
                    {{ Form::submit('Filter', array('class' => 'btn btn-primary', 'style' => 'margin: 10px 3px 0px 0px; width: 142px; float: right; background-color: #58b8e8; border-color: #58b8e8;', 'role' => 'button')) }}
                    {!! Form::date('endDate', date('Y-m-d'), ['id'=>'endDate', 'class' => 'form-control controlForm', 'style' => 'width: 16%; float: right; margin: 10px 20px 0px 20px;', 'dusk'=>'endDate']) !!}
                    <p style="float: right; font-size: 12pt; margin: 14px 0px 0px 20px;">End Date</p>
                    {!! Form::date('startDate', date('Y-m-d', strtotime('-60 days')), ['id'=>'startDate', 'class' => 'form-control controlForm', 'style' => 'width: 16%; float: right; margin: 10px 0px 0px 30px;', 'dusk'=>'startDate']) !!}
                    <p style="float: right; font-size: 12pt; margin: 14px 0px 0px 20px;">Start Date</p>
                    {{ Form::close() }}
                </div>

                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped {{ ('') ? "mav-datatable-report" :  "mav-datatable"}} ">
                            <thead> <!-- Table Headings -->
                            <th width="100px">@lang('labels.key')</th>
                            <th>@lang('labels.bone')</th>
                            <th>@lang('labels.side')</th>
                            <th class="col-hide">@lang('labels.bone_group')</th>
                            <th class="col-hide">@lang('labels.measured')</th>
                            <th>@lang('labels.dna_sampled')</th>
                            <th class="col-hide">@lang('labels.isotope_sampled')</th>
                            <th class="col-hide">@lang('labels.created_by')</th>
                            <th class="col-hide">@lang('labels.reviewed_by')</th>
                            </thead>
                            <tbody> <!-- Table Body -->
                        @foreach ($queryResults as $skeletalelement)
                            <tr>
                                <td class="table-text" style="vertical-align: middle;"><div><a dusk="se-skeletalelement-{{$skeletalelement->name}}" id='{{ $skeletalelement->name }}' href="{{ url('/skeletalelements/'.$skeletalelement->sb_id) }}">{{ $skeletalelement->name }}</a></div></td>
                                <td class="table-text" style="vertical-align: middle;"><div>{{ $skeletalelement->sb_name }}</div></td>
                                <td class="table-text" style="vertical-align: middle;"><div>{{ $skeletalelement->side }}</div></td>
                                <td class="table-text" style="vertical-align: middle;"><div>{{ $skeletalelement->group }}</div></td>
                                @if ($skeletalelement->measured)<td class="table-text text-success" style="text-align: center; vertical-align: middle;"><div>&#10004</div></td>@else<td class="table-text"></td>@endif
                                @if ($skeletalelement->dna_sampled)<td class="table-text text-success" style="text-align: center; vertical-align: middle;"><div>&#10004</div></td>@else<td class="table-text"></td>@endif
                                @if ($skeletalelement->isotope_sampled)<td class="table-text text-success" style="text-align: center; vertical-align: middle;"><div>&#10004</div></td>@else<td class="table-text"></td>@endif
                               <td class="table-text" style="vertical-align: middle;"><div>{{ $skeletalelement->user_name }}</div></td>
                                <td class="table-text" style="vertical-align: middle;"><div>{{ $skeletalelement->reviewer_name }}</div></td>
                            </tr>
                        @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @parent
    <style>
    </style>
    <script>
        var dashboard = null;
        new Vue({
            el: '#dashboard',
            data: {
                message: 'Hello Sachin'
            },
        })

    </script>
@endsection