@extends('skeletalelements.associations.common')

@section('association-content')
    <v-row align="center" justify="center">
        <v-col cols="12" class="m-0 p-0">
            <createdna :specimen="{{$skeletalelement}}" crud_action="{{$CRUD_Action}}"
                       heading="{{$heading}}">
            </createdna>
        </v-col>
    </v-row>
@endsection

@section('footer')
    @parent
    @include ('common._footer', ['CRUD_Action' => 'Create', 'includeStyle' => true, 'includeScript' => true])
@endsection