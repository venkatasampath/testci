<style>
    div.dataTables_wrapper .dataTables_length .form-control {
        height: auto !important;
    }
</style>
@if (isset($skeletalelements) && count($skeletalelements) > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-striped mav-datatable-search">
            <thead> <!-- Table Headings -->
                <th width="20%">@lang('labels.key')</th>
                <th>@lang('labels.bone')</th>
                <th>@lang('labels.side')</th>
                <th>@lang('labels.bone_group')</th>
                <th>@lang('labels.individual_number')</th>
                <th>@lang('labels.dna_sampled')</th>
                <th>@lang('labels.mito_sequence_number')</th>
{{--                <th>@lang('labels.associations')</th>--}}
                <th>@lang('labels.measured')</th>
                <th>@lang('labels.isotope_sampled')</th>
                <th>@lang('labels.clavicle_triage')</th>
                <th>@lang('labels.ct_scanned')</th>
                <th>@lang('labels.xray_scanned')</th>
                <th class="hidecol">@lang('labels.inventoried')</th>
                <th class="hidecol">@lang('labels.reviewed')</th>
                <th class="hidecol">@lang('labels.inventoried_by')</th>
                <th class="hidecol">@lang('labels.inventoried_at')</th>
                <th class="hidecol">@lang('labels.reviewed_by')</th>
                <th class="hidecol">@lang('labels.reviewed_at')</th>
                <th class="hidecol">@lang('labels.created_by')</th>
                <th class="hidecol">@lang('labels.created_at')</th>
                <th class="hidecol">@lang('labels.updated_by')</th>
                <th class="hidecol">@lang('labels.updated_at')</th>
            </thead>
            <tbody> <!-- Table Body -->
            @foreach ($skeletalelements as $key=>$skeletalelement)
                <tr>
                    @can('edit', $skeletalelement)
                        @if ( $open_result_new_tab )
                            <td class="table-text" style="width: 20%">
                                <div><a dusk="se-skeletalelement-{{$key}}" id='{{ $skeletalelement->key }}' href="{{ url('/skeletalelements/'.$skeletalelement->id) }}" target="_blank">{{ $skeletalelement->key }}</a></div>
                            </td>
                        @else
                            <td class="table-text" style="width: 20%"><div><a dusk="se-skeletalelement-{{$key}}" id='{{ $skeletalelement->key }}' href="{{ url('/skeletalelements/'.$skeletalelement->id) }}">{{ $skeletalelement->key }}</a></div>
                            </td>
                        @endif
                    @else
                        <td class="table-text" style="width: 20%"><div>{{ $skeletalelement->key }}</div></td>
                    @endcan
                    <td class="table-text"><div>{{ $skeletalelement->skeletalbone->name }}</div></td>
                    <td class="table-text"><div>{{ $skeletalelement->side }}</div></td>
                    <td class ="table-text"><div><a href={{ url('reports/bonegroup/' . $skeletalelement->bone_group_id)}}>{{$skeletalelement->bone_group}}</a></div></td>
                    <td class ="table-text"><div><a href={{ url('reports/individualnumber/' . urlencode($skeletalelement->individual_number))}}>{{$skeletalelement->individual_number}}</a></div></td>
                    @if ($skeletalelement->dna_sampled)
                        <td class="table-text">
                        <div>
                            @foreach ($skeletalelement->dnas as $dna)
                                <a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/dnas/'.$dna->id) }}" target="_blank">{{ $dna->sample_number }}</a><br>
                            @endforeach
                        </div>
                        </td>
                    @else
                        <td class="table-text"></td>
                    @endif
                    <td class ="table-text"><div><a href={{ url('reports/mtdna/' . $skeletalelement->mito_sequence_number)}}>{{$skeletalelement->mito_sequence_number}}</a></div></td>
{{--                    @if ($skeletalelement->hasAssociations())--}}
{{--                        <td class="table-text">--}}
{{--                            @if($skeletalelement->pairs->count())--}}
{{--                                <a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/pairs/') }}" target="_blank">{{ $skeletalelement->getAssociationLinks('pair') }}</a><br>--}}
{{--                            @endif--}}
{{--                            @if($skeletalelement->articulations->count())--}}
{{--                                <a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/articulations/') }}" target="_blank">{{ $skeletalelement->getAssociationLinks('articulation') }}</a><br>--}}
{{--                            @endif--}}
{{--                            @if($skeletalelement->refits->count())--}}
{{--                                <a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/refits/') }}" target="_blank">{{ $skeletalelement->getAssociationLinks('refit') }}</a><br>--}}
{{--                            @endif--}}
{{--                        </td>--}}
{{--                    @else--}}
{{--                        <td class="table-text"></td>--}}
{{--                    @endif--}}
                    @if ($skeletalelement->measured)<td class="table-text text-success">&#10004</td>@else<td class="table-text"></td>@endif
                    @if ($skeletalelement->isotope_sampled)
                        <td class="table-text">
                            <div>
                                @foreach ($skeletalelement->isotopes as $isotope)
                                    <a href="{{ url('/isotopes/'.$skeletalelement->id.'/'.$isotope->id) }}" target="_blank">{{ $isotope->sample_number }}</a><br>
                                @endforeach
                            </div>
                        </td>
                    @else
                        <td class="table-text"></td>
                    @endif
                    @if ($skeletalelement->clavicle_triage)<td class="table-text text-success">&#10004</td>@else<td class="table-text"></td>@endif
                    @if ($skeletalelement->ct_scanned)<td class="table-text text-success">&#10004</td>@else<td class="table-text"></td>@endif
                    @if ($skeletalelement->xray_scanned)<td class="table-text text-success">&#10004</td>@else<td class="table-text"></td>@endif
                    @if ($skeletalelement->inventoried)<td class="table-text text-success">&#10004</td>@else<td class="table-text"></td>@endif
                    @if ($skeletalelement->reviewed)<td class="table-text text-success">&#10004</td>@else<td class="table-text"></td>@endif
                    <td class="table-text"><div>{{ isset($skeletalelement->user_id) ? $skeletalelement->user->name : ""  }}</div></td>
                    <td class="table-text"><div>{{ $skeletalelement->inventoried_at }}</div></td>
                    <td class="table-text"><div>{{ isset($skeletalelement->reviewer_id) ? $skeletalelement->reviewer->name : "" }}</div></td>
                    <td class="table-text"><div>{{ $skeletalelement->reviewed_at }}</div></td>
                    <td class="table-text"><div>{{ $skeletalelement->created_by }}</div></td>
                    <td class="table-text"><div>{{ $skeletalelement->created_at }}</div></td>
                    <td class="table-text"><div>{{ $skeletalelement->updated_by }}</div></td>
                    <td class="table-text"><div>{{ $skeletalelement->updated_at }}</div></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    @if (!$initialshow)
        <div class="alert alert-info">
            <h4>@lang('messages.no_records_found_refine_search', ['model' => 'Specimen'])</h4>
            <h4>@lang('messages.search_default_help')</h4>
        </div>
    @endif
@endif
