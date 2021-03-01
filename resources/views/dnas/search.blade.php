@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <v-row align="center" justify="center">
        <v-col cols="12" class="m-0 p-0">
            @php
                if(session()->has('dnas')) {
                    $dnas = session('dnas');
                }
                if(session()->has('skeletalelements')) {
                    $skeletalelements = session('skeletalelements');
                }
            @endphp

            <dnasearchresults heading="{{$heading}}"></dnasearchresults>
        </v-col>
    </v-row>
@endsection

@section('footer')
    {{--@parent--}}
    @include ('common._footer', ['pageType' => 'Search', 'includeStyle' => true, 'includeScript' => true])
@endsection
