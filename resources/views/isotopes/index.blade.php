@extends('layouts.app')

{{--@section('title', config('app.name', 'CoRA')." ".$heading)--}}

@section('content')
{{--    <div class="container-fluid">--}}
{{--        <div class="row">--}}
{{--            <div class="col-md-12">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">--}}
{{--                        <div class="row">--}}
{{--                            <div class="float-left col-4"></div>--}}
{{--                            <div class="col-4">--}}
{{--                                <h4>{{ $heading }}  - <a href="{{ url('/skeletalelements/'.$skeletalelement->id) }}">{{ $skeletalelement->key }}</a></h4>--}}
{{--                            </div>--}}
{{--                            <div class="float-right col-4">--}}
{{--                                @include ('common._action', ['CRUD_Action' => 'List', 'object' => \App\Isotope::class, 'resource' => 'isotopes/'.$skeletalelement->id, 'disableMenu' => ['delete'] ])--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        @if (count($isotopes) > 0)--}}
{{--                            <div class="table-responsive">--}}
{{--                                <table class="table table-bordered table-striped mav-datatable-list">--}}
{{--                                    <thead> <!-- Table Headings -->--}}
{{--                                    <th>@lang('labels.sample_number')</th>--}}
{{--                                    <th>@lang('labels.external_case_id')</th>--}}
{{--                                    <th>Weight Sample Cleaned</th>--}}
{{--                                    <th>Yield Collagen</th>--}}
{{--                                    <th>Weight Vial Lid</th>--}}
{{--                                    <th class="hidecol">@lang('labels.created_by')</th>--}}
{{--                                    <th class="hidecol">@lang('labels.created_at')</th>--}}
{{--                                    <th class="hidecol">@lang('labels.updated_by')</th>--}}
{{--                                    <th class="hidecol">@lang('labels.updated_at')</th>--}}
{{--                                    </thead>--}}
{{--                                    <tbody> <!-- Table Body -->--}}
{{--                                    --}}
{{--                                    @foreach ($isotopes as $key=>$isotope)--}}
{{--                                        <tr>--}}
{{--                                            <td class="table-text"><div><a dusk="isotope-{{$key}}" href="{{ url('/isotopes/'.$skeletalelement->id.'/'.$isotope->id) }}">{{ $isotope->sample_number }}</a></div></td>--}}
{{--                                            <td class="table-text"><div>{{ $isotope->external_case_id }}</div></td>--}}
{{--                                            <td class="table-text"><div>{{ $isotope->weight_sample_cleaned }}</div></td>--}}
{{--                                            <td class="table-text"><div>{{ $isotope->yield_collagen }}</div></td>--}}
{{--                                            <td class="table-text"><div>{{ $isotope->weight_vial_lid }}</div></td>--}}
{{--                                            <td class="table-text"><div>{{ $isotope->created_by }}</div></td>--}}
{{--                                            <td class="table-text"><div>{{ $isotope->created_at }}</div></td>--}}
{{--                                            <td class="table-text"><div>{{ $isotope->updated_by }}</div></td>--}}
{{--                                            <td class="table-text"><div>{{ $isotope->updated_at }}</div></td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        @else--}}
{{--                            <div class="alert alert-info">--}}
{{--                                <h4>@lang('messages.no_records_found', ['model' => 'Isotope'])</h4>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <isotopeviewtable
            :specimen_id="'{{$skeletalelement->id}}'"
            :sb_id="'{{$skeletalelement->sb_id}}'"
            :base_url="{{json_encode(url('/'))}}"
            :laboptions="{{$list_lab}}"
            :placeholder_external_id="'{{trans('messages.placeholder_externalID')}}'"
            :externalcasenumberlabel="'{{trans('labels.external_case_#').':'}}'"
            :org_id="'{{$skeletalelement->org_id}}'"
            :project_id="'{{$skeletalelement->project_id}}'"
            {{--                Autocomplete Data Elements--}}
            :list_lab="{{$list_lab}}"
            :list_confidence="{{json_encode($list_confidence, true)}}"
            :isotopebatchoptions="{{$list_isotope_batches}}"
            {{--                Labels--}}
            :external_case_number_label="'{{trans('labels.external_case_#').':'}}'"
            :placeholder_sampleNumber="'{{trans('messages.placeholder_sampleNumber')}}'"
            :labels_isotope_batches="'{{trans('labels.isotope_batches')}}'"
            :labels_results_status="'{{trans('labels.results_status')}}'"
            :org_mass_unit_of_measure="'{{$theOrg->getProfileValue('org_mass_unit_of_measure')}}'"
            :placeholder_mass="'{{trans('messages.placeholder_mass')}}'"
            :isotopebatchlabel="'{{trans('labels.isotope_batches')}}'"
            ::resultsstatuslabel="'{{trans('labels.results_status')}}'"
    ></isotopeviewtable>

@endsection

{{--@section('footer')--}}
{{--    @include ('common._footer', ['CRUD_Action' => 'List', 'pageType' => 'List','includeStyle' => true, 'includeScript' => true,  'initialshow' => false])--}}
{{--@endsection--}}