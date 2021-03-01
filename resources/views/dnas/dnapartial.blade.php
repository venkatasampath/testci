<div class="dna-container">
<ul class="nav nav-pills nav-fill nav-justified">
    <li id="nav-dna" class="nav-item"><a class="nav-link active" href="#mito" data-toggle="tab">@lang('labels.mito')</a></li>
    <li id="nav-dna" class="nav-item"><a class="nav-link" href="#auto" data-toggle="tab">@lang('labels.auto')</a></li>
    <li id="nav-dna" class="nav-item"><a class="nav-link" href="#y" data-toggle="tab">@lang('labels.y')</a></li>
</ul>

<div class="tab-content">
    <div id="mito" class="tab-pane fade in active">
        <p>
            @include('dnas.mitopartial')
        </p>
    </div>
    <div id="auto" class="tab-pane fade in">
        <p>
            @include('dnas.austrpartial')
        </p>
    </div>
    <div id="y" class="tab-pane fade in">
        <p>
            @include('dnas.ystrpartial')
        </p>
    </div>
</div>
</div>