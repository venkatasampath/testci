@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <dna-list :specimen="{{$skeletalelement}}" crud_action="{{$CRUD_Action}}"
                  heading="{{$heading}}" :dnas="{{$dna}}"
                  :remainingweightsuffix="{{json_encode($theOrg->getProfileValue('org_mass_unit_of_measure'))}}"
                  :mitohaplooptions="{{json_encode($list_mito_haplogroup)}}"
                  :mitomethodoptions="{{json_encode($list_mito_method)}}"
                  :statusoptions="{{json_encode($list_confidence)}}"
                  :ystrhaplooptions="{{json_encode($list_y_haplogroup)}}"
                  :ystrmethodoptions="{{json_encode($list_y_method)}}"
                  :austrmethodoptions="{{json_encode($list_auto_method)}}"
                  :dispositionoptions="{{json_encode($list_disposition)}}"
                  :conditionoptions="{{json_encode($list_sample_condition)}}"
        ></dna-list>
    </div>
@endsection

@section('footer')
    @include ('common._footer', ['CRUD_Action' => 'List', 'includeStyle' => true, 'includeScript' => true])
    @parent
    <style>

    </style>
    <script>

    </script>
@endsection

