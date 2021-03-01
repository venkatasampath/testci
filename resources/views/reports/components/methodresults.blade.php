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
            <th>@lang('labels.method')</th>
            <th>@lang('labels.method_feature')</th>
            <th>@lang('labels.score')</th>
            </thead>
            <tbody> <!-- Table Body -->
            @foreach ($results as $result)
                <tr>
                    <td class="table-text">{{ $result->accession_number }}</td>
                    <td class="table-text">{{ $result->provenance1 }}</td>
                    <td class="table-text">{{ $result->provenance2 }}</td>
                    <td class="table-text">{{ $result->designator }}</td>
                    <td class="table-text">{{ $result->bone }}</td>
                    <td class="table-text">{{ $result->side }}</td>
                    <td class="table-text">{{ $result->method }}</td>
                    <td class="table-text">{{ $result->feature }}</td>
                    <td class="table-text">{{ $result->score }}</td>
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
