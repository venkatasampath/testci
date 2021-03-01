{{--
@if (count($skeletalelements) > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-striped mav-datatable-report">
            <thead> <!-- Table Headings -->
            {{--<th>Accession</th><th>Bone</th><th>Sampled</th><th class="no-sort">Actions</th>--}}
            <th>@lang('labels.key')</th><th>@lang('labels.bone')</th><th>@lang('labels.side')</th><th>@lang('labels.dna_sampled')</th>
            </thead>
            <tbody> <!-- Table Body -->
            @foreach ($skeletalelements as $skeletalelement)
                <tr>
                    @if ( $open_result_new_tab )
                        <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$skeletalelement->id) }}" target="_blank">{{ $skeletalelement->key }} </a></div></td>
                    @else
                        <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$skeletalelement->id) }}">{{ $skeletalelement->key }}</a></div></td>
                    @endif
                    <td class="table-text"><div>{{ $skeletalelement->skeletalbone->name }}</div></td>
                    <td class="table-text"><div>{{ $skeletalelement->side }}</div></td>
                    @if ($skeletalelement->dna_sampled)<td class="table-text"><div>Yes</div></td>@else<td class="table-text"><div>No</div></td>@endif
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

--}}
