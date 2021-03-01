<style>
    .main-header {
        position: relative;
        max-height: 125px;
        z-index: 1030;
        border: none;
    }
    .navbar {
        /*background-color: #3c8dbc;*/
        /*background: #222d32;*/
        margin-bottom: 0;
        border: none;
        min-height: 50px;
        max-height: 50px;
        -webkit-border-radius: 0;
        -moz-border-radius:0;
        border-radius:0;
        padding: 0rem 1rem;
    }
    /*.nav-item {*/
        /*position: relative;*/
        /*display: block;*/
        /*padding: 0 15px;*/
    /*}*/

    .headerMenuOptions {
        position: relative;
        display: block;
        padding: 0 5px;
        max-height: 50px;
    }
    #profilePicture {
        border-radius: 50%;
        padding-right: 3px;
    }
    .navbar-brand {
        width: 240px;
        padding: 1rem 0rem;
        transition: width 0.3s ease-in-out;
        -webkit-transition: width 0.3s ease-in-out;
        -o-transition: width 0.3s ease-in-out;
    }
    .navbar-brand.navToggle {
        width: 36px;
        transition: width 0.3s ease-in-out;
        -webkit-transition: width 0.3s ease-in-out;
        -o-transition: width 0.3s ease-in-out;
    }

    .navbar-brand.navToggle .navToggleText {
        display: none;
    }

    .navbar-collapse {
        padding-right: 0;
    }
    .caret {
        margin-left: 3px;
    }
    .profile-img {
        width: 32px; height: 32px;
    }

    .user-dropdown{
        position: absolute;
        right: 5%;
        left:  auto;
        width: 400px;
        padding: 1px 1px !important;
    }

    #user-header{

        height: 100px;
        padding: 10px;
        font-size: 13px;

    }

    #user-body{
        padding: 10px;
        font-size: 13px;
        /*background-color: #8eb4cb;*/
    }

    #user-footer{
        padding: .5rem 1rem;
    }

    #community-tab{
        /*background-color: #1a1f21;*/
    }



    .img {
        z-index: 5;
        height: 85px;
        width: 85px;
        border: 3px solid;
        border-color: transparent;
        border-color: rgba(255, 255, 255, 0.2);
        /*border-radius: 50%;*/
    }

    .img-circle {
        border-radius: 50%;
    }

    .user-info{
        /*z-index: 5;*/

        color: #fff;
        color: rgba(255, 255, 255, 0.8);


        /*color: #fff;*/
        /*color: rgba(255, 255, 255, 0.8);*/
        font-size: 13px;

        /*word-wrap:break-word;*/
    }

    .btn-flat {
        width: 120px;
    }

    .navbar-brand > img {
        display: inline-block;
    }
    .mobile-navbar-collapse {
        display: none;
    }
    @media (max-width: 480px) {
        .navbar:before {
            content: none;
        }
        .navbar {
            min-height: 125px;
        }
        .navToggleText {
            display: none;
        }
        #sidebarCollapse {
            /*left: 40px;*/
            /*top: 5px;*/
            /*position: absolute;*/
            display: none;
        }
        .navbar-brand.navToggle {
            display: inline-block;
        }
        #menuCollapse {
            top: 5px;
            right: 5px;
            position: absolute;
        }
        .mobile-navbar-collapse.show {
            display: block !important;
            margin-right: -15px;
            margin-left: -15px;
            background: white;
            width: 100%;
            top: 125px;
            position: absolute;
        }
        .mobileNav {
            display: block;
        }
        .mobilenav-item {
            padding: 1rem 2rem;
            font-weight: 500;
            font-size: 1.8rem;
        }
        .mobilenav-item a {
            color: black;
        }
        .mobile-user-info {
            padding-left: 5px;
            background: rgb(34, 45, 50);
            border: 1px solid #fff;
            color: #fff;
        }
    }
    @media (min-width: 768px) {
        #menuCollapse {
            display: none;
        }
    }

    .nav-link-icon { margin-top:.5rem; }
    .user-footer-button { padding: 0rem 1rem; display: flex; align-items: center; justify-content: center; }
    .notify-badge { position: absolute; left: 20px; top: 5px; background-color: grey; color: lime; padding: 2px 6px;}
