<v-card>
    <specimen crud_action="{{$CRUD_Action}}" heading="{{$heading}}"
              :specimen="{{isset($skeletalelement) ? $skeletalelement : json_encode('{}')}}"
              dusk="specimen">
    </specimen>
</v-card>

@section('footer')
    @parent
    <style>
        div.v-application--wrap{
            min-height: 0;
        }
    </style>
@endsection
