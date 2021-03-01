@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".trans('labels.individual_number_details_report'))

@section('content')
    <v-row align="center" justify="center">
        <v-col cols="12" class="m-0 p-0">
            <org-individual-number-details-report
                    :text="{{
                        json_encode([
                            'report_help'=> trans('messages.individual_number_details_report_help')
                        ])
                    }}"
            ></org-individual-number-details-report>
        </v-col>
    </v-row>
@endsection

@section('footer')
    @include ('common._footer', ['pageType' => 'Report', 'includeStyle' => true, 'includeScript' => true, 'autoWidth' => false])
@endsection