</style>
<header class="main-header">
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a class="navbar-brand navToggle" href="{{ url('/') }}"><img src="/favicon.ico" style="width: 32px; height: 32px" title="CoRA">
            <span class="navToggleText">CoRA</span>
        </a>
        @if (Auth::check())
            <button dusk="rightSideBar-menu" type="button" id="sidebarCollapse" class="btn btn-outline-light navbar-btn">
                <i class="fas fa-align-justify" title="Expand/Collapse"></i>
            </button>
            <div id="nav-project-switch-search" class="float-left" data-userid="{{Auth::user()->id}}">
                {{ Form::open(array('url' => '/users/'.Auth::user()->id.'/refreshDashboard', 'class'=>"project-switch float-left", 'role'=>"project")) }}
                    {{ Form::hidden('currentProject', Auth::user()->getCurrentProject()->id, ['id' => 'currentProject']) }}
                    <projectswitcher class="float-left" @switched="switchproject" :user="{{Auth::user()}}" :projects="{{Auth::user()->projects()->get()}}" :selected="{{Auth::user()->getCurrentProject()->id}}" :currentproject="{{Auth::user()->getCurrentProject()}}">
                    </projectswitcher>
                {{ Form::close() }}
                {{ Form::open(array('url' => '/skeletalelements/searchgo', 'class'=>"project-search float-left", 'role'=>"project")) }}
                    {{ Form::hidden('searchstring', '', ['id' => 'searchstring', 'class' => 'searchstring']) }}
                    {{ Form::hidden('searchby', '', ['id' => 'searchby', 'class' => 'searchby']) }}
                    <projectsearchbar class="float-right" @searchgo="executesearch" :user="{{Auth::user()}}" :accessions="{{Auth::user()->getCurrentProject()->listaccessions()}}" defaultsearchoption={{Auth::user()->getProfileValue("default_search_option")}} searchViewURL={{url('/skeletalelements/search')}}>
                    </projectsearchbar>
                {{ Form::close() }}
            </div>
        @endif
            <button dusk="collapse-menu" type="button" id="menuCollapse" class="btn btn-outline-light navbar-btn">
                <i class="fas fa-align-justify" title="Expand/Collapse"></i>
            </button>

            {{--Mobile view Collapsed Menu --}}
        <nav class="collapse mobile-navbar-collapse" id="mobileMenuBar">
            {{-- User is not logged in --}}
            <div>
                @if (Auth::guest())
                    <div class="mobile-item">
                        <ul class="nav mobileNav">
                            <li class="mobilenav-item" title="{{trans('labels.login')}}">
                                <a class="" dusk="login-menu" href="{{ url('/login') }}">@lang('labels.login')</a>
                            </li>
                            <li class="mobilenav-item" title="{{trans('labels.github')}}">
                                <a class="" dusk="github-cora-docs-menu" href="https://github.com/spawaskar-cora/cora-docs" target="_blank">Github</a>
                            </li>
                            <li class="mobilenav-item" title="{{trans('labels.forum')}}">
                                <a class="" dusk="forum-menu" href="{{ url('/forums') }}">Forums</a>
                            </li>
                        </ul>
                    </div>
                @else
                    {{-- User is logged in --}}
                    {{-- User Info --}}
                    <div class="mobile-item mobile-user-info row">
                        <div class="col-xs-3" style="padding-right: 0px;">
                            <img src="{{ Auth::user()->avatar }}" class="img img-circle" id="profilePicture">
                        </div>
                        <div class="col-xs-9" style="font-weight: bold">
                            <p class="">{{ isset(Auth::user()->display_name) ? Auth::user()->display_name : Auth::user()->name }}</p>
                            <br>
                            <p class="">{{ Auth::user()->email }}</p>
                            <br>
                            <p class="">{{Auth::user()->org->acronym}}: {{Auth::user()->role->display_name}}</p>
                        </div>
                    </div>
                    {{-- Notifications Menu --}}
                    <div class="mobile-item">
                        <ul class="nav mobileNav">
                            <li class="mobilenav-item" title="{{trans('labels.notifications')}}">
                                <a class="" dusk="login-menu" href="{{ url('/notifications') }}">@lang('labels.notifications')</a>
                            </li>
                        </ul>
                    </div>
                    {{-- Community Info Menu --}}
                    <div class="mobile-item">
                        <ul class="nav mobileNav">
                            <li class="mobilenav-item" title="{{trans('labels.github')}}">
                                <a class="" dusk="github-cora-docs-menu" href="https://github.com/spawaskar-cora/cora-docs" target="_blank">Github</a>
                            </li>
                            <li class="mobilenav-item" title="{{trans('labels.forum')}}">
                                <a class="" dusk="forum-menu" href="{{ url('/forums') }}">Forums</a>
                            </li>
                            <li class="mobilenav-item">
                                <a class="" dusk="slack-menu" href="https://cora-spawaskar.slack.com" target="_blank">Slack</a>
                            </li>
                        </ul>
                    </div>
                    {{-- Profile Info Menu --}}
                    <div class="mobile-item">
                        <ul class="nav mobileNav">
                            <li class="mobilenav-item">
                                <a class="" style="word-wrap:break-word;" dusk="change-password--menu" href="{{ url('/password/change') }}">
                                    @lang('labels.change_password')
                                </a>
                            </li>
                            <li class="mobilenav-item">
                                <a class="dropdown-item" style="word-wrap:break-word;"  dusk="online-help-menu" href="{{ setting('site.url_online_help') }}" target="_blank">
                                    @lang('labels.online_help')
                                </a>
                            </li>
                            <li class="mobilenav-item">
                                <a class="dropdown-item" style="word-wrap:break-word;" dusk="about-menu" href="{{ url('/about') }}">@lang('labels.about')</a>
                            </li>
                        </ul>
                    </div>
                    <div class="mobile-item">
                        <ul class="nav mobileNav">
                            <li class="mobilenav-item">
                                <a class=""  dusk="profiles-menu" href="{{ url('/user/'. Auth::user()->id . '/profile') }}">
                                    @lang('labels.my_profile')
                                </a>
                            </li>
                            @if(Auth::user()->isOrgAdmin() || Auth::user()->isAdmin())
                                <li class="mobilenav-item">
                                    <a class=""  dusk="org-profiles-menu" href="{{ url('/org/'. Auth::user()->org->id . '/profile') }}">
                                        @lang('labels.org_profile')
                                    </a>
                                </li>
                            @endif
                            <li class="mobilenav-item">
                                <a class=""  dusk="logout-menu" href="{{ url('/logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    @lang('labels.logout')
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        </nav>
            {{--Mobile view Collapsed Menu --}}


        <div class="collapse navbar-collapse">
            <ul class="navbar-nav float-sm-right">
                @if (Auth::guest())
                    <li class="nav-item" title="{{trans('labels.github')}}">
                        <a class="nav-link py-2" dusk="github-cora-docs-menu" href="https://github.com/spawaskar-cora/cora-docs" target="_blank"><i class="fab fa-github"></i></a>
                    </li>
                    <li class="nav-item" title="{{trans('labels.forum')}}">
                        <a class="nav-link py-2" dusk="forum-menu" href="{{ url('/forums') }}"><i class="fab fa-lg fa-weixin"></i></a>
                    </li>
                    <li class="nav-item" title="{{trans('labels.login')}}">
                        <a class="nav-link py-2" dusk="login-menu" href="{{ url('/login') }}"><i class="fas fa-fw fa-sign-in-alt"></i>@lang('labels.login')</a>
                    </li>
                @else
                    <li class="nav-item headerMenuOptions" title="{{trans('labels.notifications')}}">
                        <div id="notification-window">
                            <a href="#" v-on:click="toggleNotificationWindow" class="nav-link nav-link-icon notify py-3 notify-bell" data-toggle="dropdown"><i class="fas fa-fw fa-bell"></i>
                                @if(Auth::user()->getUnreadNotificationCount() > 0)
                                    <span v-show="showBadge" class="badge badge-pill badge-success notify-badge">{{ Auth::user()->getUnreadNotificationCount() }}</span>
                                @endif
                            </a>
                            <notification
                                   id="notificationDropdown" @updatebadge="updatenotificationcount" v-show="showWindow" :user="{{Auth::user()}}" :notifications-count="{{ Auth::user()->getUnreadNotificationCount() }}" :notifications="{{ Auth::user()->getUnreadNotifications() }}"
                            ></notification>
                        </div>
                    </li>
                    <li class="nav-item dropdown headerMenuOptions" style="margin-left: 10px">
                        <a href="#" class="nav-link nav-link-avatar py-2" data-toggle="dropdown" role="button" aria-expanded="false" title="{{trans('labels.profile')}}">
                            <img src="{{ Auth::user()->avatar }}" alt="Profile picture" class="rounded-circle profile-img" id="profilePicture">
                        </a>

                        <ul class="dropdown-menu user-dropdown" role="menu">
                            {{--start of new user dropdown--}}
                            <li class="user-header bg-dark" id="user-header">
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-xs-3" style="padding-right: 0px;"><img src="{{ Auth::user()->avatar }}" class="img img-circle" id="profilePicture"></div>
                                    <div class="col-xs-9" style="padding-left: 5px;">
                                        <p class="user-info">{{ isset(Auth::user()->display_name) ? Auth::user()->display_name : Auth::user()->name }}</p>
                                        <br>
                                        <p class="user-info">{{ Auth::user()->email }}</p>
                                        <br>
                                        <p class="user-info">{{Auth::user()->org->acronym}}: {{Auth::user()->role->display_name}}</p>
                                    </div>
                                </div>
                            </li>

                            <li class="user-body" id="user-body">
                                <div class="row" id="community-tab">
                                    <div class="col-sm-12 text-left">
                                        <span class="pull-left"><p><strong>@lang('labels.community')</strong></p></span>
                                        <span class="pull-left"><a class="dropdown-item" dusk="github-cora-docs-menu" href="https://github.com/spawaskar-cora/cora-docs" target="_blank"><i class="fab fa-github"></i></a></span>
                                        <span class="pull-left"><a class="dropdown-item" dusk="forum-menu" href="{{ url('/forums') }}"><i class="fab fa-lg fa-weixin"></i></a></span>
                                        <span class="pull-left"><a class="dropdown-item" dusk="slack-menu" href="https://cora-spawaskar.slack.com" target="_blank"><i class="fab fa-lg fa-slack"></i></a></span>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="row">
                                    <div class="col-sm-4 text-center" style="word-wrap:break-word;">
                                        <a class="dropdown-item" style="word-wrap:break-word;" dusk="change-password--menu" href="{{ url('/password/change') }}">
                                            <i class="fas fa-fw fa-btn fa-lock"></i>@lang('labels.change_password')
                                        </a>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <div class="row">
                                    <div class="col-sm-4 text-center">
                                        <a class="dropdown-item" style="word-wrap:break-word;"  dusk="online-help-menu" href="{{ setting('site.url_online_help') }}" target="_blank">
                                            <i class="fas fa-fw fa-btn fa-question-circle"></i>@lang('labels.online_help')
                                        </a>
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <a class="dropdown-item" style="word-wrap:break-word;" dusk="about-menu" href="{{ url('/about') }}"><i class="fas fa-fw fa-btn fa-info"></i>@lang('labels.about')</a>
                                    </div>
                                </div>
                            </li>

                            <div class="dropdown-divider"></div>
                            <li class="user-footer" id="user-footer">
                                <div class="row">
                                    <div class="col-sm-4 user-footer-button">
                                        <a class="btn btn-primary btn-flat float-left"  dusk="profiles-menu" href="{{ url('/users/'. Auth::user()->id . '/profile') }}">
                                            <i class="fas fa-fw fa-btn fa-cog"></i>@lang('labels.my_profile')</a>
                                    </div>
                                    <div class="col-sm-4 user-footer-button">
                                        @if(Auth::user()->isOrgAdmin() || Auth::user()->isAdmin())
                                        <a class="btn btn-primary btn-flat"  dusk="org-profiles-menu" href="{{ url('/org/'. Auth::user()->org->id . '/profile') }}">
                                            <i class="fas fa-fw fa-btn fa-building"></i>@lang('labels.org_profile')</a>
                                        @endif
                                    </div>
                                    <div class="col-sm-4 user-footer-button">
                                        <a class="btn btn-primary btn-flat float-right"  dusk="logout-menu" href="{{ url('/logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-fw fa-btn fa-sign-out-alt"></i>@lang('labels.logout')
                                        </a>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                                    </div>
                                </div>
                            </li>
                            {{--end of new user dropdown--}}
                        </ul>
                    </li>
                @endif
                @if (Auth::check())
                    <li class="nav-item headerMenuOptions" title="{{trans('labels.quick_settings')}}">
                        <a dusk="right-sideBar-Menu" href="#" data-toggle="control-sidebar" class="nav-link nav-link-icon py-2" id="controlSideBar">
                            <i class="fas fa-cogs"></i>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>

