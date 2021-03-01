@extends('layouts.app')


@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <div class="container-fluid" style="margin-top: 20px">

        <dna-user-activity></dna-user-activity>

    </div>
@endsection

@section('footer')
    @parent
    <style>
    </style>
    <script>

    </script>
@endsection
