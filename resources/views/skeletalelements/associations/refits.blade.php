@extends('skeletalelements.associations.common')

@section('association-content')

        <div>
            <refits
                    :list="{{$list_se}}" :specimen="{{$skeletalelement}}" crud_action="{{$CRUD_Action}}"
                    heading="{{$heading}}" :contentheader="true" :toolbar="true" :toolbar_crud="false" :cols="6"
                    refitsDetails="{{$skeletalelements}}"
            >
            </refits>
        </div>
@endsection

@section('footer')
    @parent
    @include ('common._footer', ['CRUD_Action' => $CRUD_Action, 'pageType' => 'Search', 'includeStyle' => true, 'includeScript' => true])
    <script>
    </script>
@endsection
