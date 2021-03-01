{{--
 * Main App Layout
 *
 * @category   Main App Layout Views
 * @package    Layout
 * @author     Sachin Pawaskar - spawaskar@unomaha.edu
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ setting('site.description') }}">
    <meta name="author" content="Sachin Pawaskar, spawaskar@unomaha.edu; sachinpawaskar@msn.com; sachinspawaskar@gmail.com" />
    <meta name="copyright" content="Sachin Pawaskar" />
    <meta name="keywords" content="{{ setting('site.seo_keywords') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>@yield('title', config('app.name', 'CoRA'))</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <!-- bootstrap 4 files-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Material Design Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/3.8.95/css/materialdesignicons.css">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" integrity="sha256-xJOZHfpxLR/uhh1BwYFS5fhmOAdIRQaiOul5F/b7v3s=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.18/css/dataTables.bootstrap4.min.css" integrity="sha256-F+DaKAClQut87heMIC6oThARMuWne8+WzxIDT7jXuPA=" crossorigin="anonymous" />
    @yield('styles')
    <link rel="stylesheet" href="{{ mix('css/app.css') }}"> 

    <!-- Styles -->
    <style>
        div#chatter_hero { height: 75px; min-height: 75px !important; }
        div#chatter_hero img { margin: 0px auto !important; }
        div#chatter_hero_dimmer { height: 75px !important; }
        div#chatter_hero h1 { padding-top: 5px !important; }

        .wrapper { display: flex; align-items: stretch; }
        .breadcrumb { margin-bottom: 0 }
        .container-fluid { margin: 0.2rem 0rem; padding: 0rem 0.2rem; }
    </style>
    {{--@include("common.analyticstracking")--}}
    @include("common.gtmhead")
</head>
<body class="app-container" style="line-height: 0;">
@include("common.gtmbody")
<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js" integrity="sha256-FA14tBI8v+/1BtcH9XtJpcNbComBEpdawUZA6BPXRVw=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.18/js/jquery.dataTables.min.js" integrity="sha256-3aHVku6TxTRUkkiibvwTz5k8wc7xuEr1QqTB+Oo5Q7I=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.18/js/dataTables.bootstrap4.min.js" integrity="sha256-hJ44ymhBmRPJKIaKRf3DSX5uiFEZ9xB/qx8cNbJvIMU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.16/vue.js" integrity="sha256-CMMTrj5gGwOAXBeFi7kNokqowkzbeL8ydAJy39ewjkQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js" integrity="sha256-CfcERD4Ov4+lKbWbYqXD6aFM9M51gN4GUEtDhkWABMo=" crossorigin="anonymous"></script>
<script src="{{ mix('js/app.js') }}"></script>
<div id="app" class="app-container">
    <app> </app>
{{--    <div id="head">--}}
{{--    </div>--}}
    <!-- Navigation Bar -->
{{--    @include('layouts.common.header')--}}
{{--    <div class="wrapper">--}}
{{--        <!-- Left Sidebar -->--}}
{{--        @if (Auth::check())--}}
{{--            @include('layouts.common.leftsidebar')--}}
{{--        @endif--}}

{{--        <!-- Content -->--}}
{{--        <div class="container-fluid app-content" id="toggleAppContent" style="line-height: 1.6;">--}}
{{--            @yield('content')--}}
{{--        </div>--}}

{{--        <!-- Right Sidebar -->--}}
{{--        @if (Auth::check())--}}
{{--            @include('layouts.common.rightsidebar')--}}
{{--        @endif--}}
{{--    </div> --}}{{-- wrapper--}}
    <!-- Footer Sidebar -->
{{--    @include('layouts.common.footer')--}}
    <!-- Scripts -->
{{--    @yield('scripts')--}}
    <!-- Footer -->
{{--    @yield('footer')--}}
</div>
<script>
    new Vue({
        el: '#app',
        vuetify: new Vuetify(),
    })
    $("div#login_or_register").hide(); // This will hide the CoRA Forum/Chatter login/register div.
</script>
</body>
</html>
