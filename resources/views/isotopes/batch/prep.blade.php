<div class="isotope-batch-container" id="tabs">
    <ul id="nav-isotope-batch" class="nav nav-pills nav-fill nav-justified">
        <li id="nav-cleaning" class="nav-item"><a class="nav-link" href="#cleaning" data-toggle="tab">@lang('labels.cleaning')</a></li>
        <li id="nav-demineralizing" class="nav-item"><a class="nav-link" href="#demineralizing" data-toggle="tab">@lang('labels.demineralizing')</a></li>
        <li id="nav-rha" class="nav-item"><a class="nav-link" href="#removehumicacid" data-toggle="tab">@lang('labels.removehumicacid')</a></li>
        <li id="nav-solubilizing" class="nav-item"><a class="nav-link" href="#solubilizing" data-toggle="tab">@lang('labels.solubilizing')</a></li>
        <li id="nav-freezedrying" class="nav-item"><a class="nav-link" href="#freezedrying" data-toggle="tab">@lang('labels.freezedrying')</a></li>
        <li id="nav-collagenyield" class="nav-item"><a class="nav-link" href="#collagenyield" data-toggle="tab">@lang('labels.collagen_yield')</a></li>
    </ul>

    <div class="tab-content">
        <div id="cleaning" class="tab-pane fade in">
            @include('isotopes.batch.prep.cleaning')
        </div>
        <div id="demineralizing" class="tab-pane fade in">
            @include('isotopes.batch.prep.demineralizing')
        </div>
        <div id="removehumicacid" class="tab-pane fade in">
            @include('isotopes.batch.prep.removehumicacid')
        </div>
        <div id="solubilizing" class="tab-pane fade in">
            @include('isotopes.batch.prep.solubilizing')
        </div>
        <div id="freezedrying" class="tab-pane fade in">
            @include('isotopes.batch.prep.freezedrying')
        </div>
        <div id="collagenyield" class="tab-pane fade in">
            @include('isotopes.batch.prep.collagenyield')
        </div>
    </div>

    @if($CRUD_Action != 'View')
        <div class="form-group" >
            <div class="col-md-6 col-md-offset-5">
                {!! Form::button('<i class="fas fa-btn fa-save"></i>Save', ['type' => 'submit', 'class' => 'btn btn-primary','dusk'=>'isotope-batch-save']) !!}
            </div>
        </div>
    @endif
</div>

@section('footer')
    @parent
    <script>
        $('#nav-demineralizing').addClass('disabled');
        $('#nav-rha').addClass('disabled');
        $('#nav-solubilizing').addClass('disabled');
        $('#nav-freezedrying').addClass('disabled');
        $('#nav-collagenyield').addClass('disabled');

        $('#nav-cleaning').addClass('active');
        $('#cleaning').addClass('active');

        if(($('#cleaning :checkbox:not(:checked)').length == 0) && ($("#cleaning_start_date").val()) && ($("#dry_samples_end_date").val())) {
                $('#nav-demineralizing').removeClass('disabled');

            $('.cleanbox').addClass('disabled');
            $('.clean').prop('readonly', true);
            $('#nav-cleaning').removeClass('active');
            $('#cleaning').removeClass('active');
            $('#nav-demineralizing').addClass('active');
            $('#demineralizing').addClass('active');
        }

        if(($('#demineralizing :checkbox:not(:checked)').length == 0) && ($("#demineralizing_treatment_start_date").val()) && ($("#demineralizing_treatment_end_date").val())) {
            $('#nav-rha').removeClass('disabled');

            $('.deminbox').addClass('disabled');
            $('.demin').prop('readonly', true);
            $('#nav-demineralizing').removeClass('active');
            $('#demineralizing').removeClass('active');
            $('#removehumicacid').addClass('active');
            $('#nav-rha').addClass('active');
        }

        if(($('#removehumicacid :checkbox:not(:checked)').length == 0) && ($("#rha_treatment_start_date").val()) && ($("#rha_treatment_end_date").val()) && ($("#rha_sample_rinse1_start_date").val())
        && ($("#rha_sample_rinse1_end_date").val()) && ($("#rha_sample_rinse2_start_date").val()) && ($("#rha_sample_rinse2_end_date").val()) && ($("#rha_sample_rinse3_start_date").val())
        && ($("#rha_sample_rinse3_end_date").val()) && ($("#rha_sample_rinse4_start_date").val()) && ($("#rha_sample_rinse4_end_date").val()) && ($("#rha_sample_rinse5_start_date").val())
        && ($("#rha_sample_rinse5_end_date").val())) {
            $('#nav-solubilizing').removeClass('disabled');

            $('.rhabox').addClass('disabled');
            $('.rha').prop('readonly', true);
            $('#nav-rha').removeClass('active');
            $('#removehumicacid').removeClass('active');
            $('#nav-solubilizing').addClass('active');
            $('#solubilizing').addClass('active');
        }

        if(($('#solubilizing :checkbox:not(:checked)').length == 0) && ($("#sc_clean_vials_and_lids_date").val()) && ($("#sc_freeze_vials_date").val()) && ($("#sc_num_acid_heat_treatment").val()) && ($("#sc_num_collagen_transfers").val())) {
            $('#nav-freezedrying').removeClass('disabled');

            $('.solubox').addClass('disabled');
            $('.solu').prop('readonly', true);
            $('#solubilizing').removeClass('active');
            $('#nav-solubilizing').removeClass('active');
            $('#nav-freezedrying').addClass('active');
            $('#freezedrying').addClass('active');
        }

        if(($('#freezedrying :checkbox:not(:checked)').length == 0) && ($("#fdc_samples_start_date").val()) && ($("#fdc_samples_end_date").val())) {
            $('#nav-collagenyield').removeClass('disabled');

            $('.fdbox').addClass('disabled');
            $('.fd').prop('readonly', true);
            $('#nav-freezedrying').removeClass('active');
            $('#freezedrying').removeClass('active');
            $('#nav-collagenyield').addClass('active');
            $('#collagenyield').addClass('active');
        }

        $(".disabled").click(function (e) {
            e.preventDefault();
            return false;
        });

    </script>
    <style>
        ul#nav-isotope-batch { background-color: lightgray; }
    </style>
@endsection

