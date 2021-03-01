@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".trans('labels.home'))

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @include('common.errors')
                    @include('common.flash')
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
