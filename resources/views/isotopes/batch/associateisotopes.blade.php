@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <v-row align="center" justify="center">
        <v-col cols="12" class="m-0 p-0">
            <associateisotope :isotope-batch="{{$isotopeBatch}}"> </associateisotope>
        </v-col>
    </v-row>
@endsection

@section('footer')
    @parent
    @include ('common._footer', ['CRUD_Action' => 'Update', 'includeStyle' => true, 'includeScript' => true])
    <script>
    </script>
@endsection