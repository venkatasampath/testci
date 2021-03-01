@extends('skeletalelements.associations.common')

@section('association-content')
    {!! Form::model($skeletalelement, ['class' => 'form-horizontal', 'method' => 'POST', 'action' => ['SkeletalElementsController@associatezones', $skeletalelement->id]]) !!}{{ csrf_field() }}
    <zones :specimen="{{$skeletalelement}}" crud_action="{{$CRUD_Action}}"
           :contentheader="true" :toolbar="true" :toolbar_crud="false" :cols="6">
    </zones>
    {!! Form::close() !!}
@endsection

@section('footer')
{{--    @parent--}}
{{--    @include ('common._footer', ['CRUD_Action' => $CRUD_Action, 'includeStyle' => true, 'includeScript' => true])--}}
@endsection
