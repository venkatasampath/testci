<div class="card ">
    <div class="card-header" style="height: 35px;">
        <div class="float-left">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseAnomoly" class="">@lang('labels.anomaly')<span class="caret"></span></a>
        </div>
    </div>
    <div id="collapseAnomoly" class="card-collapse card-body collapse">
        <div class="col-md-10">
            <div class="form-group anomalys">
                <label class="col-md-3 control-label">@lang('labels.initial'): </label>
                <div class="col-md-7">
                    {!! Form::select('anomalylist[]', $list_anomaly, null, ['id' => 'anomalys', 'class' => 'form-control anomalys mav-select', 'multiple', 'disabled', 'style' => 'width: 80%; margin-top: 10px;']) !!}
                </div>
            </div>
            <div class="form-group anomalys">
                <label class="col-md-3 control-label">@lang('labels.review'): </label>
                <div class="col-md-7">
                    {!! Form::select('anomalylistreview[]', $list_anomaly, !empty($pathologyReview['anomaly']) ? $pathologyReview['anomaly'] : array(), ['id' => 'anomalys_review', 'class' => 'form-control anomalys mav-select', 'multiple', 'style' => 'width: 80%; margin-top: 10px;', 'disabled' => !$SaveButton]) !!}
                </div>
            </div>
        </div>
    </div>
</div>
<br/>