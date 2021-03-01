<style>
    #sidebar a, a:hover, a:focus {
        color: inherit;
        text-decoration: none;
        transition: all 0.3s;
    }

    /*#sidebar {*/
        /*min-width: 230px;*/
        /*max-width: 230px;*/
        /*min-height: 100vh;*/
        /*background-color: #222d32;*/
        /*color: #fff;*/
        /*transition: all 0.3s;*/
        /*border-right: 1px solid #d2d6de;*/
    /*}*/

    .sidebarDark {
        min-width: 230px;
        max-width: 230px;
        min-height: 100vh;
        background-color: #222d32;
        color: #fff;
        transition: all 0.3s;
        border-right: 1px solid #d2d6de;

    }

    .sidebarLight {
        min-width: 230px;
        max-width: 230px;
        min-height: 100vh;
        background-color: #f9fafc;
        color: #222d32;
        transition: all 0.3s;
        border-right: 1px solid #d2d6de;
    }



    #sidebar.active {
        /*margin-left: -250px;*/
        min-width: 50px;
        max-width: 50px;
        text-align: center;
    }

    #sidebar.active .sidebar-header h3 {
        display: none;
    }

    #sidebar.active .sidebar-header strong {
        display: block;
    }

    #sidebar ul li a {
        text-align: left;
    }

    /*
    On minimize of sidebar reduce font size and add padding
     */
    #sidebar.active ul li a {
        padding: 15px 5px;
        text-align: center;
        font-size: 0.85em;

    }

    #sidebar.active ul li a i {
        margin-right:  0;
        display: block;
        font-size: 1.4em;
        margin-bottom: 5px;

    }

    #sidebar.active ul li a span {
        display: none;
    }
    #sidebar.active ul li ul li a span {
        display: none;
    }
    /*
    On minimize of sidebar provide padding all around
     */
    #sidebar.active ul ul a {
        padding: 10px !important;
    }

    #sidebar.active a[aria-expanded="false"]::before, #sidebar.active a[aria-expanded="true"]::before {
        top: auto;
        bottom: 5px;
        right: 50%;
        -webkit-transform: translateX(50%);
        -ms-transform: translateX(50%);
        transform: translateX(50%);
    }

    #sidebar a[data-toggle="collapse"] {
        position: relative;
    }

    /*TODO: Check the position of fa-angle-left*/
    #sidebar.active .fa-angle-left {
        position: absolute;
        float: none;
        padding-top: 5px;
        right: 30px;
        display: none;
    }

    /*@media (max-width: 768px) {*/
        /*#sidebar {*/
            /*margin-left: -250px;*/
        /*}*/
        /*#sidebar .active {*/
            /*margin-left: 0;*/
        /*}*/
    /*}*/

    #sidebar .sidebar-header {
        padding: 20px;
        background-color: #222d32;
    }

    #sidebar .sidebar-header strong {
        display: none;
        font-size: 1.8em;
    }

    #sidebar ul.components {
        padding: 20px 0;
        border-bottom: 1px solid #47748b;
    }

    #sidebar ul p {
        color: #fff;
        padding: 10px;
    }

    #sidebar ul li a {
        padding: 10px;
        font-size: 1.1em;
        display: block;
    }

    .sidebarDark ul li a:hover {
        background: #fff !important;
        color: #222d32 !important;
    }
    .sidebarLight ul li a:hover {
        background: #222d32 !important;
        color: #fff !important;
    }

    #sidebar ul li a i {
        margin-right: 10px;
    }

    #sidebar ul ul a {
        font-size: 0.9em !important;
        padding-left: 30px !important;
        /*background-color: #222d32;*/
    }

    .fa-angle-left {
        -moz-transition: all .2s linear;
        -webkit-transition: all .2s linear;
        transition: all .2s linear;
    }

    .fa-angle-left.down {
        -moz-transform: rotate(-90deg);
        -webkit-transform: rotate(-90deg);
        transform: rotate(-90deg)
    }

    #sidebar.active .fa-angle-left {
        display: none;
    }

    /*For Popover menu on Hover*/
    /*#sidebar.active ul li:hover {*/
        /*display: block;*/
        /*position: relative;*/
        /*background-color: #222d32;*/
        /*min-width: 200px;*/
        /*box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.4);*/
        /*z-index: 1;*/
        /*!*border-left: 3px solid #00acee;*!*/
        /*border-left: 3px solid #222d32;*/
    /*}*/

    /*#sidebar.active ul li:hover a:hover {*/
         /*border-left: 3px solid #00acee;*/
     /*}*/

    /*#sidebar ul li:hover {*/
        /*border-left: 3px solid #00acee;*/
    /*}*/

    /*#sidebar ul li:hover a:hover {*/
        /*border-left: 3px solid #00acee;*/
    /*}*/

    /*#sidebar.active ul li:hover .list-unstyled {*/
        /*display: block;*/
    /*}*/

    /*#sidebar.active ul li:hover a span {*/
        /*display: block;*/
        /*padding-top: 5px;*/
    /*}*/

    /*For smaller screens*/
    @media(max-width: 480px) {
        #sidebar.active {
            min-width: 50px;
            max-width: 50px;
            text-align: center;
            /*margin-left: -80px !important;*/
        }

        #sidebar .sidebar-header strong {
            display: none;
        }
        #sidebar.active .sidebar-header h3 {
            display: none;
        }
        #sidebar.active .sidebar-header strong {
            display: block;
        }

        /* Downsize the navigation links font size */
        #sidebar.active ul li a {
            padding: 20px 10px;
            font-size: 0.85em;
        }

        #sidebar.active ul li a i {
            margin-right:  0;
            display: block;
            font-size: 1.8em;
            margin-bottom: 5px;
        }

        /* Adjust the dropdown links padding*/
        #sidebar.active ul ul a {
            padding: 10px !important;
        }

        /* Changing the arrow position to bottom center position,
          translateX(50%) works with right: 50%
          to accurately  center the arrow */
        #sidebar.active a[aria-expanded="false"]::before, #sidebar.active a[aria-expanded="true"]::before {
            top: auto;
            bottom: 5px;
            right: 50%;
            transform: translateX(50%);
        }
    }
