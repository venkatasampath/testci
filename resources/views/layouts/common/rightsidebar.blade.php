<style>
    .control-sidebar-bg {
        position: fixed;
        z-index: 1000;
        bottom: 0;
    }
    .control-sidebar-bg,
    .control-sidebar {
        top: 0;
        right: -230px;
        display: none;
        width: 300px;
        -webkit-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
        position: sticky;
    }
    .control-sidebar {
        z-index: 1010;
        min-height: 100vh;
    }
    @media (max-width: 768px) {
        .control-sidebar {
            display: none;
            padding-top: 100px;
        }
    }
    .control-sidebar > .tab-content {
        padding: 0 10px;
        width: inherit;
    }
    .control-sidebar.control-sidebar-open,
    .control-sidebar.control-sidebar-open + .control-sidebar-bg {
        right: 0;
        display: block;
        -webkit-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
        /*opacity: 1;*/
    }
    .control-sidebar-open .control-sidebar-bg,
    .control-sidebar-open .control-sidebar {
        right: 0;
    }
    @media (min-width: 768px) {
        .control-sidebar-open .content-wrapper,
        .control-sidebar-open .right-side,
        .control-sidebar-open .main-footer {
            margin-right: 230px;
        }
    }
    .fixed .control-sidebar {
        position: fixed;
        height: 100%;
        overflow-y: auto;
        padding-bottom: 50px;
    }
    .nav-tabs.control-sidebar-tabs > li:first-of-type > a,
    .nav-tabs.control-sidebar-tabs > li:first-of-type > a:hover,
    .nav-tabs.control-sidebar-tabs > li:first-of-type > a:focus {
        border-left-width: 0;
    }
    .nav-tabs.control-sidebar-tabs > li > a {
        border-radius: 0;
    }
    .nav-tabs.control-sidebar-tabs > li > a,
    .nav-tabs.control-sidebar-tabs > li > a:hover {
        border-top: none;
        border-right: none;
        border-left: 1px solid transparent;
        border-bottom: 1px solid transparent;
    }
    .nav-tabs.control-sidebar-tabs > li > a .icon {
        font-size: 16px;
    }
    .nav-tabs.control-sidebar-tabs > li.active.show > a,
    .nav-tabs.control-sidebar-tabs > li.active.show > a:hover,
    .nav-tabs.control-sidebar-tabs > li.active.show > a:focus,
    .nav-tabs.control-sidebar-tabs > li.active.show > a:active {
        border-top: none;
        border-right: none;
        border-bottom: none;
    }
    @media (max-width: 768px) {
        .nav-tabs.control-sidebar-tabs {
            display: table;
        }
        .nav-tabs.control-sidebar-tabs > li {
            display: table-cell;
        }
    }
    .control-sidebar-heading {
        font-weight: 400;
        font-size: 18px;
        margin-bottom: 10px;
    }
    .control-sidebar-subheading {
        display: block;
        font-weight: 400;
        font-size: 14px;
        line-height: normal;
    }
    .control-sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0 -15px;
    }
    .control-sidebar-menu > li > a {
        display: block;
        padding: 10px 15px;
    }
    .control-sidebar-menu > li > a:before,
    .control-sidebar-menu > li > a:after {
        content: " ";
        display: table;
    }
    .control-sidebar-menu > li > a:after {
        clear: both;
    }
    .control-sidebar-menu > li > a > .control-sidebar-subheading {
        margin-top: 0;
    }
    .control-sidebar-menu .menu-icon {
        float: left;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        text-align: center;
        line-height: 35px;
    }
    .control-sidebar-menu .menu-info {
        margin-left: 45px;
        margin-top: 3px;
    }
    .control-sidebar-menu .menu-info > .control-sidebar-subheading {
        margin: 0;
    }
    .control-sidebar-menu .menu-info > p {
        margin: 0;
        font-size: 11px;
    }
    .control-sidebar-menu .progress {
        margin: 0;
    }
    .control-sidebar-dark {
        color: #b8c7ce;
    }
    .control-sidebar-dark,
    .control-sidebar-dark + .control-sidebar-bg {
        background: #222d32;
    }
    .control-sidebar-dark .nav-tabs.control-sidebar-tabs {
        border-bottom: #1c2529;
    }
    .control-sidebar-dark .nav-tabs.control-sidebar-tabs > li > a {
        background: #181f23;
        color: #b8c7ce;
    }
    .control-sidebar-dark .nav-tabs.control-sidebar-tabs > li > a,
    .control-sidebar-dark .nav-tabs.control-sidebar-tabs > li > a:hover,
    .control-sidebar-dark .nav-tabs.control-sidebar-tabs > li > a:focus {
        border-left-color: #141a1d;
        border-bottom-color: #141a1d;
    }
    .control-sidebar-dark .nav-tabs.control-sidebar-tabs > li > a:hover,
    .control-sidebar-dark .nav-tabs.control-sidebar-tabs > li > a:focus,
    .control-sidebar-dark .nav-tabs.control-sidebar-tabs > li > a:active {
        background: #fff;
        color: #222d32;
    }
    .control-sidebar-dark .nav-tabs.control-sidebar-tabs > li.active.show > a,
    .control-sidebar-dark .nav-tabs.control-sidebar-tabs > li.active.show > a:hover,
    .control-sidebar-dark .nav-tabs.control-sidebar-tabs > li.active.show > a:focus,
    .control-sidebar-dark .nav-tabs.control-sidebar-tabs > li.active.show > a:active {
        background: #fff;
        color: #222d32;
    }
    .control-sidebar-dark .control-sidebar-heading,
    .control-sidebar-dark .control-sidebar-subheading {
        color: #fff;
    }
    .control-sidebar-dark .control-sidebar-menu > li > a:hover {
        background: #1e282c;
    }
    .control-sidebar-dark .control-sidebar-menu > li > a .menu-info > p {
        color: #b8c7ce;
    }
    .control-sidebar-light {
        color: #5e5e5e;
    }
    .control-sidebar-light,
    .control-sidebar-light + .control-sidebar-bg {
        background: #f9fafc;
        border-left: 1px solid #d2d6de;
    }
    .control-sidebar-light .nav-tabs.control-sidebar-tabs {
        border-bottom: #d2d6de;
    }
    .control-sidebar-light .nav-tabs.control-sidebar-tabs > li > a {
        background: #e8ecf4;
        color: #444444;
    }
    .control-sidebar-light .nav-tabs.control-sidebar-tabs > li > a,
    .control-sidebar-light .nav-tabs.control-sidebar-tabs > li > a:hover,
    .control-sidebar-light .nav-tabs.control-sidebar-tabs > li > a:focus {
        border-left-color: #d2d6de;
        border-bottom-color: #d2d6de;
    }
    .control-sidebar-light .nav-tabs.control-sidebar-tabs > li > a:hover,
    .control-sidebar-light .nav-tabs.control-sidebar-tabs > li > a:focus,
    .control-sidebar-light .nav-tabs.control-sidebar-tabs > li > a:active {
        background: #eff1f7;
    }
    .control-sidebar-light .nav-tabs.control-sidebar-tabs > li.active.show > a,
    .control-sidebar-light .nav-tabs.control-sidebar-tabs > li.active.show > a:hover,
    .control-sidebar-light .nav-tabs.control-sidebar-tabs > li.active.show > a:focus,
    .control-sidebar-light .nav-tabs.control-sidebar-tabs > li.active.show > a:active {
        background: #f9fafc;
        color: #111;
    }
    .control-sidebar-light .control-sidebar-heading,
    .control-sidebar-light .control-sidebar-subheading {
        color: #111;
    }
    .control-sidebar-light .control-sidebar-menu {
        margin-left: -14px;
    }
    .control-sidebar-light .control-sidebar-menu > li > a:hover {
        background: #f4f4f5;
    }
    .control-sidebar-light .control-sidebar-menu > li > a .menu-info > p {
        color: #5e5e5e;
    }
    ul {
        margin-top: 0;
    }
    .nav-tabs {
        display: block;
    }
    #rightSideBarParagraph {
        line-height: normal;
        /*word-wrap: break-word;*/
        margin: 20px 0;
        display: -webkit-box;
    }

    p {
        margin: 10px 0;
    }
    .bg-purple {
        background-color: #605ca8 ;
    }
    .bg-purple-active {
        background-color: #555299 ;
    }
    .bg-blue {
        background-color: #0073b7 ;
    }
    .bg-blue-active {
        background-color: #005384 ;
    }
    .bg-green {
        background-color: #00a65a ;
    }
    .bg-green-active{
        background-color: #008d4c;
    }
    .bg-red{
        background-color: #dd4b39;
    }
    .bg-red-active{
        background-color: #d33724 ;
    }
    .bg-yellow-active {
        background-color: #db8b0b ;
    }
    .bg-yellow {
        background-color: #f39c12 ;
    }
    .bg-gray {
        color: #000;
        background-color: #d2d6de ;
    }
    .bg-gray-light {
        background-color: #f7f7f7;
    }

    .bg-light-blue{
        background-color: #3c8dbc ;
    }

    .bg-purple-light{
        background-color: #605ca8;
    }

    .bg-green-light{
        background-color: #00a65a;
    }

    .bg-red-light{
        background-color: #dd4b39;
    }

    .bg-yellow-light{
        background-color: #f39c12;
    }

    .moveAppContentLeft{
        margin-right: 300px;
    }

    .appContentDefault{
        margin-right: 0px;
    }

    .controlForm {
        height: auto !important;
    }

    .rightsidebar-datatable  {
        border: 1px solid #060606;
        background-color: #faf4f7;
        color: black;
        max-height: 300px;
    }

    .rightsidebar-datatable  {
        border: 0;
        font-size: 12px;
    }
    .form-control{
        height: auto !important;
    }
    #se_feed_info, #dna_feed_info{
        display: none;
    }
    #help-info {
        height: 100vh;
        width: 280px;
        overflow: scroll;
        border: 5px ridge #9bb9ff;
    }

