@if (isset($skeletalelements) && count($skeletalelements) > 0)
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mav-datatable-report">
                <thead>
                <th width="20%">@lang('labels.key')</th>
                <th>@lang('labels.bone')</th>
                <th>@lang('labels.side')</th>
                @foreach( $traumas as $trauma )
                    <th>{{ $trauma->name }}</th>
                @endforeach
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
                        <td class="table-text"><div>{{ $skeletalelement->skeletalbone->name }}</div></td>
                        <td class="table-text"><div>{{ $skeletalelement->side }}</div></td>
                        @foreach( $traumas as $trauma )
                            <td class="table-text"><div>{{$skeletalelement->traumasByZonesList($trauma->id)}}</div></td>
                        @endforeach
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