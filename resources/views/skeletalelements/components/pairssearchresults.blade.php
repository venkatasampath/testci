@if (isset($skeletalelements) && count($skeletalelements) > 0)
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mav-datatable-search">
                <thead> <!-- Table Headings -->
                <th width="20%">@lang('labels.key')</th>
                <th>@lang('labels.bone')</th>
                <th>@lang('labels.side')</th>
                <th>@lang('labels.bone_group')</th>
                <th>@lang('labels.compare_method')</th>
                <th>@lang('labels.measurements_used')</th>
                <th>@lang('labels.num_measurements')</th>
                <th>@lang('labels.sample_size')</th>
                <th>@lang('labels.pvalue')</th>
                <th>@lang('labels.mean')</th>
                <th>@lang('labels.sd')</th>
                <th>@lang('labels.elimination_reason')</th>
                <th>@lang('labels.elimination_date')</th>
                <th class="hidecol">@lang('labels.created_by')</th>
                <th>@lang('labels.created_at')</th>
                <th class="hidecol">@lang('labels.updated_by')</th>
                <th class="hidecol">@lang('labels.updated_at')</th>
                </thead>
                <tbody> <!-- Table Body -->
                @foreach ($skeletalelements as $object)
                    <tr>
                        @can('edit', $object)
                            @if ( $open_result_new_tab )
                                <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$object->id) }}" target="_blank">{{ $object->key }} </a></div></td>
                            @else
                                <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$object->id) }}">{{ $object->key }}</a></div></td>
                            @endif
                        @else
                            <td class="table-text"><div>{{ $object->key }}</div></td>
                        @endcan
                        <td class="table-text"><div>{{ $object->skeletalbone->name }}</div></td>
                        <td class="table-text"><div>{{ $object->side }}</div></td>
                        <td class ="table-text"><div><a href={{ url('reports/bonegroup/' . $object->bone_group_id)}}>{{$object->bone_group}}</a></div></td>
                        @can('edit', $object)
                            @if( $open_result_new_tab)
                                <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/pairs/'.$object->id.'/view') }}" target="_blank">{{ $object->pivot->compare_method }}</a></div></td>
                            @else
                                <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/pairs/'.$object->id.'/view') }}">{{ $object->pivot->compare_method }}</a></div></td>
                            @endif
                        @else
                            <td class="table-text"><div>{{ $object->pivot->compare_method }}</div></td>
                        @endcan
                        <td class="table-text"><div>{{ $object->pivot->measurements_used }}</div></td>
                        <td class="table-text"><div>{{ $object->pivot->num_measurements }}</div></td>
                        <td class="table-text"><div>{{ $object->pivot->sample_size }}</div></td>
                        <td class="table-text"><div>{{ $object->pivot->pvalue }}</div></td>
                        <td class="table-text"><div>{{ $object->pivot->mean }}</div></td>
                        <td class="table-text"><div>{{ $object->pivot->sd }}</div></td>
                        <td class="table-text"><div>{!! Form::select('elimination_reason', $elimination_reasons, $object->pivot->elimination_reason, ['id'=> $skeletalelement->id . '-' . $object->id, 'class'=>'col-md-12 form-control', 'placeholder' => trans('messages.placeholder_elimination_reason'), 'dusk' =>'se-pair-elimination-reason']) !!}</div></td>
                        <td class="table-text"><div>{{ $object->pivot->elimination_date }}</div></td>
                        <td class="table-text"><div>{{ $object->created_by }}</div></td>
                        <td class="table-text"><div>{{ $object->created_at }}</div></td>
                        <td class="table-text"><div>{{ $object->updated_by }}</div></td>
                        <td class="table-text"><div>{{ $object->updated_at }}</div></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif