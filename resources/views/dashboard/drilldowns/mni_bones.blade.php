@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <div class="container-fluid" style="margin-top: 20px">
        <specimen-bar-chart :chart_type="{{json_encode($chartType)}}">
        </specimen-bar-chart>
    </div>
@endsection

@section('footer')
    @parent
    <style>
    </style>
    <script>

    </script>
@endsection