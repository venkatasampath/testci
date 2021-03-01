{!! Form::model($skeletalelement, ['class' => 'form-horizontal']) !!}
<div class="card-group" id="accordion">
    <div class="card ">
        <div class="card-header" style="height: 35px;">
            <div class="float-left">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseSE" class="">Element Highlights<span class="caret"></span></a>
            </div>
            @can('read', $skeletalelement)
            <div class="float-right">
                <a href="{{ url('/skeletalelements/'.$skeletalelement->id) }}"><i class="fas fa-btn fa-user-md"></i></a>
            </div>
            @endcan
        </div>
        <div id="collapseSE" class="card-collapse card-body collapse">
            <div class="col-lg-12">
                <div class="form-group" >
                    <label class="col-md-4 control-label">Bone</label>
                    <div class="col-md-6">
                        {{ Form::select('sb_id', $list_sb, null, ['id' => 'sb', 'class' => 'form-control', 'disabled','dusk'=>'se-elementhighlights-bone']) }}
                    </div>
                </div>

                {{--<div class="form-group">--}}
                    {{--{!! Form::label('external_id', 'External Id:', ['class' => 'col-md-4 control-label']) !!}--}}
                    {{--<div class="col-md-6">{!! Form::text('external_id', null, ['class' => 'col-md-6 form-control', 'disabled']) !!}</div>--}}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--{!! Form::label('individual_number', 'Individual Number:', ['class' => 'col-md-4 control-label']) !!}--}}
                    {{--<div class="col-md-6">{!! Form::text('individual_number', null, ['class' => 'col-md-6 form-control', 'disabled']) !!}</div>--}}
                {{--</div>--}}

                <div class="form-group" >
                    <label class="col-md-4 control-label">Side</label>
                    <div class="col-md-6">
                        {{ Form::select('side', $list_side, null, ['id' => 'side', 'class' => 'form-control', 'disabled','dusk'=>'se-elementhighlights-side']) }}
                    </div>
                </div>
                <div class="form-group" >
                    <label class="col-md-4 control-label">Completeness</label>
                    <div class="col-md-6">
                        {{ Form::select('completeness', $list_completeness, null, ['id' => 'completeness', 'class' => 'form-control', 'disabled','dusk'=>'se-elementhighlights-completeness']) }}
                    </div>
                </div>

                <div class="form-group" dusk="se-elementhighlights-measured">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>{{ Form::hidden('measured', false) }}{{ Form::checkbox('measured', true, old('measured'), ['disabled']) }}Measured</label>
                        </div>
                    </div>
                </div>
                <div class="form-group" dusk="se-elementhighlights-dna_sampled">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>{{ Form::hidden('dna_sampled', false) }}{{ Form::checkbox('dna_sampled', true, old('dna_sampled') , ['disabled']) }}DNA Sampled</label>
                        </div>
                    </div>
                </div>
                <div class="form-group" dusk="se-elementhighlights-inventoried">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>{{ Form::hidden('inventoried', false) }}{{ Form::checkbox('inventoried', true, old('inventoried') , ['disabled']) }}Inventory Completed</label>
                        </div>
                    </div>
                </div>
                <div class="form-group" dusk="se-elementhighlights-reviwed">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                            <label>{{ Form::hidden('reviewed', false) }}{{ Form::checkbox('reviewed', true, old('reviewed') , ['disabled']) }}Reviewed</label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
