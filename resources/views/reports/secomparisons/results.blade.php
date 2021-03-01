@if (isset($skeletalelements) && count($skeletalelements) > 0)
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mav-datatable-report">
                <thead>
                <tr>
                    <th rowspan="2"><div>@lang('labels.attributes')</div></th>
                    <th><div>@lang('labels.key')</div></th>
                </tr>
                <tr>
                    @foreach( $skeletalelements as $skeletalelement )
                        @if ( $open_result_new_tab )
                            <th><a href="{{ url('/skeletalelements/'.$skeletalelement->id) }}" target="_blank">{{ $skeletalelement->key }}</a></th>
                        @else
                            <th><a href="{{ url('/skeletalelements/'.$skeletalelement->id) }}">{{ $skeletalelement->key }}</a></th>
                        @endif
                    @endforeach
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="table-text"><div>
                                @lang('labels.individual_number')
                        </div></td>
                        @foreach($skeletalelements as $skeletalelement)
                            <td class="table-text"><div>
                                    <a href={{ url('reports/individualnumber/' . urlencode($skeletalelement->individual_number))}}>{{$skeletalelement->individual_number}}</a>
                            </div></td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="table-text"><div>
                            @lang('labels.mito_sequence_number')
                        </div></td>
                        @foreach($skeletalelements as $skeletalelement)
                            <td class="table-text"><div>
                                    @foreach ($skeletalelement->dnas as $dna)
                                        <a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/dnas/'.$dna->id) }}" target="_blank">{{ $dna->sample_number }}</a><br>
                                    @endforeach
                            </div></td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="table-text"><div>
                            @lang('labels.taphonomy')
                        </div></td>
                        @foreach($skeletalelements as $skeletalelement)
                            <td class="table-text"><div>
                                    @foreach($skeletalelement->taphonomys as $taphonomy)
                                        {{$taphonomy->name}}
                                    @endforeach
                                </div></td>
                        @endforeach
                    </tr>
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
                    <tr>
                        <td class="table-text"><div>
                                @lang('labels.zones')
                            </div></td>
                        @foreach($skeletalelements as $skeletalelement)
                            <td class="table-text"><div>
                                    {{$skeletalelement->ZoneList}}
                                </div></td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="table-text"><div>
                                @lang('labels.articulations')
                            </div></td>
                        @foreach($skeletalelements as $skeletalelement)
                            <td class="table-text"><div>
                                @foreach($skeletalelement->articulations as $articulation)
                                    {{$articulation->key}}
                                @endforeach
                                </div></td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="table-text"><div>
                                @lang('labels.pair_matches')
                            </div></td>
                        @foreach($skeletalelements as $skeletalelement)
                            <td class="table-text"><div>
                                @foreach($skeletalelement->allpairs as $pair)
                                    {{$pair->key}}
                                    <br>
                                @endforeach
                                </div></td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="table-text"><div>
                                @lang('labels.refits')
                            </div></td>
                        @foreach($skeletalelements as $skeletalelement)
                            <td class="table-text"><div>
                                  @foreach($skeletalelement->allrefits as $refit)
                                      {{$refit->key}}
                                  @endforeach
                            </div></td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="table-text"><div>
                                @lang('labels.pathology')
                            </div></td>
                        @foreach($skeletalelements as $skeletalelement)
                            <td class="table-text"><div>
                                {{$skeletalelement->uniquepathologyslist}}
                            </div></td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="table-text"><div>
                                @lang('labels.trauma')
                            </div></td>
                        @foreach($skeletalelements as $skeletalelement)
                            <td class="table-text"><div>
                                {{$skeletalelement->uniquetraumaslist}}
                            </div></td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="table-text"><div>
                                @lang('labels.anomaly')
                            </div></td>
                        @foreach($skeletalelements as $skeletalelement)
                            <td class="table-text"><div>
                                {{$skeletalelement->uniqueanomalyslist}}
                            </div></td>
                        @endforeach
                    </tr>
                    <tr>
                        <td class="table-text"><div>
                                @lang('labels.remains_status')
                            </div></td>
                        @foreach($skeletalelements as $skeletalelement)
                            <td class="table-text"><div>
                                    {{$skeletalelement->remains_status}}
                                </div></td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@else
    @if (!$initialshow)
        <div class="card-body"><h4>@lang('messages.no_records_found_refine_search', ['model'=>trans('labels.skeletalelement')])</h4></div>
    @endif
@endif

@section('footer')
    @parent
    @include ('common._footer', ['pageType' => 'Report', 'includeStyle' => true, 'includeScript' => true])


    <script type="text/javascript">

        var element = document.getElementsByTagName('tbody')[0];

        var column, row, rows = element.rows;

        for (var i=0, attributes = rows.length; i < attributes; i++) {
            row = rows[i];
            column = row.cells;
            baseCell = column[1];
            var insideDiv2 = column[2].getElementsByTagName('div')[0];

            if (column.length === 3) {
                if (baseCell.innerHTML != column[2].innerHTML && insideDiv2.outerText != "") {
                    insideDiv2.setAttribute("class", "alert alert-warning");
                }
            }
            if (column.length === 4) {
                var insideDiv = baseCell.getElementsByTagName('div')[0];
                var insideDiv3 = column[3].getElementsByTagName('div')[0];
                if (baseCell.innerHTML != column[2].innerHTML && insideDiv2.outerText != "") {
                    insideDiv2.setAttribute("class", "alert alert-warning");
                }
                if (baseCell.innerHTML != column[3].innerHTML && insideDiv3.outerText != "") {
                    insideDiv3.setAttribute("class", "alert alert-warning");
                }
                if (column[2].outerText != "" && column[1].innerHTML != column[2].innerHTML && column[2].innerHTML === column[3].innerHTML) {
                    if (true) {
                        insideDiv.setAttribute("class", "alert alert-danger");
                    }
                }
            }
            if (column.length === 5) {
                var insideDiv = baseCell.getElementsByTagName('div')[0];
                var insideDiv3 = column[3].getElementsByTagName('div')[0];
                var insideDiv4 = column[4].getElementsByTagName('div')[0];
                if (baseCell.innerHTML != column[2].innerHTML && insideDiv2.outerText != "") {
                    insideDiv2.setAttribute("class", "alert alert-warning");
                }
                if (baseCell.innerHTML != column[3].innerHTML && insideDiv3.outerText != "") {
                    insideDiv3.setAttribute("class", "alert alert-warning");
                }
                if (baseCell.innerHTML != column[4].innerHTML && insideDiv4.outerText != "") {
                    insideDiv4.setAttribute("class", "alert alert-warning");
                }
                if (column[2].outerText != "" && column[1].innerHTML != column[2].innerHTML && column[2].innerHTML === column[3].innerHTML && column[3].innerHTML === column[4].innerHTML) {
                    if (true) {
                        insideDiv.setAttribute("class", "alert alert-danger");
                    }
                }
            }
        }

    </script>
@endsection