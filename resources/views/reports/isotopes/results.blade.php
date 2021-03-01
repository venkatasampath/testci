@if(isset($isotopes) && count($isotopes) > 0)
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mav-datatable-report">
                <thead>
                <th width="20%">@lang('labels.key')</th>
                <th>@lang('labels.bone')</th>
                <th>@lang('labels.side')</th>
                <th>@lang('labels.bone_group')</th>
                <th>@lang('labels.individual_number')</th>
                <th>@lang('labels.sample_number')</th>
                <th>@lang('labels.results_status')</th>
                <th class="hidecol">@lang('labels.created_by')</th>
                <th class="hidecol">@lang('labels.created_at')</th>
                <th class="hidecol">@lang('labels.updated_by')</th>
                <th class="hidecol">@lang('labels.updated_at')</th>
                </thead>
                <tbody>
                @foreach ($isotopes as $isotope)
                    @if(isset($isotope) && isset($isotope->skeletalelement))
                        <tr>
                            @can('edit', $isotope)
                                @if ( $open_result_new_tab )
                                    <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$isotope->skeletalelement->id) }}" target="_blank">{{ $isotope->skeletalelement->key }} </a></div></td>
                                @else
                                    <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$isotope->skeletalelement->id) }}">{{ $isotope->skeletalelement->key }}</a></div></td>
                                @endif
                            @else
                                <td class="table-text"><div>{{ $isotope->skeletalelement->key}}</div></td>
                            @endcan
                            <td class="table-text">{{ $isotope->skeletalelement->skeletalbone->name }}</td>
                            <td class="table-text">{{ $isotope->skeletalelement->side }}</td>
                            <td class ="table-text"><div><a href={{ url('reports/bonegroup/' . $isotope->skeletalelement->bone_group_id)}}>{{$isotope->skeletalelement->bone_group}}</a></div></td>
                            <td class ="table-text"><div><a href={{ url('reports/individualnumber/' . urlencode($isotope->skeletalelement->individual_number))}}>{{$isotope->skeletalelement->individual_number}}</a></div></td>
                            @can('edit', $isotope->skeletalelement)
                                @if ( $open_result_new_tab )
                                    <td class="table-text"><div><a dusk="isotope-{{$isotope->sample_number}}" href="{{ url('isotopes/'. $isotope->se_id."/". $isotope->id) }}">{{ $isotope->sample_number }}</a></div></td>
                                @else
                                    <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$isotope->skeletalelement->id.'/isotopes/'.$isotope->id) }}">{{ $isotope->sample_number }}</a></div></td>
                                @endif
                            @else
                                <td class="table-text"><div>{{ $isotope->sample_number }}</div></td>
                            @endcan
                            <td class="table-text">{{ $isotope->results_confidence }}</td>
                            <td class="table-text">{{ $isotope->created_by }}</td>
                            <td class="table-text">{{ $isotope->created_at }}</td>
                            <td class="table-text">{{ $isotope->updated_by }}</td>
                            <td class="table-text">{{ $isotope->updated_at }}</td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    @if (!$initialshow)
        <div class="card-body"><h4>@lang('messages.no_records_found_refine_search', ['model' => 'Isotope'])</h4></div>
    @endif
@endif