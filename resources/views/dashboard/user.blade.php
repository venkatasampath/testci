@extends('layouts.app')
@if ($theProject != null && $theProject->skeletalelements()->count() > 0)
    @php
        $mito_sequences = $theProject->mito_sequences(5);
        $mni_bones = $theProject->mni_by_bones(5);
        $mni_zones = $theProject->mni_by_zones(5);
        $summary_se_records = $theProject->summary_se_records(30)->orderby('updated_at', 'asc')->get();
    @endphp
@endif

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <v-row align="center" justify="center">
        <v-col cols="12" class="m-0 p-0">
            <dashboard-user></dashboard-user>
        </v-col>
    </v-row>
@endsection

@section('footer')
@endsection