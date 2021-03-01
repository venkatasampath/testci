@if (isset($skeletalelements) && count($skeletalelements) > 0)
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-striped mav-datatable-report">
            <thead>
            <tr>
                <th rowspan="2"><div>@lang('labels.measurement')</div></th>
                <th><div>@lang('labels.key')</div></th>
            </tr>
            <tr>
                @foreach( $skeletalelements as $skeletalelement )
                    @if ( $open_result_new_tab )
                        <th><a href="{{ url('/skeletalelements/'.$skeletalelement->id) }}" target="_blank">{{ $skeletalelement->key }}</a> - {{ $skeletalelement->skeletalbone->name }} - {{ $skeletalelement->side }}</th>
                    @else
                        <th><a href="{{ url('/skeletalelements/'.$skeletalelement->id) }}">{{ $skeletalelement->key }}</a> - {{ $skeletalelement->skeletalbone->name }} - {{ $skeletalelement->side }}</th>
                    @endif
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach( $measurements as $measurement )
                <tr>
                    <td class="table-text"><div>
                            <a class="help" data-toggle="tooltip" data-trigger="click" data-html="true">{{$measurement->name}}</a>
                        </div></td>
                    @foreach ($skeletalelements as $skeletalelement)
                        @if($skeletalelement->measurements()->where('measurement_id', $measurement->id)->get()->count() === 1)
                            <td class="table-text"><div>{{$skeletalelement->getMeasure($measurement->id)}}</div></td>
                        @else
                            <td class="table-text"><div></div></td>
                        @endif
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