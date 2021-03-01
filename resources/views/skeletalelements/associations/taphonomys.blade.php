@extends('skeletalelements.associations.common')

@section('association-content')
    <div>
        <taphonomy :list="{{$list_taphonomy}}" :specimen="{{$skeletalelement}}" heading="{{$heading}}"
                   :contentheader="true" :toolbar="true" :toolbar_crud="false" :cols="6">
        </taphonomy>
    </div>
@endsection

@section('footer')
@endsection