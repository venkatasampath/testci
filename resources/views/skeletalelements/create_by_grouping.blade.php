@extends('layouts.app')

@section('content')
      <v-row align="center" justify="center">
            <v-col cols="12" class="m-0 p-0">
                  <specimen-create-by-bone-group
                          :text="{{
                        json_encode([
                            'bone_group_filter' => $bone_group_filter
                        ])
                    }}">
                  </specimen-create-by-bone-group>
            </v-col>
      </v-row>
@endsection