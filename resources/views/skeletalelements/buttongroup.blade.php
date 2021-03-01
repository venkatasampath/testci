<!-- Single button -->
@can('edit', $skeletalelement)
    <div class="btn-group float-left" style="padding-right: 5px">
        <button dusk="se-details-menu" type="button" class="btn btn-default btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @lang('labels.details')
        </button>
            <ul class="dropdown-menu">
                @if($skeletalelement->skeletalbone->hasMethods())
                <li class="dropdown-submenu">
                    <a dusk="se-biological-profile-menu" tabindex="-1" href="#"><i class="fas fa-btn fa-fw fa-venus-mars"></i>@lang('labels.biological_profile')</a>
                    <ul class="dropdown-menu">
                        @if($skeletalelement->skeletalbone->hasMethodsByType('Age'))
                        <li><a dusk="se-age-menu" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/age') }}"><i class="fas fa-btn fa-fw fa-hashtag"></i>@lang('labels.age')</a></li>
                        @endif
                        @if($skeletalelement->skeletalbone->hasMethodsByType('Sex'))
                        <li><a dusk="se-sex-menu" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/sex') }}"><i class="fas fa-btn fa-fw fa-venus-mars"></i>@lang('labels.sex')</a></li>
                        @endif
                        @if($skeletalelement->skeletalbone->hasMethodsByType('Stature'))
                        <li><a dusk="se-stature-menu" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/stature') }}"><i class="fas fa-btn fa-fw fa-align-right fa-rotate-90"></i>@lang('labels.stature')</a></li>
                        @endif
                        @if($skeletalelement->skeletalbone->hasMethodsByType('Ancestry'))
                        <li><a dusk="se-ancestry-menu" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/ancestry') }}"><i class="fas fa-btn fa-fw fa-font"></i>@lang('labels.ancestry')</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                @if(($skeletalelement->dnas)->isEmpty())
                    <li><a dusk="se-dna-menu-1" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/dnas/create') }}"><i class="fas fa-btn fa-fw fa-medkit"></i>@lang('labels.dna_profile')</a></li>
                @elseif(count($skeletalelement->dnas) == 1)
                    <li><a dusk="se-dna-menu-2" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/dnas/'.$skeletalelement->dnas->first()->id)}}"><i class="fas fa-btn fa-fw fa-medkit"></i>@lang('labels.dna_profile')</a></li>
                @else
                    <li><a dusk="se-dna-menu-3" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/dnas') }}"><i class="fas fa-btn fa-fw fa-medkit"></i>@lang('labels.dna_profile')</a></li>
                @endif
                @if ($theProject->uses_isotope_analysis)
                    @if(($skeletalelement->isotopes)->isEmpty())
                        <li><a dusk="se-isotope-menu-1" href="{{ url('/isotopes/'.$skeletalelement->id.'/create') }}"><i class="fas fa-btn fa-fw fa-radiation-alt"></i>@lang('labels.isotope_analysis')</a></li>
                    @elseif(count($skeletalelement->isotopes) == 1)
                        <li><a dusk="se-isotope-menu-2" href="{{ url('/isotopes/'.$skeletalelement->id.'/'.$skeletalelement->isotopes->first()->id)}}"><i class="fas fa-btn fa-fw fa-radiation-alt"></i>@lang('labels.isotope_analysis')</a></li>
                    @else
                        <li><a dusk="se-isotope-menu-3" href="{{ url('/isotopes/'.$skeletalelement->id) }}"><i class="fas fa-btn fa-fw fa-radiation-alt"></i>@lang('labels.isotope_analysis')</a></li>
                    @endif
                @endif
                <li role="separator" class="divider"></li>
                <li><a dusk="se-taphonomys-menu" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/taphonomys') }}"><i class="fas fa-btn fa-fw fa-text-width"></i>@lang('labels.taphonomy')</a></li>
                @if($skeletalelement->skeletalbone->zones)
                <li><a dusk="se-zones-menu" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/zones/view') }}"><i class="fas fa-btn fa-fw fa-object-group"></i>@lang('labels.zonal_classification')</a></li>
                @endif
                @if($skeletalelement->skeletalbone->measurements)
                <li><a dusk="se-measurements-menu" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/measurements') }}"><i class="fas fa-btn fa-fw fa-balance-scale"></i>@lang('labels.measurements')</a></li>
                @endif
                    @if($skeletalelement->skeletalbone->articulated || $skeletalelement->skeletalbone->paired || $skeletalelement->skeletalbone->refit || $skeletalelement->skeletalbone->morphology)
                <li role="separator" class="divider"></li>
                <li class="dropdown-submenu">
                    <a dusk="se-associations-menu" tabindex="-1" href="#"><i class="fas fa-btn fa-fw fa-link"></i>@lang('labels.associations')</a>
                    <ul class="dropdown-menu">
                        @if($skeletalelement->skeletalbone->articulated)
                        <li><a dusk="se-articulations-menu" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/articulations') }}"><i class="fas fa-btn fa-fw fa-link"></i>@lang('labels.articulations')</a></li>
                        @endif
                        @if($skeletalelement->skeletalbone->paired)
                        <li><a dusk="se-pairs-menu" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/pairs') }}"><i class="fas fa-btn fa-fw fa-exchange-alt"></i>@lang('labels.pair_matching')</a></li>
                        @endif
                        <li><a dusk="se-refits-menu" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/refits') }}"><i class="fas fa-btn fa-fw fa-puzzle-piece"></i>@lang('labels.refits')</a></li>
                        @if($skeletalelement->skeletalbone->morphology)
                            <li><a dusk="se-morphology-menu"
                                   href="{{ url('/skeletalelements/'.$skeletalelement->id.'/morphologys') }}"><i
                                            class="fas fa-btn fa-fw fa-shapes"></i>@lang('labels.morphologies')</a></li>
                        @endif
                    </ul>
                </li>
                @endif
                <li role="separator" class="divider"></li>
                <li class="dropdown-submenu">
                    <a dusk="se-pathology-menu" tabindex="-1" href="#"><i class="fas fa-btn fa-fw fa-flask"></i>@lang('labels.pathology')</a>
                    <ul class="dropdown-menu">
                        <li><a dusk="se-traumas-menu" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/traumas') }}"><i class="fas fa-btn fa-fw fa-fire"></i>@lang('labels.trauma')</a></li>
                        <li><a dusk="se-pathologys-menu" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/pathologys') }}"><i class="fas fa-btn fa-fw fa-flask"></i>@lang('labels.pathology')</a></li>
                        @if($skeletalelement->skeletalbone->hasAnomalys())
                        <li><a dusk="se-anomalys-menu" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/anomalys') }}"><i class="fas fa-btn fa-fw fa-bolt"></i>@lang('labels.anomaly')</a></li>
                        @endif
                    </ul>
                </li>
                {{--@if (Auth::user()->id != $skeletalelement->user_id || Auth::user()->isAdmin()) --}}
                    <li role="separator" class="divider"></li>
                    <li><a dusk="se-review-menu" href="{{ url('/skeletalelements/'.$skeletalelement->id.'/review') }}"><i class="fas fa-btn fa-fw fa-eye"></i>@lang('labels.review')</a></li>
                {{--@endif --}}
                {{--<li role="separator" class="divider"></li>--}}
                {{--<li><a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/comments') }}"><i class="fas fa-btn fa-fw fa-comments-o"></i>Comments</a></li>--}}
                {{--<li><a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/tags') }}"><i class="fas fa-btn fa-fw fa-tags"></i>Tags</a></li>--}}
                {{--<li role="separator" class="divider"></li>--}}
                {{--<li><a href="{{ url('/skeletalelements/'.$skeletalelement->id.'/review') }}"><i class="fas fa-btn fa-fw fa-eye"></i>Review</a></li>--}}
            </ul>
    </div>
@endcan
