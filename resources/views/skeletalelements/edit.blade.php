@extends('layouts.app')

@section('content')
    <v-row align="center" justify="center">
        <v-col cols="12" class="m-0 p-0">
            @include ('skeletalelements.partial', [ 'CRUD_Action' => 'Update', 'heading' => $heading ])

{{--            <v-card>--}}

{{--                <v-form action="{{route('skeletalelements.update', $skeletalelement->id)}}" method="POST" id="specimen-form">--}}
{{--                    <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
{{--                    <input type="hidden" name="_method" value="PUT">--}}
{{--                    @include('common.errors')--}}
{{--                    @include('common.flash')--}}
{{--                    @include ('skeletalelements.partial', [ 'CRUD_Action' => 'Update', 'heading' => $heading ])--}}
{{--                </v-form>--}}
{{--            </v-card>--}}
        </v-col>
    </v-row>
@endsection

@section('footer')
    @parent
    <style>
        /*.table td select { margin: 0px !important; }*/

    </style>

    <script>
        $(document).ready(function($) {
            var createAccessions =  $("#accessions").data("accession");
            if(createAccessions) {
                $('select#accession_number').select2({
                    tags: true
                });
                $('select#provenance1').select2({
                    tags: true
                });
                $('select#provenance2').select2({
                    tags: true
                });
            }
            $('select#type').select2();

            $("select#side, select#completeness").select2({
                minimumResultsForSearch: Infinity
            });
        });

        function validateOnSave() {
            var rc = true;
            if ($("select#sb_id").val() === "") {
                alert("Please select a Type");
                rc = false;
            } else if ($("select#side").val() === "") {
                alert("Please select a Side");
                rc = false;
            } else if ($("select#completeness").val() === "") {
                alert("Please select a Completeness");
                rc = false;
            }
            return rc;
        }
    </script>
@endsection

