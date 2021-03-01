@extends('skeletalelements.associations.common')

@section('association-content')
    <div id="Vue-Isotope">
        <isotope
                {{--                Autocomplete Data Elements--}}
                :list_lab="{{$list_lab}}"
                :list_confidence="{{json_encode($list_confidence, true)}}"
                :list_isotope_batches="{{$list_isotope_batches}}"
                {{--                Data V-Models--}}
                :isotopesamplenumbergpvmodel="'{{$isotope->sample_number}}'"
                ::isotopesamplenumberdisabled="true"
                :isotopelabvmodelgpc="{{json_encode($isotope->lab_id)}}"
                :external_case_number_data="'{{$isotope->external_case_id}}'"
                :se_id="'{{$skeletalelement->id}}'"
                :isotopebatchoptionsvmodelgpc="'{{$isotope->batch_id}}'"
                :resultsstatusoptionsvmodelgpc="'{{$isotope->results_confidence}}'"
                :weightsampledcleanedtypevmodegpc="'{{$isotope->weight_sample_cleaned}}'"
                :yieldcollagenvmodegpc="'{{$isotope->yield_collagen}}'"
                :weightvialnlidvmodegpc="'{{$isotope->weight_vial_lid}}'"
                :weightsamplevialnlidvmodegpc="'{{$isotope->weight_sample_vial_lid}}'"
                :weightcollagenvmodegpc="'{{$isotope->weight_collagen}}'"
                :analysisrequestedvmodelgpc="'{{$isotope->analysis_requested}}'"
                :welllocationvmodelgpc="'{{$isotope->well_location}}'"
                :collagenweightusedforanalysisvmodelgpc="'{{$isotope->collagen_weight_used_for_analysis}}'"
                :carbonweightvmodelgpc="'{{$isotope->c_weight}}'"
                :carbondeltavmodelgpcg="'{{$isotope->c_delta}}'"
                :carbonpercentagevmodelgpc="'{{$isotope->c_percent}}'"
                :carbonnitrogenratiovmodelgpc="'{{$isotope->c_to_n_ratio}}'"
                :nitrogenpercentagevmodelgpc="'{{$isotope->n_percent}}'"
                :nitrogenweightvmodelgpc="'{{$isotope->n_weight}}'"
                :nitrogendeltavmodelgpc="'{{$isotope->n_delta}}'"
                :oxygendeltavmodelgpc="'{{$isotope->o_delta}}'"
                :carbonoxygenratiovmodelgpc="'{{$isotope->c_to_o_ratio}}'"
                :oxygenpercentagevmodelgpc="'{{$isotope->o_percent}}'"
                :oxygenweightvmodelgpc="'{{$isotope->o_weight}}'"
                :sulpherpercentagevmodelgpc="'{{$isotope->s_percent}}'"
                :sulpherweightvmodelgpc="'{{$isotope->s_weight}}'"
                :sulpherdeltavmodelgpc="'{{$isotope->s_delta}}'"
                {{--                Labels--}}
                :external_case_number_label="'{{trans('labels.external_case_#').':'}}'"
                :placeholder_external_id="'{{trans('messages.placeholder_externalID')}}'"
                :placeholder_sampleNumber="'{{trans('messages.placeholder_sampleNumber')}}'"
                :labels_isotope_batches="'{{trans('labels.isotope_batches')}}'"
                :labels_results_status="'{{trans('labels.results_status')}}'"
                :org_mass_unit_of_measure="'{{$theOrg->getProfileValue('org_mass_unit_of_measure')}}'"
                :placeholder_mass="'{{trans('messages.placeholder_mass')}}'"
                :action="{{json_encode(action('IsotopesController@update', $isotope->id))}}"
                csrf="{{ csrf_token() }}"
                action="{{'/isotopes/'.$isotope->id}}"
        ></isotope>
    </div>
@endsection
