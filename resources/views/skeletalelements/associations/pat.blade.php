@extends('layouts.app')

@section('content')
    <div id="pat-rendering">
        <pat :specimen="{{$skeletalelements}}" crud_action="{{$CRUD_Action}}"
             heading="{{$heading}}" :contentheader="true" :toolbar="false" :toolbar_crud="false">
        </pat>
    </div>
@endsection