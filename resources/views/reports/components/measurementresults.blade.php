@if (isset($results) && count($results) > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-striped mav-datatable-report">
            <thead> <!-- Table Headings -->
            <th>@lang('labels.accession')</th>
            <th>@lang('labels.provenance1')</th>
            <th>@lang('labels.provenance2')</th>
            <th>@lang('labels.designator')</th>
            <th>@lang('labels.element')</th>
            <th>@lang('labels.side')</th>
                @foreach($measurement_headers as $header) 
                <th>{{$header}}</th>
                @endforeach
                <!--
                <th>Measurement</th>
                <th>Value</th> -->
            </thead>
            <tbody> <!-- Table Body -->
            @foreach ($results as $result)
                <tr>
                    <td class="table-text">
                        {{ $result['accession_number'] }}
                    </td>
                    <td class="table-text">
                        {{ $result['provenance1'] }}
                    </td>
                    <td class="table-text">
                        {{ $result['provenance2'] }}
                    </td>
                    <td class="table-text">
                        {{ $result['designator'] }}
                    </td>
                    <td class="table-text">
                        {{ $result['bone'] }}
                    </td>
                    <td class="table-text">
                        {{ $result['side'] }}
                    </td>
                    @foreach($measurement_headers as $header) 
                     <td class='table-text'>{{ array_key_exists($header, $result) ? $result[$header] : '' }}</td>
                    @endforeach
                    {{--
                    <td class="table-text">
                        {{ $result->measurement }}
                    </td>
                    <td class="table-text">
                        {{ $result->value }}
                    </td>
                    --}}
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    @if (!$initialshow)
        <div class="card-body"><h4>@lang('messages.no_records_found_refine_search', ['model'=>trans('labels.specimen')])</h4></div>
    @endif
@endif

