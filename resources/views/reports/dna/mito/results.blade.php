@if(isset($dnas) && count($dnas) > 0)
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
            <th>@lang('labels.mito_sequence')</th>
            <th>@lang('labels.mito_sequence_subgroup')</th>
            <th>@lang('labels.mito_sequence_similar')</th>
            <th>@lang('labels.mito_result_status')</th>
            <th>@lang('labels.mito_request_date')</th>
            <th>@lang('labels.mito_recieve_date')</th>
            <th class="hidecol">@lang('labels.created_by')</th>
            <th class="hidecol">@lang('labels.created_at')</th>
            <th class="hidecol">@lang('labels.updated_by')</th>
            <th class="hidecol">@lang('labels.updated_at')</th>
            </thead>
            <tbody>
            @foreach ($dnas as $dna)
                @if(isset($dna) && isset($dna->skeletalelement))
                    <tr>
                        @can('edit', $dna)
                            @if ( $open_result_new_tab )
                                <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$dna->skeletalelement->id) }}" target="_blank">{{ $dna->skeletalelement->key }} </a></div></td>
                            @else
                                <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$dna->skeletalelement->id) }}">{{ $dna->skeletalelement->key }}</a></div></td>
                            @endif
                        @else
                            <td class="table-text"><div>{{ $dna->skeletalelement->key}}</div></td>
                        @endcan
                        <td class="table-text">{{ $dna->skeletalelement->skeletalbone->name }}</td>
                        <td class="table-text">{{ $dna->skeletalelement->side }}</td>
                        <td class ="table-text"><div><a href={{ url('reports/bonegroup/' . $dna->skeletalelement->bone_group_id)}}>{{$dna->skeletalelement->bone_group}}</a></div></td>
                        <td class ="table-text"><div><a href={{ url('reports/individualnumber/' . urlencode($dna->skeletalelement->individual_number))}}>{{$dna->skeletalelement->individual_number}}</a></div></td>
                        @can('edit', $dna->skeletalelement)
                            @if ( $open_result_new_tab )
                                <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$dna->skeletalelement->id.'/dnas/'.$dna->id) }}" target="_blank">{{ $dna->sample_number }}</a></div></td>
                            @else
                                <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$dna->skeletalelement->id.'/dnas/'.$dna->id) }}">{{ $dna->sample_number }}</a></div></td>
                            @endif
                        @else
                            <td class="table-text"><div>{{ $dna->sample_number }}</div></td>
                        @endcan
                        <td class ="table-text"><div><a href={{ url('reports/mtdna/' . $dna->mito_sequence_number)}}>{{$dna->mito_sequence_number}}</a></div></td>
                        <td class="table-text">{{ $dna->mito_sequence_subgroup }}</td>
                        <td class="table-text">{{ $dna->mito_sequence_similar }}</td>
                        <td class="table-text">{{ $dna->mito_results_confidence }}</td>
                        <td class="table-text">{{ $dna->mito_request_date }}</td>
                        <td class="table-text">{{ $dna->mito_receive_date }}</td>
                        <td class="table-text">{{ $dna->created_by }}</td>
                        <td class="table-text">{{ $dna->created_at }}</td>
                        <td class="table-text">{{ $dna->updated_by }}</td>
                        <td class="table-text">{{ $dna->updated_at }}</td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
    </div>
@else
    @if (!$initialshow)
        <div class="card-body"><h4>@lang('messages.no_records_found_refine_search', ['model' => 'DNA'])</h4></div>
    @endif
@endif
