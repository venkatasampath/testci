@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <v-row align="center" justify="center">
        <v-col cols="12" class="m-0 p-0">
            <project-method-report></project-method-report>
        </v-col>
    </v-row>

@endsection

@section('footer')
    @include ('common._footer', ['pageType' => 'Report', 'includeStyle' => true, 'includeScript' => true])
@endsection