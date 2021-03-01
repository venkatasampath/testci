@if (isset($results) && (count($results) > 0))
    <div class="card-body">
        <table class="table table-bordered table-striped mav-datatable-report">
            <thead> <!-- Table Headings -->
            <th width="20%">@lang('labels.key')</th>
            <th>@lang('labels.consolidated_accession_number')</th>
            <th>@lang('labels.sample_number')</th>
            <th>@lang('labels.bone')</th>
            <th>@lang('labels.side')</th>
            </thead>
            <tbody> <!-- Table Body -->
            @foreach ($results as $result)
                @if(isset($result))
                    <tr>
                        @can('edit', $result)
                            @if ( $open_result_new_tab )
                                <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$result->id) }}" target="_blank">{{ $result->key }} </a></div></td>
                            @else
                                <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$result->id) }}">{{ $result->key }}</a></div></td>
                            @endif
                        @else
                            <td class="table-text"><div>{{ $result->key}}</div></td>
                        @endcan
                        <td class="table-text">
                            {{ $result->consolidated_an}}
                        </td>
                            @if(!($result->dnas)->isEmpty())
                        @can('edit', $result->dnas)
                            @foreach($result->dnas as $dna)
                            @if ( $open_result_new_tab )
                                <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$result->id.'/dnas/'.$dna->id) }}" target="_blank">{{ $dna->sample_number }}</a></div></td>
                            @else
                                <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$result->id.'/dnas/'.$dna->id) }}">{{ $dna->sample_number }}</a></div></td>
                            @endif
                                    @endforeach
                                @endcan
                        @else
                            <td class="table-text"><div></div></td>
                            @endif
                        <td class="table-text">
                            {{ $result->skeletalbone->name }}
                        </td>
                        <td class="table-text">
                            {{ $result->side }}
                        </td>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
    @endif

