<div class="card-footer main-footer" style="padding-top: 5px; padding-bottom: 5px;">
    <div class="float-left dpaa-logo skin-header" style="width: 20%">
        <div class="skin-logo float-left">
            <a href="http://www.dpaa.mil" class="logo float-right" target="_blank"><img src="{{ URL::to('/') }}/dpaa-logo-512.png" style="height: 48px;"/></a>
        </div>
        <div class="skin-title float-left">
            <a href="http://www.dpaa.mil/" title="Defense POW/MIA Accounting Agency">
                <div class="hidden-xs">
                    <p class="title-text withsub" style="margin: 0 0 2px; color: white">@lang('messages.dpaa')</p>
                    <p class="subtitle-text" style="margin: 0 0 2px; color: #3399cc">Fulfilling Our Nation's Promise</p>
                </div>
                <div class="visible-xs title-text">@lang('messages.dpaa')</div>
            </a>
        </div>
    </div>
    <div class="float-right uno-logo hidden-xs" style="width: 15%">
        <a href="http://www.unomaha.edu" class="logo float-right" target="_blank"><img src="{{ URL::to('/') }}/uno-logo-long-darkbg.png" style="height: 48px;"/></a>
    </div>
    <div class="float-right uno-logo visible-xs" style="width: 15%">
        <a href="http://www.unomaha.edu" class="logo float-right" target="_blank"><img src="{{ URL::to('/') }}/uno-logo-color.png" style="height: 48px;"/></a>
    </div>
    <div style="width: 65%; margin:0.5rem auto">
        <h6>@lang('messages.uno_dpaa_collaboration')</h6>
    </div>
</div>

<style>
    .skin-header-background {
        background: url("{{ URL::to('/') }}/dpaa-logo-skin-bg.png") no-repeat left top !important;
    }
    .skin-logo { float: left; padding: 6px 0 6px 0; flex-shrink: 0; }
    .skin-title { float: left; padding-top: 32px; padding-left: 5px;
        font-size: x-small; font-variant: small-caps;
        display: flex; flex-wrap: nowrap; line-height: 0.8;
    }
    .main-footer { position: relative; min-height: 75px; z-index: 1030; background-color: #222d32}
</style>
<script>
    $(document).ready(function($) {
        // add your script here
    });
</script>
