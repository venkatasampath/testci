@if (isset($skeletalelements) && count($skeletalelements) > 0)
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered table-striped mav-datatable-report">
            <thead>
            <th width="20%">@lang('labels.composite_key')</th>
            <th>@lang('labels.bone')</th>
            <th>@lang('labels.articulated_composite_key')</th>
            <th>@lang('labels.articulated_bone')</th>
            <th class="hidecol">@lang('labels.created_by')</th>
            <th class="hidecol">@lang('labels.created_at')</th>
            <th class="hidecol">@lang('labels.updated_by')</th>
            <th class="hidecol">@lang('labels.updated_at')</th>
            </thead>
            <tbody>
            @foreach ($skeletalelements as $skeletalelement)
                <tr>
                    @can('edit', $se)
                        @if ( $open_result_new_tab )
                            <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$se->id) }}" target="_blank">{{ $se->key }} </a></div></td>
                        @else
                            <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$se->id) }}">{{ $se->key }}</a></div></td>
                        @endif
                    @else
                        <td class="table-text"><div>{{ $se->key }}</div></td>
                    @endcan
                    <td class="table-text"><div>{{ $se->skeletalbone->name}}</div></td>
                    @can('edit', $skeletalelement)
                        <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$skeletalelement->id) }}">{{ $skeletalelement->key }}</a></div></td>
                    @else
                        <td class="table-text"><div>{{ $skeletalelement->key }}</div></td>
                    @endcan
                        <td class="table-text"><div>{{ $skeletalelement->skeletalbone->name }}</div></td>
                        <td class="table-text"><div>{{ $skeletalelement->created_by }}</div></td>
                        <td class="table-text"><div>{{ $skeletalelement->created_at }}</div></td>
                        <td class="table-text"><div>{{ $skeletalelement->updated_by }}</div></td>
                        <td class="table-text"><div>{{ $skeletalelement->updated_at }}</div></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    </div>
@endif
