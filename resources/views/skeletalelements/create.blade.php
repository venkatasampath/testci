@extends('layouts.app')

@section('content')
    <v-row align="center" justify="center">
        <v-col cols="12" class="m-0 p-0">
            <v-card>
                <specimen-create></specimen-create>
            </v-card>
        </v-col>
    </v-row>
@endsection

@section('footer')
    @include ('common._footer', ['CRUD_Action' => 'Create', 'includeStyle' => true, 'includeScript' => true])
@endsection

