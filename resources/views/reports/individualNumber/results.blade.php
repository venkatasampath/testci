@if (isset($skeletalelements) && count($skeletalelements) > 0)
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mav-datatable-report">
                <thead>
                <th width="20%">@lang('labels.key')</th>
                <th>@lang('labels.individual_number')</th>
                <th>@lang('labels.bone')</th>
                <th>@lang('labels.side')</th>
                <th>@lang('labels.dna_sample_number')</th>
                <th>@lang('labels.dna_sequence_number')</th>
                <th>@lang('labels.traumas')</th>
                <th>@lang('labels.pathologies')</th>
                <th>@lang('labels.anomalies')</th>
                </thead>
                <tbody>
                @foreach ($skeletalelements as $skeletalelement)
                    <tr>
                        @can('edit', $skeletalelement)
                            @if ( $open_result_new_tab )
                                <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$skeletalelement->id) }}" target="_blank">{{ $skeletalelement->key }} </a></div></td>
                            @else
                                <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$skeletalelement->id) }}">{{ $skeletalelement->key }}</a></div></td>
                            @endif
                        @else
                            <td class="table-text"><div>{{ $skeletalelement->key }}</div></td>
                        @endcan
                            <td class="table-text"><div>{{ $skeletalelement->individual_number }}</div></td>
                            <td class="table-text"><div>{{ $skeletalelement->skeletalbone->name }}</div></td>
                        <td class="table-text"><div>{{ $skeletalelement->side }}</div></td>
                        <td class="table-text">
                            <div>
                            @foreach($skeletalelement->dnas as $dna)
                            {{ $dna->sample_number }}
                            <br>
                            @endforeach
                            </div>
                        </td>
                        <td class="table-text">
                            <div>
                                @foreach($skeletalelement->dnas as $dna)
                                    {{ $dna->mito_sequence_number }} @if($dna->mito_sequence_subgroup != null) - {{ $dna->mito_sequence_subgroup }}@endif
                                @endforeach
                            </div>
                        </td>
                        <td class="table-text"><div>{{ $skeletalelement->uniquetraumaslist }}</div></td>
                        <td class="table-text"><div>{{ $skeletalelement->uniquepathologyslist }}</div></td>
                        <td class="table-text"><div>{{ $skeletalelement->uniqueanomalyslist }}</div></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@else
    @if (!$initialshow)
        <div class="card-body"><h4>@lang('messages.no_records_found_refine_search', ['model'=>trans('labels.skeletalelement')])</h4></div>
    @endif
@endif