</style>

<nav id="sidebar" class="active sidebarDark">

    <ul class="list-unstyled components">
        @if (Auth::check())
            @if (Auth::user()->projects()->count() != 0)  {{-- User Has a Project --}}
                {{--SkeletalElements Menu--}}
                @can('browse', \App\SkeletalElement::class)
                    <li title="@lang('labels.dashboard')"><a href="{{url('/dashboard')}}" dusk="dashboard"><i class="fas fa-fw fa-tachometer-alt"></i><span>@lang('labels.dashboard')</span></a></li>
                    <li class="active"title="@lang('labels.skeletal_elements')">
                        <a dusk="se-menu" href="#specimenSubMenu" data-toggle="collapse" class="rotate" aria-expanded="false">
                            <i class="fas fa-fw fa-skull"></i><span>@lang('labels.specimens')</span><i class="fas fa-angle-left float-sm-right"></i>
                        </a>
                        <ul class="collapse list-unstyled treeViewMenu" id="specimenSubMenu">
                            @can('add', \App\SkeletalElement::class)
                            <li title="@lang('labels.create_skeletalElement')"><a dusk="se-new" href="{{url('/skeletalelements/create')}}"><i class="fas fa-fw fa-plus-circle"></i><span>@lang('labels.new')</span></a></li>
                            <li title="@lang('labels.create_skeletalElementGroup')"><a dusk="se-new-group" href="{{url('/skeletalelements/createbygroup')}}"><i class="fas fa-fw fa-plus-square"></i><span>@lang('labels.new_bone_group')</span></a></li>
                            @endcan
                            <li title="@lang('labels.reports_dashboard')"><a dusk="se-reports_dashboard" href="{{url('/reports/dashboard')}}"><i class="fas fa-fw fa-file-alt"></i><span>@lang('labels.reports_dashboard')</span></a></li>
                            <li title="@lang('labels.advanced_report')"><a dusk="se-advance_search" href="{{url('/reports/advanced')}}"><i class="fas fa-fw fa-search-plus"></i><span>@lang('labels.advanced_report')</span></a></li>
                            @if ((Auth::user()->isOrgAdmin() || Auth::user()->isAdmin()) && (Auth::user()->id == 1 || Auth::user()->id == 104))
                                <li title="@lang('labels.visualizations_dashboard')"><a dusk="se-visualization_dashboard" href="{{url('/visualizations/dashboard')}}"><i class="fas fa-fw fa-chart-bar"></i><span>@lang('labels.visualizations_dashboard')</span></a></li>
                            @endif
                        </ul>
                    </li>
                @endcan

                {{--DNA Module Menu--}}
                @can('browse', \App\Dna::class)
                    <li title="@lang('labels.dna')">
                        <a dusk="dna-menu" href="#dnaSubmenu" data-toggle="collapse" class="rotate" aria-expanded="false">
                            <i class="fas fa-fw fa-dna"></i><span>@lang('labels.dna')</span><i class="fas fa-angle-left float-sm-right"></i>
                        </a>
                        <ul class="collapse list-unstyled treeViewMenu" id="dnaSubmenu">
                            <li title="@lang('labels.model_report', ['model'=>'mtDNA'])"><a dusk="dna-mtDNA" href="{{url('/reports/mtdna')}}"><i class="fas fa-fw fa-notes-medical"></i><span>@lang('labels.model_report', ['model'=>'mtDNA'])</span></a></li>
                        </ul>
                    </li>
                @endcan

                {{--Isotope Module Menu--}}
                @can('browse', \App\IsotopeBatch::class)
                    <li title="@lang('labels.isotope')">
                        <a dusk="isotope-menu" href="#isotopeSubmenu" data-toggle="collapse" class="rotate" aria-expanded="false">
                            <i class="fas fa-fw fa-radiation-alt"></i><span>@lang('labels.isotope')</span><i class="fas fa-angle-left float-sm-right"></i>
                        </a>
                        <ul class="collapse list-unstyled treeViewMenu" id="isotopeSubmenu">
                            <li title="@lang('labels.isotope_batches')"><a dusk="list-isotope-batch" href="{{url('/isotopebatch')}}"><i class="fas fa-fw fa-radiation"></i><span>@lang('labels.isotope_batches')</span></a></li>
                            @can('add', \App\IsotopeBatch::class)
                            <li title="@lang('labels.new_model', ['model'=>'Isotope Batch'])"><a dusk="create-isotope-batch" href="{{url('/isotopebatch/create')}}"><i class="fas fa-fw fa-plus-circle"></i><span>@lang('labels.new_model', ['model'=>'Isotope Batch'])</span></a></li>
                            @endcan
{{--                            <li title="@lang('labels.model_report', ['model'=>'Isotope'])"><a dusk="report-isotope" href="{{url('/reports/isotope')}}"><i class="fas fa-fw fa-radiation"></i><span>@lang('labels.model_report', ['model'=>'Isotope'])</span></a></li>--}}
                        </ul>
                    </li>
                @endcan

                {{--Exports & FileManager Menu--}}
                {{-- Commented out by Sachin for more testing and feature addition with new Laravel Excel package --}}
                @if (Auth::user()->isAdmin() && (Auth::user()->id == 1 || Auth::user()->id == 104 || Auth::user()->id == 24))
                <li>
                    <a title="@lang('labels.file_export_import')" dusk="report-menu" href="#fileSubmenu" data-toggle="collapse" class="rotate" aria-expanded="false">
                        <i class="fas fa-fw fa-copy"></i><span>@lang('labels.file_export_import')</span><i class="fas fa-angle-left float-sm-right"></i>
                    </a>
                    <ul class="collapse list-unstyled treeViewMenu" id="fileSubmenu">
                        <li title="@lang('labels.file_export')"><a dusk="file-export" href="{{url('/exportOptions')}}"><i class="fas fa-fw fa-file-export"></i><span>@lang('labels.file_export')</span></a></li>
                        <li title="@lang('labels.file_import')"><a dusk="file-import" href="{{url('/importFile')}}"><i class="fas fa-fw fa-file-import"></i><span>@lang('labels.file_import')</span></a></li>
                        <li title="@lang('labels.file_manager')"><a dusk="file-manager" href="{{url('/exportFileManager')}}"><i class="fas fa-fw fa-copy"></i><span>@lang('labels.file_manager')</span></a></li>
                    </ul>
                </li>
                @endif

                {{--Admin Menu for OrgAdmin--}}
                @if (Auth::user()->isOrgAdmin() || Auth::user()->isAdmin())
                    <li title="@lang('labels.administration')">
                        <a dusk="administrator-menu" href="#adminSubMenu" data-toggle="collapse" class="rotate" aria-expanded="false">
                            <i class="fas fa-fw fa-users-cog"></i><span>@lang('labels.administration')</span><i class="fas fa-angle-left float-sm-right"></i>
                        </a>
                        <ul class="collapse list-unstyled treeViewMenu" id="adminSubMenu">
                            <li title="@lang('labels.model_management', ['model'=>'User'])"><a dusk="administrator-user_management" href="{{url('/users')}}"><i class="fas fa-fw fa-users"></i><span>@lang('labels.model_management', ['model'=>'User'])</span></a></li>
                            <li title="@lang('labels.model_management', ['model'=>'Project'])"><a dusk="administrator-project_management" href="{{url('/projects')}}"><i class="fas fa-fw fa-sitemap"></i><span>@lang('labels.model_management', ['model'=>'Project'])</span></a></li>
                            <li title="@lang('labels.model_management', ['model'=>'Accession'])"><a dusk="administrator-accession_management" href="{{url('/accessions')}}"><i class="fas fa-fw fa-universal-access"></i><span>@lang('labels.model_management', ['model'=>'Accession'])</span></a></li>
                            <li title="@lang('labels.model_management', ['model'=>'Instrument'])"><a dusk="administrator-instrument_management" href="{{url('/instruments')}}"><i class="fas fa-fw fa-syringe"></i><span>@lang('labels.model_management', ['model'=>'Instrument'])</span></a></li>
                            <li title="@lang('labels.model_management', ['model'=>'Haplogroup'])"><a dusk="administrator-haplogroup_management" href="{{url('/haplogroups')}}"><i class="fab fa-fw fa-pagelines"></i><span>@lang('labels.model_management', ['model'=>'Haplogroup'])</span></a></li>
                        </ul>
                    </li>
                @elseif(Auth::user()->getCurrentProject()->manager_id == Auth::user()->id)
                    <li title="@lang('labels.administration')">
                        <a dusk="administrator-menu" href="#adminSubMenu" data-toggle="collapse" class="rotate" aria-expanded="false">
                            <i class="fas fa-fw fa-users-cog"></i><span>@lang('labels.administration')</span><i class="fas fa-angle-left float-sm-right"></i>
                        </a>
                        <ul class="collapse list-unstyled" id="adminSubMenu">
                            <li title="@lang('labels.model_management', ['model'=>'Project'])"><a dusk="administrator-project_management" href="{{url('/projects/'.Auth::user()->getCurrentProject()->id)}}"><i class="fas fa-fw fa-sitemap"></i><span>@lang('labels.model_management', ['model'=>'Project'])</span></a></li>
                            <li title="@lang('labels.model_management', ['model'=>'Accession'])"><a dusk="administrator-accession_management" href="{{url('/accessions')}}"><i class="fas fa-fw fa-universal-access"></i><span>@lang('labels.model_management', ['model'=>'Accession'])</span></a></li>
                        </ul>
                    </li>
                @endif
            @else {{-- User Does not have a Project --}}
                <ul class="nav-item">
                    <li title="@lang('labels.home')"><a dusk="home-menu" href="{{ url('/home') }}"><i class="fas fa-fw fa-home"></i><span>@lang('labels.home')</span></a></li>
                </ul>
            @endif
        @endif
    </ul>
</nav>

<script>
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
            $('.navbar-brand').toggleClass('navToggle');
        });

        $('#left-sidebar-expand').on('click', function () {
            $('#sidebar').toggleClass('active');
            $('.navbar-brand').toggleClass('navToggle');
        });

        $('.rotate').click(function() {
            $(this).children('.fa-angle-left').toggleClass('down');
        });

        let currentThemeClass = localStorage.getItem("activeThemeClass");
        let leftSideBarClass = $('#sidebar');
        if(localStorage.getItem("activeThemeClass")) {
            leftSideBarClass.removeClass('sidebarDark');
            leftSideBarClass.addClass(currentThemeClass);
        }
    });
</script>
