@extends('skeletalelements.associations.common')

@section('association-content')
    <div class="card-group" id="accordion">
        <div class="card">
            <div class="card-header" style="height: 35px;">
                <div class="float-left">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSEPathologys" class="">@lang('labels.pathologies')<span class="caret"></span></a>
                </div>
                <form action="{{ url('skeletalelements/'.$skeletalelement->id.'/pathologys/create') }}" method="GET">
                    <div class="float-right">
                        <button dusk="create-button" type="submit" id="create-pathology" class="btn btn-primary"><i class="fas fa-btn fa-file"></i>@lang('labels.create')</button>
                    </div>
                </form>
            </div>

            <div id="collapseSEPathologys" class="card-collapse card-body collapse">
                <div class="col-lg-12 form-group se-pathologys">
                    @if (count($skeletalelement->pathologys) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped se-pathologys">
                                <thead> <!-- Table Headings -->
                                <th>@lang('labels.pathology')</th><th>@lang('labels.zone')</th><th>@lang('labels.additional_information')</th><th>@lang('labels.action')</th>
                                </thead>
                                <tbody> <!-- Table Body -->
                                @foreach ($skeletalelement->pathologys as $current)
                                    <tr>
                                        <td class="table-text"><div><a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/pathologys/'.$current->pivot->id) }}">{{ $current->name }}</a></div></td>
                                        <td class="table-text"><div>{{ (App\Zone::all()->find($current->pivot->zone_id) != null) ? App\Zone::all()->find($current->pivot->zone_id)->display_name : "" }}</div></td>
                                        <td class="table-text"><div>{{ $current->pivot->additional_information }}</div></td>
                                        <td class="table-text"><div>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['skeletalelements.pathologys.destroy', $skeletalelement->id, $current->pivot->id],
                                                'id' => 'form-delete-pathologys-' . $current->pivot->id]) !!}
                                            <a href="" class="data-delete" data-form="pathologys-{{ $current->pivot->id }}"><i class="fas fa-trash"></i></a>
                                            {!! Form::close() !!}
                                        </div></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        @if (!$initialshow)
                            <div class="alert alert-info">
                                <h4>@lang('messages.no_relationship_for_model', ['relationship'=>'Pathologies', 'model'=>'Specimen'])</h4>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <style>
        .fa-trash { color: red; }
    </style>
    <script>
        $(document).ready(function($) {
            $('select#sb, select#side, select#completeness').select2();

            $('table.se-pathologys').DataTable({
                "paging": false, "searching" : false, "info" : false,
            });
            $('.data-delete').on('click', function (e) {
                if (!confirm('Are you sure you want to delete?')) return;
                e.preventDefault();
                $('#form-delete-' + $(this).data('form')).submit();
            });
            $('a[href="#collapseSEPathologys"]').click();
        });
    </script>
@endsection
