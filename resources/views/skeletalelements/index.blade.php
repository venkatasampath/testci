@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="float-left col-4">
                                {{ Breadcrumbs::render('skeletalelements.index') }}
                            </div>
                            <div class="col-4"><h4>{{ $heading }}</h4></div>
                            <div class="float-right col-4"> <!-- Action Button Section -->
                                @include ('common._action', ['CRUD_Action' => 'List', 'object' => \App\SkeletalElement::class, 'resource' => 'skeletalelements', 'disableMenu' => []])
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include("skeletalelements.components.searchresults", ['withBtn' => false])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include ('common._footer', ['CRUD_Action' => 'List', 'includeStyle' => true, 'includeScript' => true])
@endsection
