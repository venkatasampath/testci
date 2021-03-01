@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

{{--@section('title', config('app.name', 'CoRA')." ".$heading)--}}
@section('styles')
@endsection

@section('content')
    <v-row align="center" justify="center">
        <v-col cols="12" class="m-0 p-0">
            <review-main :specimen="{{json_encode($skeletalelement)}}"
                         :specimen_id="{{json_encode($skeletalelement->id)}}"
                         :base_url="{{json_encode(url('/'))}}"
                         :sb_id="{{json_encode($skeletalelement->bone->id)}}"
                         :suffix="{{json_encode($theOrg->getProfileValue('org_length_unit_of_measure'))}}"
                         :laboptions="{{json_encode($list_lab)}}"
                         :methodoptions="{{json_encode($list_method)}}"
                         :austrstatusoptions="{{json_encode($list_confidence)}}"
                         :statusoptions="{{json_encode($list_confidence)}}"
                         :statusoptions="{{json_encode($list_confidence)}}"
                         :list_zones="{{$list_zones}}"
                         :list_pathology="{{$list_pathology}}"
                         :list_trauma="{{$list_trauma}}"
                         :list_anomaly="{{$list_anomaly}}"
                         :list_sb="{{$list_sb}}"
                         :zones_base_data="{{$zones_base_data}}"
                         :dispositionoptions="{{json_encode($list_disposition)}}"
                         :conditionoptions="{{json_encode($list_sample_condition)}}"
                         :ystrhaplooptions="{{json_encode($list_y_haplogroup)}}"
                         :ystrmethodoptions="{{json_encode($list_y_method)}}"
                         :austrmethodoptions="{{json_encode($list_auto_method)}}"
                         :ystrhaplooptions="{{json_encode($list_y_haplogroup)}}"
                         :mitohaplooptions="{{json_encode($list_mito_haplogroup)}}"
                         :mitomethodoptions="{{json_encode($list_mito_method)}}"
                         :list_confidence="{{json_encode($list_confidence)}}"
            >
            </review-main>
        </v-col>
    </v-row>
@endsection

@section('footer')
{{--    @parent--}}
{{--    @include ('common._footer', ['pageType' => 'Update', 'includeStyle' => true, 'includeScript' => true])--}}
@endsection