@extends('layouts.app')
@if ($theProject != null && $theProject->skeletalelements()->count() > 0)
@php
    $mito_sequences = $theProject->mito_sequences(5);
    $mni_bones = $theProject->mni_by_bones(5);
    $mni_zones = $theProject->mni_by_zones(5);
    $an_by_p1 = $theProject->an_by_p1();
    $summary_se_records = $theProject->summary_se_records(30)->orderby('updated_at', 'asc')->get();
    $seDate = new DateTime($theProject->latest_se_summary_record()->updated_at, new DateTimeZone('UTC'));
    $dnaDate = new DateTime($theProject->latest_dna_summary_record()->updated_at, new DateTimeZone('UTC'));
//    $projectsummary_records = $theProject->summary_records(30)->orderby('updated_at', 'asc')->get();
//    $specimen_stats = json_decode($theProject->latest_summary_record()->specimen_stats, true);
//    $se_count = $specimen_stats['se_total'];
//    dd([$specimen_stats['se_total'], $specimen_stats, json_decode($theProject->latest_summary_record()->specimen_stats), $theProject->latest_se_summary_record()]);
@endphp
@endif

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <v-row align="center" justify="center">
        <v-col cols="12" class="m-0 p-0">
            <dashboard-project></dashboard-project>
        </v-col>
    </v-row>
@endsection

@section('footer')
@endsection




