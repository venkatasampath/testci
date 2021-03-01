@if (isset($skeletalelements) && count($skeletalelements) > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-striped mav-datatable-search">
            <thead> <!-- Table Headings -->
                <th width="20%">@lang('labels.key')</th>
                <th>@lang('labels.bone')</th>
                <th>@lang('labels.side')</th>
                <th>@lang('labels.individual_number')</th>
                <th>@lang('labels.sample_number')</th>
                <th>@lang('labels.external_case_id')</th>
                <th>@lang('labels.results_status')</th>
                <th>@lang('labels.mito_sequence_number')</th>
                <th>@lang('labels.mito_sequence_subgroup')</th>
                <th class="hidecol">@lang('labels.mito_sequence_similar')</th>
                <th>@lang('labels.receive_date')</th>
                <th class="hidecol">@lang('labels.created_by')</th>
                <th class="hidecol">@lang('labels.created_at')</th>
                <th class="hidecol">@lang('labels.updated_by')</th>
                <th class="hidecol">@lang('labels.updated_at')</th>
            </thead>
            <tbody> <!-- Table Body -->
            @foreach($skeletalelements as $skeletalelement)
            @foreach ($skeletalelement->dnas as $dna)
                @if(($dna) === null)
                @else
                    <tr>
                        @can('edit', $dna)
                            @if ( $open_result_new_tab )
                                <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$dna->skeletalelement->id) }}" target="_blank">{{ $dna->skeletalelement->key }}</a></div></td>
                            @else
                                <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$dna->skeletalelement->id) }}">{{ $dna->skeletalelement->key }}</a></div></td>
                            @endif
                        @else
                            <td class="table-text"><div>{{ $dna->skeletalelement->key}}</div></td>
                        @endcan

                        <td class="table-text"><div>{{ $dna->skeletalelement->skeletalbone->name }}</div></td>
                        <td class="table-text"><div>{{ $dna->skeletalelement->side }}</div></td>

                        @can('edit', $dna)
                            @if ( $open_result_new_tab )
                                <td class ="table-text"><div><a href="{{ url('reports/individualnumber/' . urlencode($dna->skeletalelement->individual_number))}}" target="_blank">{{$dna->skeletalelement->individual_number}}</a></div></td>
                            @else
                                <td class ="table-text"><div><a href="{{ url('reports/individualnumber/' . urlencode($dna->skeletalelement->individual_number))}}">{{$dna->skeletalelement->individual_number}}</a></div></td>
                            @endif
                        @else
                            <td class ="table-text"><div>{{$dna->skeletalelement->individual_number}}</div></td>
                        @endcan

                        @can('edit', $dna)
                            @if ( $open_result_new_tab )
                                <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$dna->skeletalelement->id.'/dnas/'.$dna->id) }}" target="_blank">{{ $dna->sample_number }}</a></div></td>
                            @else
                                <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$dna->skeletalelement->id.'/dnas/'.$dna->id) }}">{{ $dna->sample_number }}</a></div></td>
                            @endif
                        @else
                            <td class="table-text"><div>{{ $dna->sample_number }}</div></td>
                        @endcan

                        <td class="table-text"><div>{{ $dna->external_case_id }}</div></td>
                        <td class="table-text"><div>{{ $dna->mito_results_confidence }}</div></td>
                        <td class="table-text"><div><a href="{{ url('reports/mtdna/'. $dna->mito_sequence_number) }}">{{ $dna->mito_sequence_number }}</a></div></td>
                        <td class="table-text"><div>{{ $dna->mito_sequence_subgroup }}</div></td>
                        <td class="table-text"><div>{{ $dna->mito_sequence_similar }}</div></td>
                        <td class="table-text"><div>{{ $dna->mito_receive_date }}</div></td>
                        <td class="table-text"><div>{{ $dna->created_by }}</div></td>
                        <td class="table-text"><div>{{ $dna->created_at }}</div></td>
                        <td class="table-text"><div>{{ $dna->updated_by }}</div></td>
                        <td class="table-text"><div>{{ $dna->updated_at }}</div></td>
                    </tr>
                @endif
            @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
@else
    @if (!$initialshow)
        <div class="alert alert-info">
            <h4>@lang('messages.no_records_found_refine_search', ['model' => 'DNA'])</h4>
            <h4>@lang('messages.search_default_help')</h4>
        </div>
    @endif
@endif
