{{--<div class="col-lg-12 dna border" style="padding-top: 10px; margin-bottom: 10px; padding-left: 0px; padding-right: 0px;">--}}

{{--<div class="form-group required form-group{{ $errors->has('mito_method') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('mito_method', trans('labels.method').':', ['for' => 'mito_method', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            @if(isset($dna->mito_method))--}}
{{--                {{ Form::select('mito_method', $list_mito_method, null, ['id' => 'mito_method', 'class' => 'form-control mav-select','placeholder' => trans('labels.select_method'), 'dusk'=>'dna-mito_method' ]) }}--}}
{{--            @else--}}
{{--                {{ Form::select('mito_method', $list_mito_method, $theUser->getProfileValue('default_mito_method'), ['id' => 'mito_method', 'class' => 'form-control mav-select','dusk'=>'dna-mito_method' ]) }}--}}
{{--            @endif--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('mito_method'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('mito_method') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group">--}}
{{--        {!! Form::label('mito_request_date', trans('labels.request_date').':', ['for' => 'mito_request_date', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::date('mito_request_date', null, ['id' => 'mito_request_date', 'class' => 'col-md-12 form-control','dusk'=>'dna-mito_request_date']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group">--}}
{{--        {!! Form::label('mito_receive_date', trans('labels.receive_date').':', ['for' => 'mito_receive_date', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::date('mito_receive_date', null, ['id' => 'mito_receive_date', 'class' => 'col-md-12 form-control','dusk'=>'dna-mito_receive_date']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('mito_results_confidence') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('mito_results_confidence', trans('labels.results_status').':', ['for' => 'mito_results_confidence', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {{ Form::select('mito_results_confidence', $list_confidence, null, ['id' => 'mito_results_confidence', 'class' => 'form-control mav-select','placeholder' => trans('labels.select_attribute', ['attribute'=>'Results Confidence']),'dusk'=>'dna-mito_results_confidence' ]) }}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('mito_results_confidence'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('mito_results_confidence') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('mito_sequence_number') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('mito_sequence_number', trans('labels.mito_sequence_number').':', ['for' => 'mito_sequence_number', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::text('mito_sequence_number', null, ['id' => 'mito_sequence_number', 'placeholder' => trans('messages.placeholder_mitoseqNumber'), 'class' => 'col-md-12 form-control','dusk'=>'dna-mito_sequence_number']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('mito_sequence_number'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('mito_sequence_number') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('mito_sequence_subgroup') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('mito_sequence_subgroup', trans('labels.mito_sequence_subgroup').':', ['for' => 'mito_sequence_subgroup', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::text('mito_sequence_subgroup', null, ['id' => 'mito_sequence_subgroup', 'placeholder' => trans('messages.placeholder_mitosubNumber'), 'class' => 'col-md-12 form-control','dusk'=>'dna-mito_sequence_subgroup']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('mito_sequence_subgroup'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('mito_sequence_subgroup') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('mito_sequence_similar') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('mito_sequence_similar', trans('labels.mito_sequence_similar').':', ['for' => 'mito_sequence_similar', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::text('mito_sequence_similar', null, ['id' => 'mito_sequence_similar', 'placeholder' => trans('messages.placeholder_mitoseqSimiliar'), 'class' => 'col-md-12 form-control','dusk'=>'dna-mito_sequence_similar']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('mito_sequence_similar'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('mito_sequence_similar') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--<div>--}}
{{--    <div class="form-group{{ $errors->has('mito_match_count') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('mito_match_count', trans('labels.mito_match_count').' / '. trans('labels.population_frequency').':', ['for' => 'mito_match_count', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::text('mito_match_count', null, ['id' => 'mito_match_count', 'placeholder' => trans('messages.placeholder_mitomatch'), 'class' => 'col-md-5 form-control','dusk'=>'dna-mito_match_count']) !!}--}}
{{--            --}}{{--<span class="validity"></span>--}}
{{--            @if ($errors->has('mito_match_count'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('mito_match_count') }}</strong></span>--}}
{{--            @endif--}}
{{--        {!! Form::label('slash', ' / ', ['for' => '/', 'class' => 'col-md-2 control-label', 'style' => 'text-align: center;']) !!}--}}
{{--            {!! Form::text('mito_total_count', null, ['id' => 'mito_total_count', 'placeholder' => trans('messages.placeholder_mitototal'), 'class' => 'col-md-5 form-control','dusk'=>'dna-mito_total_count']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('mito_total_count'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('mito_total_count') }}</strong></span>--}}
{{--            @endif--}}
{{--    </div>--}}
{{--    </div>--}}
{{--</div>--}}

{{--    <div class="form-group{{ $errors->has('mito_base_pairs') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('mito_base_pairs', trans('labels.base_pairs').':', ['for' => 'mito_base_pairs', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::text('mito_base_pairs', null, ['id' => 'mito_base_pairs', 'placeholder' => trans('messages.placeholder_base_pairs'), 'class' => 'col-md-12 form-control','dusk'=>'dna-mito_base_pairs']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('mito_base_pairs'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('mito_base_pairs') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('mito_confirmed_regions') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('mito_confirmed_regions', trans('labels.confirmed_regions').':', ['for' => 'mito_confirmed_regions', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::text('mito_confirmed_regions', null, ['id' => 'mito_confirmed_regions', 'placeholder' => trans('messages.placeholder_confirmed_regions'), 'class' => 'col-md-12 form-control','dusk'=>'dna-mito_confirmed_regions']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('mito_confirmed_regions'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('mito_confirmed_regions') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="form-group{{ $errors->has('mito_polymorphisms') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('mito_polymorphisms', trans('labels.mito_polymorphisms').':', ['for' => 'mito_polymorphisms', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::text('mito_polymorphisms', null, ['id' => 'mito_polymorphisms', 'placeholder' => trans('messages.placeholder_mito_polymorphisms'), 'class' => 'col-md-12 form-control','dusk'=>'dna-mito_polymorphisms']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('mito_polymorphisms'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('mito_polymorphisms') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    @if($theUser->role_id == 6)--}}
{{--    <div class="form-group{{ $errors->has('mito_fasta_sequence') ? ' has-error' : '' }}">--}}
{{--        {!! Form::label('mito_fasta_sequence', trans('labels.mito_fasta_sequence').':', ['for' => 'mito_fasta_sequence', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::textarea('mito_fasta_sequence', null, ['id' => 'mito_fasta_sequence', 'placeholder' => trans('messages.placeholder_mito_fasta_sequence'), 'class' => 'col-md-12 form-control','dusk'=>'dna-mito_fasta_sequence']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--            @if ($errors->has('mito_fasta_sequence'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('mito_fasta_sequence') }}</strong></span>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    @endif--}}

{{--    <div class="form-group{{ $errors->has('mito_haplogroup_id') ? ' has-error' : '' }}" >--}}
{{--        {!! Form::label('mito_haplogroup_id', trans('Mito Haplogroup').':', ['for' => 'mito_haplogroup_id', 'class' => 'col-md-4 control-label']) !!}--}}
{{--            <div class="col-md-6">--}}
{{--            {{ Form::select('mito_haplogroup_id', $list_mito_haplogroup, null, ['id' => 'mito_haplogroup_id', 'class' => 'form-control mav-select', 'placeholder' => 'Select Haplogroup','dusk'=>'dna-mito_haplogroup' ]) }}--}}
{{--                <span class="validity"></span>--}}
{{--            @if ($errors->has('mito_haplogroup_id'))--}}
{{--                <span class="help-block"><strong>{{ $errors->first('mito_haplogroup_id') }}</strong></span>--}}
{{--            @endif--}}
{{--            </div>--}}
{{--    </div>--}}


{{--    <div class="form-group">--}}
{{--        {!! Form::label('mito_mcc_date', trans('labels.mcc_date').':', ['for' => 'mito_mcc_date', 'class' => 'col-md-4 control-label']) !!}--}}
{{--        <div class="col-md-6">--}}
{{--            {!! Form::date('mito_mcc_date', null, ['id' => 'mito_mcc_date', 'class' => 'col-md-12 form-control','dusk'=>'dna-mito_mcc_date']) !!}--}}
{{--            <span class="validity"></span>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--</div>--}}

{{--       Mito Form --}}
{{--<v-tab-item>--}}
{{--    <v-card flat>--}}
{{--        <v-card-text>--}}
{{--            <v-form lazy-validation>--}}
{{--                <v-row>--}}
{{--                    <v-col cols="12" md="3">--}}
{{--                        <method :options="{{json_encode($list_mito_method,true)}}"></method>--}}
{{--                    </v-col>--}}

{{--                    <v-col cols="12" md="3">--}}
{{--                        <request-date></request-date>--}}
{{--                    </v-col>--}}

{{--                    <v-col cols="12" md="3">--}}
{{--                        <receive-date></receive-date>--}}
{{--                    </v-col>--}}

{{--                    <v-col cols="12" md="3">--}}
{{--                        <results-status :options="{{json_encode($list_confidence,true)}}"></results-status>--}}
{{--                    </v-col>--}}
{{--                </v-row>--}}

{{--                <v-row>--}}
{{--                    <v-col cols="12" md="3">--}}
{{--                        <mito-seqnum></mito-seqnum>--}}
{{--                    </v-col>--}}

{{--                    <v-col cols="12" md="3">--}}
{{--                        <mito-seqsubgroup></mito-seqsubgroup>--}}
{{--                    </v-col>--}}

{{--                    <v-col cols="12" md="3">--}}
{{--                        <mito-seqsimilar></mito-seqsimilar>--}}
{{--                    </v-col>--}}

{{--                    <v-col cols="12" md="3">--}}
{{--                        <count-frequency></count-frequency>--}}
{{--                    </v-col>--}}

{{--                </v-row>--}}

{{--                <v-row>--}}
{{--                    <v-col cols="12" md="3">--}}
{{--                        <mito-basepairs></mito-basepairs>--}}
{{--                    </v-col>--}}

{{--                    <v-col cols="12" md="3">--}}
{{--                        <mito-regions></mito-regions>--}}
{{--                    </v-col>--}}

{{--                    <v-col cols="12" md="3">--}}
{{--                        <mito-poly></mito-poly>--}}
{{--                    </v-col>--}}

{{--                    <v-col cols="12" md="3">--}}
{{--                        <mito-haplogroup :options="{{json_encode($list_mito_haplogroup,true)}}"></mito-haplogroup>--}}
{{--                    </v-col>--}}
{{--                </v-row>--}}


{{--                <v-row>--}}
{{--                    <v-col cols="12" md="3">--}}
{{--                        <mcc-date></mcc-date>--}}
{{--                    </v-col>--}}
{{--                </v-row>--}}

{{--            </v-form>--}}
{{--        </v-card-text>--}}
{{--    </v-card>--}}
{{--</v-tab-item>--}}