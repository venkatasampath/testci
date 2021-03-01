@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <v-row align="center" justify="center">
        <v-col cols="12" class="m-0 p-0">
            <accession-management></accession-management>
        </v-col>
    </v-row>
@endsection

@section('footer')
    @include ('common._footer', ['CRUD_Action' => 'List', 'pageType' => 'List', 'includeStyle' => true, 'includeScript' => true, 'initialshow' => false])
@endsection
