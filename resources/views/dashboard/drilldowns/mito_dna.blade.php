@extends('layouts.app')


@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <div class="container-fluid" style="margin-top: 20px">
        <dna-pie-chart dna_type="mito"></dna-pie-chart>
    </div>
@endsection

@section('footer')
    @parent
    <style>
    </style>
    <script>

    </script>
@endsection