<script>
    @if (Auth::check())
    new Vue({
        el: '#nav-project-switch-search',
        vuetify: new Vuetify(),
        data: {
            message: 'Hello Sachin',
            showModal: false,
        },

        methods: {
            switchproject(to) {
                // alert("Parent switch project to: " + to);
                let formProjectSwitch =  $("form.project-switch");
                $("input#currentProject", formProjectSwitch).val(to);
                formProjectSwitch.submit();
            },

            executesearch(option, val) {
                let formProjectSearch =  $("form.project-search");
                let option_results = option.split('-');
                let searchtype = option_results[0];
                $("input#searchby", formProjectSearch).val(option_results[1]);
                $("input#searchstring", formProjectSearch).val(val);
                // alert("Parent Search Go: " + option + " - " + val + "\n Options: " + option_results[0] + ' and ' + option_results[1]);

                if (searchtype === 'DNA') {
                    let url = formProjectSearch.attr('action');
                    let new_url = url.replace("skeletalelements", "dnas");
                    formProjectSearch.attr('action', new_url);
                }
                formProjectSearch.submit();
            },
        },
    });

    new Vue({
        el: '#notification-window',
        data: {
            message: 'Hello Sachin',
            showModal: false,
            showWindow: false,
            showBadge: true
        },

        methods: {
            toggleShow(e) {
                let self = this;
                let notificationDropdown = $('#notificationDropdown');
                if(!e.target.matches('.fa-bell') && !notificationDropdown.is(e.target) && notificationDropdown.has(e.target).length === 0) {
                    self.showWindow = false;
                    if(parseInt($('.notify-badge').text()) !== 0) {
                        self.showBadge = true;
                    } else {
                        self.showBadge = false;
                    }
                }
            },

            updatenotificationcount: function(unreadNotificationsCount) {
                console.log("Notification is marked read, update count");
                $('.notify-badge').text(unreadNotificationsCount);
            },

            toggleNotificationWindow: function() {
                this.showWindow = !this.showWindow;
                if(parseInt($('.notify-badge').text()) !== 0) {
                    this.showBadge = !this.showBadge;
                }
            }
        },

        created() {
            document.onclick = this.toggleShow;
        }
    });
    @endif

    $(document).ready(function($){
        $('select#accessions').select2();
        let colorToAdd = localStorage.getItem("currentBgColor");
        if(localStorage.getItem("currentBgColor")) {
            $('.navbar').removeClass('bg-dark').css('backgroundColor', colorToAdd);
            $('.user-header').removeClass('bg-dark').css('backgroundColor', colorToAdd);
        }
    });
    $("#menuCollapse").on("click", function() {
        $("#mobileMenuBar").toggleClass("show");
    });

</script>




