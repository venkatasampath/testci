<div class="card-group" id="accordion">
    <div class="card ">
        <div class="card-header" style="height: 35px;">
            <div class="float-left">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseSEMethods" class="">@lang('labels.methods')<span class="caret"></span></a>
            </div>
            <div class="float-right">
                <a href="{{ url('/skeletalelements/'.$skeletalelement->id) }}"><i class="fas fa-btn fa-user-md"></i></a>
            </div>
        </div>

        <div id="collapseSEMethods" class="card-collapse card-body collapse">


            <methodtable :specimen_id="{{$skeletalelement->id}}"
                         :base_url="{{json_encode(url('/'))}}" types=" {{$methodType}}" csrf="{{csrf_token()}}"
            ></methodtable>

            {{--            <div class="col-lg-12 form-group se-methods">--}}
            {{--                @if (count($skeletalelement->methodsByType($methodType)) > 0)--}}
            {{--                    <div class="table-responsive">--}}
            {{--                        <table class="table table-bordered table-striped se-methods">--}}
            {{--                            <thead> <!-- Table Headings -->--}}
            {{--                            <th>@lang('labels.name')</th><th>@lang('labels.submethod')</th><th>@lang('labels.description')</th><th>@lang('labels.action')</th>--}}
            {{--                            </thead>--}}
            {{--                            <tbody> <!-- Table Body -->--}}
            {{--                            @foreach ($skeletalelement->methodsByType($methodType) as $se_method)--}}
            {{--                                <tr>--}}
            {{--                                    <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/methods/'.$se_method->id) }}">{{ $se_method->name }}</a></div></td>--}}
            {{--                                    <td class="table-text"><div>{{ $se_method->submethod }}</div></td>--}}
            {{--                                    <td class="table-text"><div>{{ $se_method->description }}</div></td>--}}
            {{--                                    <td class="table-text"><div>--}}
            {{--                                        {!! Form::open(['method' => 'DELETE', 'route' => ['skeletalelements.methods.destroy', $skeletalelement->id, $se_method->id],--}}
            {{--                                            'id' => 'form-delete-methods-' . $se_method->id]) !!}--}}
            {{--                                        <a href="" class="data-delete" data-form="methods-{{ $se_method->id }}"><i class="fas fa-trash"></i></a>--}}
            {{--                                        {!! Form::close() !!}--}}
            {{--                                    </div></td>--}}
            {{--                                </tr>--}}
            {{--                            @endforeach--}}
            {{--                            </tbody>--}}
            {{--                        </table>--}}
            {{--                    </div>--}}
            {{--                @else--}}
            {{--                    @if (!$initialshow)--}}
            {{--                        <div class="alert alert-info">--}}
            {{--                            <h4>@lang('messages.no_relationship_for_model', ['relationship'=> $methodType . ' Method(s)', 'model'=>'Specimen'])</h4>--}}
            {{--                        </div>--}}
            {{--                    @endif--}}
            {{--                @endif--}}
            {{--            </div>--}}
        </div>
    </div>
</div>
