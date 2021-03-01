@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <v-row align="center" justify="center">
        <v-col cols="12" class="m-0 p-0">
            <project-dna-report
                dna_type="ystr"
                :text="{{
                        json_encode([
                            'report_help'=> trans('messages.dna_ystr_report_help'),
                            'ystrSeqList' => $ystr
                        ])
                    }}"
            ></project-dna-report>
        </v-col>
    </v-row>
@endsection

@section('footer')
    @include ('common._footer', ['pageType' => 'Report', 'includeStyle' => true, 'includeScript' => true])
@endsection

