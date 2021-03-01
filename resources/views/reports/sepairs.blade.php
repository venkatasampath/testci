@extends('layouts.app')

@section('content')
{!! Form::open(['url' => 'reports/sepairs']) !!}
        <!-- Display Validation Errors -->
@include('common.errors')
@include('common.flash')

<div class="card ">
    <div class="card-header">
        <div class="float-right">
            <div class="form-group">
                {!! Form::button('<i class="fas fa-btn fa-list"></i>Generate', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
            </div>
        </div>
        <div><h4 style="text-align:center;">{{$heading}}</h4></div>
    </div>

    <div class="card-body" style="padding-top: 0px; padding-bottom: 0px;">
        <table class="table skeletalelement-table" style="margin-bottom: 0px;">
            <tbody>
            <tr>
                <td><div class="form-group">
                    <div class="col-lg-3">{!! Form::label('select', 'Bones', ['class' => 'control-label']) !!}</div>
                    <div class="col-lg-9">{{ Form::select('sb_id', $list_sb, $sb_id, ['id' => 'sb_id', 'placeholder' => 'Select Bone', 'class' => 'mav-select']) }}</div>
                </div></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
{!! Form::close() !!}

@stop

@section('footer')
    <div class="card">
        <div class="card-body dataviz">
            <script type="text/javascript">
                var dataviz_data_rightside = '<?php echo json_encode($rightside);?>';
                var dataviz_data_leftside = '<?php echo json_encode($leftside);?>';
            </script>
            @include('dataviz.bipartite')
        </div>
    </div>

    <style>
        .table td { border: 0px !important; }
        .table td { padding: 2px !important; }
        .table th { padding: 2px !important; }
        div.col-lg-10 { padding: 2px !important; }
        .table td select { margin: 0px !important; }
        div.card-body {padding: 5px !important; }
        a.dt-button { padding: 5px !important }
        .dataTables_wrapper .dt-buttons { float:none; text-align:center; }
        table.mav-datatable-report {margin-top: 25px !important;}

        div.dataviz { width: 1200px; height: 800px; font-family: "Helvetica Neue",Helvetica,Arial,sans-serif; }

    </style>

    <script>
        $(document).ready(function($){
            $('table.skeletalelement-table select').select2();
            document.title = 'CoRA Dataviz';
        });

    </script>
@stop
