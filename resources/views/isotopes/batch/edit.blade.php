@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="float-left col-4"></div>
                            <div class="col-4"><h4>{{ $heading }} - {{ $isotopeBatch->batch_num }} - {{ trans('labels.samples_count', ['count'=>$isotopeBatch->count_samples]) }} </h4></div>
                            <div class="float-right col-4">
                                @include ('common._action', ['CRUD_Action' => 'Update', 'object' => $isotopeBatch, 'resource' => 'isotopebatch', 'disableMenu' => ['delete'] ])
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! Form::model($isotopeBatch, ['method' => 'PATCH', 'action' => ['IsotopeBatchesController@update', $isotopeBatch->id], 'class' => 'form-horizontal', 'onsubmit' => 'return validateOnSave();']) !!}
                        @include ('isotopes.batch.partial', ['CRUD_Action' => 'Update'])
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include ('common._footer', ['CRUD_Action' => 'Update', 'includeStyle' => true, 'includeScript' => true])
@endsection