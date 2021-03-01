@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <v-row align="center" justify="center">
        <v-col cols="12" class="m-0 p-0">
            <project-measurement-report></project-measurement-report>
        </v-col>
    </v-row>

@endsection

@section('footer')
@endsection