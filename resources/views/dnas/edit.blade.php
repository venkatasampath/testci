@extends('skeletalelements.associations.common')

@section('association-content')
<sumform
        :specimen="{{$skeletalelement}}" crud_action="{{$CRUD_Action}}"
        heading="{{$heading}}" :dna="{{$dna}}"
        :remainingweightsuffix="{{json_encode($theOrg->getProfileValue('org_mass_unit_of_measure'))}}"
        :mitohaplooptions="{{json_encode($list_mito_haplogroup)}}"
        :mitomethodoptions="{{json_encode($list_mito_method)}}"
        :statusoptions="{{json_encode($list_confidence)}}"
        :ystrhaplooptions="{{json_encode($list_y_haplogroup)}}"
        :ystrmethodoptions="{{json_encode($list_y_method)}}"
        :austrmethodoptions="{{json_encode($list_auto_method)}}"
        :dispositionoptions="{{json_encode($list_disposition)}}"
        :conditionoptions="{{json_encode($list_sample_condition)}}">
</sumform>
@endsection

@section('footer')
    @include ('common._footer', ['CRUD_Action' => 'Update', 'includeStyle' => true, 'includeScript' => true, 'dnaPage' => true])
@endsection

