<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('common.errors')
                    {{--@include('common.flash')--}}

                    @if (count($isotopes) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mav-datatable-list">
                                <thead> <!-- Table Headings -->
                                    <th>@lang('labels.project')</th>
                                    <th>@lang('labels.specimen')</th>
                                    <th>@lang('labels.sample_number')</th>
                                    <th>@lang('labels.weight_cleaned')</th>
                                    <th>@lang('labels.weight_vial_lid')</th>
                                    <th>@lang('labels.weight_sample_vial_lid')</th>
                                    <th>@lang('labels.weight_collagen')</th>
                                    <th>@lang('labels.collagen_yield')</th>
                                    <th class="hidecol">@lang('labels.created_by')</th>
                                    <th class="hidecol">@lang('labels.created_at')</th>
                                    <th class="hidecol">@lang('labels.updated_by')</th>
                                    <th class="hidecol">@lang('labels.updated_at')</th>
                                </thead>
                                <tbody> <!-- Table Body -->
                                @foreach ($isotopes as $key=>$isotope)
                                <tr>
                                    <td class="table-text"><div>{{ $isotope->project->name }}</div></td>
                                    <td class="table-text"><div>{{ $isotope->specimen->key }}</div></td>
                                    <td class="table-text"><div><a dusk="isotope-{{$isotope->sample_number}}" href="{{ url('isotopes/'. $isotope->se_id."/". $isotope->id) }}">{{ $isotope->sample_number }}</a></div></td>
                                    <td class="table-text"><div>{{ $isotope->weight_sample_cleaned }}</div></td>
                                    <td class="table-text"><div>{{ $isotope->weight_vial_lid }}</div></td>
                                    <td class="table-text"><div>{{ $isotope->weight_sample_vial_lid }}</div></td>
                                    <td class="table-text"><div>{{ $isotope->weight_collagen }}</div></td>
                                    <td class="table-text"><div>{{ $isotope->yield_collagen }}</div></td>
                                    <td class="table-text"><div>{{ $isotope->created_by }}</div></td>
                                    <td class="table-text"><div>@cora_converttime($isotope->created_at)</div></td>
                                    <td class="table-text"><div>{{ $isotope->updated_by }}</div></td>
                                    <td class="table-text"><div>@cora_converttime($isotope->updated_at)</div></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info"><h4>@lang('messages.no_records_found', ['model' => 'IsotopeBatch'])</h4></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section('footer')
    @parent
    @include ('common._footer', ['CRUD_Action' => 'List', 'pageType' => 'List', 'includeStyle' => true, 'includeScript' => true, 'initialshow' => false])
    <style>
        .table td { border: 0px !important; }
    </style>
    <script>
        $(document).ready(function() {
            var oTableApi = $('table.mav-datatable-list').dataTable().api();
            oTableApi.page.len( {{ Auth::user()->getProfileValue('lines_per_page') }} ).draw();
        });
    </script>
@endsection
