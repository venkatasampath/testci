@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="float-left col-4">
                                {{ Breadcrumbs::render('instruments.create') }}
                            </div>
                            <div class="col-4"><h4>{{ $heading }}</h4></div>
                            <div class="float-right col-4"> <!-- Action Button Section -->
                                @include ('common._action', ['CRUD_Action' => 'Create', 'object' => \App\Instrument::class, 'resource' => 'instruments', 'disableMenu' => []])
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! Form::open(['class' => 'form-horizontal', 'route' => 'instruments.store', 'onsubmit' => 'return validateOnSave();']) !!}
                        @include('common.errors')
                        @include('common.flash')

                        @include ('instruments.partial', ['CRUD_Action' => 'Create'])
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include ('common._footer', ['CRUD_Action' => 'Create', 'includeStyle' => true, 'includeScript' => true])
@endsection