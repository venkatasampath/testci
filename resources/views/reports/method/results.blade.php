@if (isset($skeletalelements) && count($skeletalelements) > 0)
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mav-datatable-report">
                <thead>
                <th width="20%">@lang('labels.key')</th>
                <th>@lang('labels.bone')</th>
                <th>@lang('labels.side')</th>
                <th>@lang('labels.method')</th>
                <th>@lang('labels.method_feature')</th>
                <th>@lang('labels.score')</th>
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
                        <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/methods/'.$skeletalelement->method_id) }}">{{ $list_method[$skeletalelement->method_id] }}</a></div>
                        <td class="table-text"><div>{{ $list_method_feature[$skeletalelement->method_feature_id] }}</div></td>
                        <td class="table-text"><div>{{ $skeletalelement->score }}</div></td>
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