@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <div class="row">
                            <div class="float-left col-4">
                                {{ Breadcrumbs::render('skeletalelements.show', $skeletalelement) }}
                            </div>
                            <div class="col-4"><h4>{{ $heading }}</h4></div>
                            <div class="float-right col-4">
                                @include ('common._action', ['CRUD_Action' => 'Update', 'object' => $pairInfo, 'resource' => 'skeletalelements/'.$skeletalelement->id.'/pairs', 'disableMenu' => ['delete','create','list']])
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {!! Form::open(array('url' => '/skeletalelements/'.$skeletalelement->id.'/pairs/'.$pair->id.'/update', 'class'=>'form-horizontal')) !!}
                        @include ('pairs.partial', ['CRUD_Action' => 'Update'])
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