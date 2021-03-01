@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <v-row align="center" justify="center">
        <v-col cols="12" class="m-0 p-0">
            <isotope :isotope="{{$isotope}}" crud_action="{{$CRUD_Action}}" :list_isotope_batches="{{$list_isotope_batches}}"
            ></isotope>
        </v-col>
    </v-row>
@endsection

@section('footer')
    @parent
    @include ('common._footer', ['CRUD_Action' => 'View', 'includeStyle' => true, 'includeScript' => true])
@endsection