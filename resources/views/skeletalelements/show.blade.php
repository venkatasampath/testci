@extends('layouts.app')

@section('content')
    <v-row align="center" justify="center">
        <v-col cols="12" class="m-0 p-0">
            @include ('skeletalelements.partial', [ 'CRUD_Action' => 'View', 'heading' => $heading ])

            {{--            <v-card>--}}
{{--                <specimen crud_action="View" heading="{{$heading}}"--}}
{{--                          :specimen="{{isset($skeletalelement) ? $skeletalelement : json_encode('{}')}}"--}}
{{--                          dusk="specimen">--}}
{{--                </specimen>--}}
{{--                <v-form action="{{route('skeletalelements.show', $skeletalelement->id)}}" method="POST" id="specimen">--}}
{{--                    <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
{{--                    <input type="hidden" name="_method" value="PUT">--}}
{{--                    @include('common.errors')--}}
{{--                    @include('common.flash')--}}
{{--                </v-form>--}}
{{--            </v-card>--}}
        </v-col>
    </v-row>
@endsection

@section('footer')
    @include ('common._footer', ['CRUD_Action' => 'View', 'includeStyle' => true, 'includeScript' => true])
@endsection