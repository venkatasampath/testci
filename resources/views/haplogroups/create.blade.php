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
                                {{ Breadcrumbs::render('haplogroups.create') }}
                            </div>
                            <div class="col-4"><h4>{{ $heading }}</h4></div>
                            <div class="float-right col-4"> <!-- Action Button Section -->
                                @include ('common._action', ['CRUD_Action' => 'Create', 'object' => \App\Haplogroup::class, 'resource' => 'haplogroups', 'disableMenu' => ['delete']])
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('common.errors')
                        @include('common.flash')

                        {!! Form::open(['class' => 'form-horizontal', 'method' => 'POST', 'action' => ['HaplogroupsController@store']]) !!} {{ csrf_field() }}
                        @include ('haplogroups.partial', ['CRUD_Action' => 'Create'])
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