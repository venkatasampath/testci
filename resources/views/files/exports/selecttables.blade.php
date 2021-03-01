@extends('layouts.app')

@section('content')
    <head>
        <style>
            .scroll-users {
                height: 370px;
                overflow: scroll;
                border: 1px solid #F0F0F0;
                background-color: #F8F8F8;
                padding:0px;
                margin-bottom: 15px;
            }

            .scroll-users > .table {
                margin-bottom:0px;
            }

            #include-timestamps {
                margin-top: 2rem;
                font-size: xx-large;
            }

        </style>
    </head>
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-shadow">
                <div class="card-header">
                    <div class="row">
                        <div class="float-left col-4">
                            {{ Breadcrumbs::render('selectTables') }}
                        </div>
                        <div class="col-4">
                            <h3>Export Type: {{$exportType->name}}</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(['method' => 'POST', 'url' => url('exportType/'.$exportType->id), 'id' => 'exportTable']) !!}
                    <div class="row">
                        <div class="col-sm-6">
                            <input dusk="include-timestamps-checkbox" type="checkbox" name= "include-timestamps" id="include-timestamps" value=true />
                            Include Timestamps
                        </div>
                    </div><hr><br>
                    <div class="row">
                        @foreach($tableArray as $table => $columns)
                        <div class="col-sm-3">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="float-left">{{ ucwords(str_replace("_", " ", $table)) }}</h4>
                                    <div id="divCheckAll" class="float-right">
                                        <input dusk="select-all-columns-checkbox" type="checkbox" name="tables[]" value="{{$table}}" id="checkall_columns" onClick="selectAllColumns(this.value, this.checked);" checked/>
                                        Select All
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="scroll-users" id="mycheckboxesdiv">
                                        <table class="table">
                                            @foreach($columns as $column)
                                                <tr>
                                                    <td><input dusk="column-checkbox" type="checkbox" class="column_checkbox" name="{{$table}}[]" id="table{{$column}}" value={{$column}} checked></td>
                                                    <td><label class="form-check-label" for="table{{$column}}">{{ $column }}</label></td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row" style="margin-top:5px">
                        <div class="col-sm-12 text-center">
                            {!! Form::submit('Export Table',['class' => 'btn btn-primary', 'id' => 'submit-button']) !!}
                            <a dusk="cancel-button" class="btn btn-danger" href="{{url('/exportOptions')}}" id="cancel-button">Cancel</a>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectAllColumns(selectedTable, isAllChecked) {
            $('input[name="' + selectedTable + '[]"]').each(function() {
                this.checked = isAllChecked;
            });


        }
    </script>

    @endsection