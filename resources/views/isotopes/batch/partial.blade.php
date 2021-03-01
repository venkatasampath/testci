{{  Form::hidden('status', $batchStatus) }}

<div class="col-lg-12 form-group isotope-batch">
    <div class="form-group required form-group{{ $errors->has('lab_id') ? ' has-error' : '' }}" >
        {!! Form::label('lab_id', trans('Lab').':', ['for' => 'lab_id', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {{ Form::select('lab_id', $list_lab, null, ['id' => 'lab_id', 'class' => 'form-control mav-select','dusk'=>'isotope-lab' ]) }}
            <span class="validity"></span>
            @if ($errors->has('lab_id'))
                <span class="help-block"><strong>{{ $errors->first('lab_id') }}</strong></span>
            @endif
        </div>
    </div>

    @if($CRUD_Action != 'Create')
    <div class="form-group form-group{{ $errors->has('status') ? ' has-error' : '' }}" >
        {!! Form::label('status', trans('Status').':', ['for' => 'status', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {{ Form::select('status', $list_status, null, ['id'=>'status','disabled','class'=>'form-control mav-select','dusk'=>'isotope-status' ]) }}
            <span class="validity"></span>
            @if ($errors->has('status'))
                <span class="help-block"><strong>{{ $errors->first('status') }}</strong></span>
            @endif
        </div>
    </div>
    @endif

    <div class="form-group{{ $errors->has('external_case_id') ? ' has-error' : '' }}" >
        {!! Form::label('external_case_id', 'External Case #:', ['for' => 'external_case_id', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            {!! Form::text('external_case_id', null, ['id' => 'external_case_id', 'placeholder' => trans('messages.placeholder_externalID'), 'class' => 'col-md-12 form-control','dusk'=>'isotope-external_case']) !!}
            <span class="validity"></span>
            @if ($errors->has('external_case_id'))
                <span class="help-block"><strong>{{ $errors->first('external_case_id') }}</strong></span>
            @endif
        </div>
    </div>

    <div class="form-group required form-group{{ $errors->has('batch_num') ? ' has-error' : '' }}" >
        {!! Form::label('batch_num', 'Isotope Batch Number:', ['for' => 'batch_num', 'class' => 'col-md-4 control-label']) !!}
        <div class="col-md-6">
            @if($CRUD_Action == 'Create')
                {!! Form::text('batch_num', null, ['id' => 'batch_num', 'placeholder' => trans('messages.placeholder_batchNumber'), 'class' => 'col-md-12 form-control', 'required' => 'required', 'dusk'=>'isotope-batch_number']) !!}
            @else
                {!! Form::text('batch_num', null, ['id' => 'batch_num', 'placeholder' => trans('messages.placeholder_batchNumber'), 'class' => 'col-md-12 form-control', 'readonly', 'required' => 'required', 'dusk'=>'isotope-batch_number']) !!}
            @endif
            <span class="validity"></span>
            @if ($errors->has('batch_num'))
                <span class="help-block"><strong>{{ $errors->first('batch_num') }}</strong></span>
            @endif
        </div>
    </div>

    @if($CRUD_Action != 'Create')
        <div class="form-group">
            {!! Form::label('notes', trans('Notes').':', ['for'=>'notes', 'class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::textarea('notes',null,['class'=>'form-control', 'rows' => 5, 'cols' => 10]) !!}
            </div>
        </div>

        @include('isotopes.batch.prep')
        @include('isotopes.batch.lists')
    @else
        <div class="form-group" >
            <div class="col-md-6 col-md-offset-5">
                {!! Form::button('<i class="fas fa-btn fa-save"></i>'.trans('labels.save'), ['type'=>'submit', 'class'=>'btn btn-primary','dusk'=>'isotope-batch-save']) !!}
            </div>
        </div>
    @endif
</div>

@section('footer')
    @parent
@endsection