</style>


<nav id="SideBarThemeToggle" class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li title="{{trans('labels.theme')}}"><a dusk="theme-tab-menu" class="active show" href="#control-sidebar-theme-tab" data-toggle="tab"><i class="fas fa-wrench"></i></a></li>
        {{--<li title="{{trans('labels.media')}}"><a dusk="media-tab-menu" href="#control-sidebar-media-tab" data-toggle="tab"><i class="fas fa-camera"></i></a></li>--}}
        <li title="{{trans('labels.help')}}"><a dusk="help-tab-menu" href="#control-sidebar-help-tab" data-toggle="tab"><i class="far fa-question-circle"></i></a></li>
        <li title="{{trans('labels.home')}}"><a dusk="home-tab-menu" href="#control-sidebar-home-tab" data-toggle="tab"><i class="fas fa-home"></i></a></li>
        <li title="{{trans('labels.settings')}}"><a dusk="settings-tab-menu" href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fas fa-cog"></i></a></li>
    </ul>
    {{--TODO: Add/Edit below Content to the right sidebar panes--}}
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Theme and Layout tab content -->
        <div class="tab-pane active" id="control-sidebar-theme-tab">
            <div>
                <h4 class="control-sidebar-heading" style="padding-bottom: 0px; margin-bottom: 5px;">Layout Options</h4>
                <div class="dropdown-divider" style="margin: 0px;"></div>
                <div class="form-group">
                    <label class="control-sidebar-subheading" style="margin-top: 10px; padding-top: 10px;">
                        <input dusk="toggle-sidebar-expand" id="left-sidebar-expand" type="checkbox"  data-controlsidebar="" class="float-right">Toggle Sidebar</label>
                    <p style="line-height: normal"><small  class="note">Toggle the left sidebar's state (open or collapse)</small></p>
                </div>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        <input dusk="sidebar-expand-on_hover" id="sidebar-expand-on_hover" type="checkbox"  data-controlsidebar="" class="float-right">Left SideBar Expand on Hover</label>
                    <p style="line-height: normal"><small  class="note">Let the Left sidebar mini expand on hover</small></p>
                </div>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        <input dusk="toggle-rightSideBar-slide" id="controlSidebarSlide" type="checkbox"  data-controlsidebar="control-sidebar-open" class="float-right">Toggle Right Sidebar Slide</label>
                    <p style="line-height: normal"><small  class="note">Toggle between slide over content and push content effects</small></p>
                </div>
                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        <input dusk="toggle-rightSideBar-skin" type="checkbox" id="controlSideBarLight" data-sidebarskin="toggle" class="float-right">Toggle Right Sidebar Skin</label>
                        <p style="line-height: normal"><small  class="note">Toggle skins for the right sidebar</small></p>
                </div>

                <h4 class="control-sidebar-heading"style="padding-bottom: 0px; margin-bottom: 5px;">Skins</h4>
                <div class="dropdown-divider" style="margin-bottom: 10px; padding-bottom: 10px;"></div>
                <ul class="list-unstyled clearfix">
                    <li onclick="toggleNavBarColor('#222d32', false)" style="float:left; width: 33.33333%; padding: 5px;">
                        <a dusk="default-theme" href="javascript:void(0)" data-skin="skin-dark" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                            <div>
                                <span class="bg-dark" style="display:block; width: 20%; float: left; height: 7px; background: #222d32">
                                </span>
                                <span class="bg-dark" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                            </div>
                        </a>
                        <p  class="text-center no-margin">Default</p>
                    </li>
                </ul>


                <ul class="list-unstyled clearfix">

                    <h5 class="control-sidebar-subheading" >Dark-Theme Skins</h5>
                    <li onclick="toggleNavBarColor('#0073b7', false)" style="float:left; width: 33.33333%; padding: 5px;">
                        <a dusk="blue-theme" href="javascript:void(0)" data-skin="skin-blue" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                            <div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span>
                                <span class="bg-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                            </div>
                        </a>
                        <p  class="text-center no-margin">Blue</p>
                    </li>
                    <li onclick="toggleNavBarColor('#111111', false)" style="float:left; width: 33.33333%; padding: 5px;">
                        <a dusk="black-theme" href="javascript:void(0)" data-skin="skin-black" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                            <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                                <span style="display:block; width: 20%; float: left; height: 7px; background: black"></span>
                                <span style="display:block; width: 80%; float: left; height: 7px; background: black"></span>
                            </div>
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #222"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin">Black</p>
                    </li>
                    <li onclick="toggleNavBarColor('#555299', false)" style="float:left; width: 33.33333%; padding: 5px;">
                        <a dusk="purple-theme" href="javascript:void(0)" data-skin="skin-purple" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span>
                                <span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin">Purple</p>
                    </li>
                    <li onclick="toggleNavBarColor('#00a65a', false)" style="float:left; width: 33.33333%; padding: 5px;">
                        <a dusk="green-theme" href="javascript:void(0)" data-skin="skin-green" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span>
                                <span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin">Green</p>
                    </li>
                    <li onclick="toggleNavBarColor('#dd4b39', false)" style="float:left; width: 33.33333%; padding: 5px;">
                        <a dusk="red-theme" href="javascript:void(0)" data-skin="skin-red" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span>
                                <span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin">Red</p>
                    </li>
                    <li onclick="toggleNavBarColor('#f39c12', false)" style="float:left; width: 33.33333%; padding: 5px;">
                        <a dusk="yellow-theme" href="javascript:void(0)" data-skin="skin-yellow" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span>
                                <span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin">Yellow</p>
                    </li>

                    <h5 class="control-sidebar-subheading">Light-Theme Skins</h5>
                    <li dusk="blue-light-theme" onclick="toggleNavBarColor('#3c8dbc', true)" style="float:left; width: 33.33333%; padding: 5px;">
                        <a href="javascript:void(0)" data-skin="skin-blue-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span>
                                <span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin" style="font-size: 12px">Blue Light</p>
                    </li>
                    <li onclick="toggleNavBarColor('#111111', true)" style="float:left; width: 33.33333%; padding: 5px;">
                        <a dusk="black-light-theme" href="javascript:void(0)" data-skin="skin-black-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                            <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                                <span style="display:block; width: 20%; float: left; height: 7px; background: black"></span>
                                <span style="display:block; width: 80%; float: left; height: 7px; background: black"></span>

                            </div>
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin" style="font-size: 12px">Black Light</p>
                    </li>
                    <li onclick="toggleNavBarColor('#605ca8', true)" style="float:left; width: 33.33333%; padding: 5px;">
                        <a dusk="purple-light-theme" href="javascript:void(0)" data-skin="skin-purple-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span>
                                <span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>
                            <div><span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span><span
                                        style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span></div>
                        </a>
                        <p class="text-center no-margin" style="font-size: 12px">Purple Light</p></li>
                    <li onclick="toggleNavBarColor('#00a65a', true)" style="float:left; width: 33.33333%; padding: 5px;">
                        <a dusk="green-light-theme" href="javascript:void(0)" data-skin="skin-green-light"
                                                                               style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)"
                                                                               class="clearfix full-opacity-hover">
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span>
                                <span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin" style="font-size: 12px">Green Light</p>
                    </li>
                    <li onclick="toggleNavBarColor('#dd4b39', true)" style="float:left; width: 33.33333%; padding: 5px;">
                        <a dusk="red-light-theme" href="javascript:void(0)" data-skin="skin-red-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span>
                                <span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin" style="font-size: 12px">Red Light</p>
                    </li>
                    <li onclick="toggleNavBarColor('#f39c12', true)" style="float:left; width: 33.33333%; padding: 5px;">
                        <a dusk="yellow-light-theme" href="javascript:void(0)" data-skin="skin-yellow-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span>
                                <span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span>
                            </div>
                            <div>
                                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span>
                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
                            </div>
                        </a>
                        <p class="text-center no-margin" style="font-size: 12px">Yellow Light</p>
                    </li>

                </ul>

                <ul class="list-unstyled clearfix">
                    <h5 class="control-sidebar-subheading" > Custom Theme Color Picker</h5>
                    <input type="color" id="customColor">
                </ul>

            </div>
        </div>

        <!--Media tab content -->
        {{--<div class="tab-pane" id="control-sidebar-media-tab">--}}
            {{--<ul class="control-sidebar-menu">--}}
                {{--<li>--}}
                    {{--<h3 class="control-sidebar-heading" style="padding-bottom: 0px; padding-left: 15px; margin-bottom: 5px;">Video</h3>--}}
                    {{--<div class="dropdown-divider" style="margin-left: 15px; padding-bottom: 5px; margin-right: 15px; margin-bottom: 0px;"></div>--}}
                    {{--<div style="align-content: center;">--}}
                        {{--<video style="padding: 10px" width="300" height="240" controls crossorigin="anonymous">--}}
                            {{--<source src="https://www.youtube.com/watch?v=NgbrqzgyWRo&index=2&list=PLcJSkbOhx_uiOQDhJXvA3UcQj0_KAZI7i" type="video/mp4">--}}
                            {{--Your browser does not support the video tag.--}}
                        {{--</video>--}}
                    {{--</div>--}}
                {{--</li>--}}
                {{--<li>--}}
                    {{--<h3 class="control-sidebar-heading" style="padding-bottom: 0px; margin-bottom: 5px; margin-left: 15px; margin-top: 0px;">Images</h3>--}}
                    {{--<div class="dropdown-divider" style="margin-left: 15px; padding-bottom: 10px; margin-right: 15px; margin-bottom: 0px; padding-bottom: 5px;"></div>--}}
                    {{--<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="width: 300px; height: 300px; padding: 10px;">--}}
                        {{--<ol class="carousel-indicators">--}}
                            {{--<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>--}}
                            {{--<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>--}}
                            {{--<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>--}}
                        {{--</ol>--}}
                        {{--<div class="carousel-inner">--}}
                            {{--<div class="carousel-item active">--}}
                                    {{--<img class="carousel-img"--}}
                                            {{--src="{{ setting('site.welcome_image') }}"--}}
                                            {{--alt="First slide" style="width: 250px; height: 230px; padding-left: 30px;" >--}}

                            {{--</div>--}}
                            {{--<div class="carousel-item">--}}
                                {{--<img class="carousel-img"--}}
                                        {{--src="{{ setting('site.welcome_image') }}"--}}
                                        {{--style="width: 250px; height: 230px; padding-left: 30px;"--}}
                                        {{--alt="Second slide">--}}
                            {{--</div>--}}
                            {{--<div class="carousel-item">--}}
                                {{--<img class="carousel-img"  src="{{ setting('site.welcome_image') }}"--}}
                                      {{--style="width: 250px; height: 230px; padding-left: 30px;" alt="Third slide">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"--}}
                           {{--data-slide="prev">--}}
                            {{--<span class="carousel-control-prev-icon" aria-hidden="true"></span>--}}
                            {{--<span class="sr-only">Previous</span>--}}
                        {{--</a>--}}
                        {{--<a class="carousel-control-next" href="#carouselExampleIndicators" role="button"--}}
                           {{--data-slide="next">--}}
                            {{--<span class="carousel-control-next-icon" aria-hidden="true"></span>--}}
                            {{--<span class="sr-only">Next</span>--}}
                        {{--</a>--}}
                    {{--</div>--}}
                {{--</li>--}}
            {{--</ul>--}}
        {{--</div>--}}

        <!--Help tab content -->
        <div class="tab-pane" id="control-sidebar-help-tab">
            <iframe id="help-info" type="text/html" src="https://cora-docs.readthedocs.io/en/latest/">
            </iframe>
        </div>

        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab" >
            <h4 class="control-sidebar-heading" style="padding-bottom: 0px; margin-bottom: 5px;">Activity Feed</h4>
            <div class="dropdown-divider" style="margin: 0px;"></div>
            <div class="">
                @php
                    $defaultProject = Auth::user()->getCurrentProject();
                    $currentProject = $defaultProject;
                    $SEactivity = $currentProject->se_activities_by_user(Auth::user(),10);
                    $DNAactivity = $currentProject->dna_activities_by_user(Auth::user(), 10);
                @endphp


                <div class="">
                    <div id="activityFeedRightSidebar" style="">
                        <h6 class="control-sidebar-subheading" style="padding-left: 5px">User Activity Feed for Skeletal
                            Elements</h6>
                        <div class="table-responsive rightsidebar-datatable" >
                            <datatable v-bind:labels= "['Key', 'Updated At' ]"
                                       v-bind:table-object="{{$SEactivity}}"
                                       v-bind:columns="['skeletalElementsKey', 'updated_at']"
                                       v-bind:table="'se_feed_sidebar'"
                                       v-bind:sort-column="'1'"
                                       v-bind:sort-direction="'desc'"
                            ></datatable>
                        </div>
                        <h6 class="control-sidebar-subheading" style="padding-left: 5px">User Activity Feed for DNA</h6>
                        <div class="table-responsive rightsidebar-datatable" >
                            <datatable v-bind:labels= "['Key', 'Mito Sequence Number', 'Updated At' ]"
                                       v-bind:table-object="{{$DNAactivity}}"
                                       v-bind:columns="['skeletalElementsKey',  'mito_sequence_number', 'updated_at']"
                                       v-bind:table="'dna_feed_sidebar'"
                                       v-bind:sort-column="'1'"
                                       v-bind:sort-direction="'desc'"
                            ></datatable>
                        </div>
                    </div>
                    </div>
                </div>
                <script>
                    var activityFeedRightSidebar = null;
                    new Vue({
                        el: '#activityFeedRightSidebar',
                        data: {
                            message: 'Hello Sachin'
                        },
                    });
                </script>
        </div>


        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">

            <h4 class="control-sidebar-heading " style="padding-bottom:0px; margin-bottom: 5px; ">General Settings</h4>
            <div class="dropdown-divider" style="margin: 0px;"></div>
            <div>
                {{ Form::model(Auth::user() , array('action' => array('UsersController@updateGeneral', Auth::user()->id)), ['id' => 'userGeneralForm']) }}
                <div class="form-group">
                    <label class="control-sidebar-subheading" style="margin-top: 10px; margin-bottom: 5px; padding-top: 5px;">Lines per Page</label>
                    {{ Form::select('lines_per_page_sidebar', json_decode(Auth::user()->getProfileDisplayValues('lines_per_page')), Auth::user()->getProfileValue("lines_per_page"), ['id' => 'lines_per_page_sidebar', 'class' => "form-control controlForm", 'style' => "width: 50%", 'dusk' => 'lines_per_page'])}}
                    <p style="line-height: normal"><small  class="note">Controls the numbers of rows of data displayed for views with tables</small></p>
                </div>
                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        <input dusk="toggle-rightSideBar-slideout_help" type="checkbox" id="controlSlideoutHelp" data-sidebarskin="toggle" data-value-check="{{Auth::user()->getProfileValue("ui_right_sidebar_slideout_help")}}" class="float-right">Help Slideout</label>
                    <p style="line-height: normal"><small  class="note">Slideout the right sidebar with help on screens such as Specimens measurements, zones and methods</small></p>
                </div>
                <button id="linesPerpageFormButton-sidebar" class="btn btn-primary" type="submit" form="userGeneralForm" dusk="update_general">Update</button>
                <i class="fas fa-spinner fa-spin fas fa-fw" id="line_per_page-update"></i>

                {!! Form::close() !!}

            </div>

            <div>
                <h4 class="control-sidebar-heading" style="padding-bottom:0px; margin-bottom: 5px; ">Specimens Settings</h4>
                <div class="dropdown-divider" style="margin: 0px;"></div>
                {{ Form::model(Auth::user(), array('action' => array('UsersController@updateProjects', Auth::user()->id)), ['id' => 'projects_form']) }}
                <div class="form-group">
                    <label class="control-sidebar-subheading" style="margin-top: 10px; margin-bottom: 5px; padding-top: 5px;">Accession Number</label>
                    {!! Form::text('accession_sidebar', Auth::user()->getProfileValue("accession"), ['id' => 'accession_sidebar', 'class' => 'form-control controlForm', 'style' => 'width: 100%', 'dusk' => 'accession']) !!}
                    <p style="line-height: normal"><small  class="note">If set, the accession number will be auto-populated on New Specimen screen</small></p>
                </div>

                <div class="form-group">
                    <label class="control-sidebar-subheading">Provenance 1</label>
                    {!! Form::text('provenance1_sidebar', Auth::user()->getProfileValue("provenance1"), ['id' => 'provenance1_sidebar', 'class' => 'form-control controlForm', 'style' => 'width: 100%', 'dusk' => 'provenance1']) !!}
                    <p style="line-height: normal"><small  class="note">If set, the provenance1 will be auto-populated on New Specimen screen</small></p>
                </div>
                <div class="form-group">
                    <label class="control-sidebar-subheading">Provenance 2</label>
                    {!! Form::text('provenance2_sidebar', Auth::user()->getProfileValue("provenance2"), ['id' => 'provenance2_sidebar', 'class' => 'form-control controlForm', 'style' => 'width: 100%', 'dusk' => 'provenance2']) !!}
                    <p style="line-height: normal"><small  class="note">If set, the provenance2 will be auto-populated on New Specimen screen</small></p>
                </div>
                <button form="projects_form" class="btn btn-primary" id="project-submit-sidebar-se" type="submit"  dusk="update_projects-rightsidebar-se">Update</button>
                <i class="fas fa-spinner fa-spin fas fa-fw" id="project-setting-update"></i>
                {{ Form::close() }}
            </div>

            <div>
                <h4 class="control-sidebar-heading"style="padding-bottom:0px; margin-bottom: 5px; ">DNA Profile Settings</h4>
                <div class="dropdown-divider" style="margin: 0px;"></div>
                {{ Form::model(Auth::user(), array('action' => array('UsersController@updateProjects', Auth::user()->id)), ['id' => 'projects_form']) }}
                <div class="form-group">
                    <label class="control-sidebar-subheading" style="margin-top: 10px; margin-bottom: 5px; padding-top: 5px;">Default Laboratory</label>
                    {{ Form::select('default_lab', json_decode(Auth::user()->getProfileDisplayValues('default_lab')), Auth::user()->getProfileValue('default_lab'), ['id' => 'default_lab', 'class' => 'form-control controlForm', 'style' => 'width: 50%', 'dusk' => 'default_laboratory']) }}
                    <p style="line-height: normal"><small  class="note">If set, the lab will be auto-populated on DNA association screen for Specimen</small></p>
                </div>
                <div class="form-group">
                    <label class="control-sidebar-subheading" style="margin-top: 5px">Default DNA Method</label>
                    {{ Form::select('default_dna_method', json_decode(Auth::user()->getProfileDisplayValues('default_dna_method')), Auth::user()->getProfileValue('default_dna_method'), ['id' => 'default_dna_method', 'class' => 'form-control controlForm', 'style' => 'width: 50%', 'dusk' => 'default_dna_method']) }}
                    <p style=" line-height: normal; margin: 0; padding: 5px;"><small class="note">If set, the DNA Method will be auto-populated on DNA association screen for Specimen</small></p>
                    <button form="projects_form" class="btn btn-primary" id="project-submit-sidebar-dna" type="submit"  dusk="update_projects">Update</button>
                    <i class="fas fa-spinner fa-spin fas fa-fw" id="project-setting-update-dna"></i>
                    {{ Form::close() }}
                </div>

            </div>
        </div>
        {{--<!-- /.tab-pane -->--}}
    </div>
</nav>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->

<script>
    $('#controlSideBar').click(function() {
        $('.control-sidebar').toggleClass('control-sidebar-open');
        $('#toggleAppContent').removeClass('moveAppContentLeft');
    });

    // set background theme color of rightsidebar
    $('#controlSideBarLight').change(function(){
        if($(this).is(":checked")) {
            $('.control-sidebar').addClass("control-sidebar-light");
            localStorage.setItem('rightsidebarCurrentTheme', 'control-sidebar-light');
        } else {
            $('.control-sidebar').toggleClass("control-sidebar-light");
            localStorage.setItem('rightsidebarCurrentTheme', 'control-sidebar-dark');
        }
    });

    $(document).ready(function($){
        let rightSidebarTheme = localStorage.getItem("rightsidebarCurrentTheme")
        if(localStorage.getItem("rightsidebarCurrentTheme")) {
            $('.control-sidebar').addClass(rightSidebarTheme);
            if(rightSidebarTheme === 'control-sidebar-light') {
                $('#controlSideBarLight').attr('checked', 'checked')
            }
        }

    });
    // end of set color for rightsidebar theme

    // javaScript to move App Content left if the Toggle rightsidebar is checked
    $('#controlSidebarSlide').change(function(){
        if($(this).is(":checked")) {
            $('#toggleAppContent').removeClass("appContentDefault").addClass("moveAppContentLeft");
            localStorage.setItem('rightsidebarSlide', 'moveAppContentLeft');
        } else {
            $('#toggleAppContent').removeClass("moveAppContentLeft").addClass("appContentDefault");
            $('.control-sidebar').toggleClass('control-sidebar-open');
            localStorage.setItem('rightsidebarSlide', 'appContentDefault');
        }
    });

    function open_panel(help_url) {
        $('#help-info').attr('src', help_url);
        $('.control-sidebar').toggleClass('control-sidebar-open');
        $('#control-sidebar-theme-tab').removeClass('active');
        $('#control-sidebar-help-tab').toggleClass('active');
    };

    $(document).ready(function($){
        let rightsidebarSlideOption = localStorage.getItem("rightsidebarSlide");
        if(rightsidebarSlideOption === 'moveAppContentLeft') {
            $('#controlSidebarSlide').attr('checked', true);
            $('#toggleAppContent').removeClass("appContentDefault").addClass("moveAppContentLeft");
            $('.control-sidebar').toggleClass('control-sidebar-open');
        }
        else{
            $('#controlSidebarSlide').attr('checked', false);
            $('#toggleAppContent').removeClass("moveAppContentLeft").addClass("appContentDefault");
        }

    });

    // set Help Slideout
    $(document).ready(function($){
        var value =  $('#controlSlideoutHelp').data("value-check");
        if(value == true){
            $('#controlSlideoutHelp').attr('checked', 'checked');
        }
    });

    $('#controlSlideoutHelp').change(function(){
        if($(this).is(":checked")) {
            $.ajax({
                type:"POST",
                url: '{{ URL::action ('UsersController@updateGeneral', Auth::user()->id) }}',
                data:  {ui_right_sidebar_slideout_help: true},
                success: function(data){
                    console.log(data);
                    messageText = "Update Successful";
                },
                error: function(){
                    messageText = "General Update Failed - Contact Your System Administrator";
                }
            })
        } else {
            $.ajax({
                type:"POST",
                url: '{{ URL::action ('UsersController@updateGeneral', Auth::user()->id) }}',
                data:  {ui_right_sidebar_slideout_help: false},
                success: function(data){
                    console.log(data);
                    messageText = "Update Successful";
                },
                error: function(){
                    messageText = "General Update Failed - Contact Your System Administrator";
                }
            })
        }
    });


    function toggleNavBarColor(color, isLight) {
        let navBarClass = document.querySelector(".navbar");
        let userHeaderClass = document.querySelector(".user-header");

        navBarClass.classList.remove('bg-dark');
        navBarClass.style.backgroundColor = color;
        userHeaderClass.classList.remove('bg-dark');
        userHeaderClass.style.backgroundColor = color;
        localStorage.setItem('currentBgColor', color);

        let leftSideBarClass = $('#sidebar');
        // Change the background color of leftsSideBar if the theme is light
        if(isLight) {
           leftSideBarClass.removeClass('sidebarDark').addClass('sidebarLight');
           localStorage.setItem('activeThemeClass', 'sidebarLight');
        } else {
           leftSideBarClass.removeClass('sidebarLight').addClass('sidebarDark');
           localStorage.setItem('activeThemeClass', 'sidebarDark');
        }
    }

   // custom theme color picker
    let customColor;
    let defaultColor = "#0000ff";

    window.addEventListener("load", startup, false);
    function startup() {
        customColor = document.querySelector("#customColor");
        customColor.value = defaultColor;
        customColor.addEventListener("input", updateFirst, false);
        customColor.select();
    }
    function updateFirst(event) {
        let navbar = document.querySelector(".navbar");
        let userHeaderClass = document.querySelector(".user-header");

        navbar.classList.remove('bg-dark');
        userHeaderClass.classList.remove('bg-dark');
        bgColor = event.target.value;
        navbar.style.backgroundColor = bgColor;
        userHeaderClass.style.backgroundColor = bgColor;
        localStorage.setItem('currentBgColor', bgColor);
    }

    // AJAX Request for lines per page
    $(document).ready(function() {
        let line_per_page_update = $('#line_per_page-update').hide();
        $('#linesPerpageFormButton-sidebar').click(function() {
            line_per_page_update.show();
        });
        $(document).ajaxStart(function() {

        }).ajaxStop(function() {
            line_per_page_update.hide();
        });

        $('#linesPerpageFormButton-sidebar').click(function(e){
            e.preventDefault(e);

            $.ajax({
                type:"POST",
                url: '{{ URL::action ('UsersController@updateGeneral', Auth::user()->id) }}',
                data:  {lines_per_page: $("#lines_per_page_sidebar").val()},
                success: function(data){
                    console.log(data);
                    messageText = "Update Successful";
                },
                error: function(){
                    messageText = "General Update Failed - Contact Your System Administrator";
                }
            })
        });
    });

    // AJAX Request for specimens
    $(document).ready(function() {
        let project_settingupdate = $('#project-setting-update').hide();
        $('#project-submit-sidebar-se').click(function() {
            project_settingupdate.show();
        });
        $(document).ajaxStart(function() {
            //
        }).ajaxStop(function() {
            project_settingupdate.hide();
        });

        $('#project-submit-sidebar-se').click(function(e){
            e.preventDefault(e);

            $.ajax({
                type:"POST",
                url: '{{ URL::action ('UsersController@updateProjects', Auth::user()->id) }}',
                data:  {
                    accession: $("#accession_sidebar").val(),
                    provenance1: $("#provenance1_sidebar").val(),
                    provenance2: $("#provenance2_sidebar").val()
                }
            })
        });
    });

    // AJAX Request for DNA setting
    $(document).ready(function() {
        let project_settingupdate_dna = $('#project-setting-update-dna').hide();
        $('#project-submit-sidebar-dna').click(function() {
            project_settingupdate_dna.show();
        });
        $(document).ajaxStart(function() {
            //
        }).ajaxStop(function() {
            project_settingupdate_dna.hide();
        });

        $('#project-submit-sidebar-dna').click(function(e){
            e.preventDefault(e);

            $.ajax({
                type:"POST",
                url: '{{ URL::action ('UsersController@updateProjects', Auth::user()->id) }}',
                data:  {
                    default_lab: $("#default_lab").val(),
                    default_dna_method: $("#default_dna_method").val(),
                }
            })
        });
    });

    // To show the image of carousel as modal
    $('.carousel-img').click(function(){
        $('#modal .modal-body').html($(this).clone()[0]);
        $('#modal').modal('show');
    });

</script>