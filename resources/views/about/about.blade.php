<div class="card-body card-body-about">
    <div class="table-responsive" style="margin: 0px;">
        <table class="table table-striped about">
            <tbody> <!-- Table Body -->
            <tr><td class="name">@lang('labels.application_name'):</td><td class="value">{{ config('app.name', 'CoRA') }}</td></tr>
            <tr><td class="name">@lang('labels.version'):</td><td class="value">{{ config('app.version') }}</td></tr>
            <tr><td class="name">@lang('labels.copyright'):</td><td class="value">@lang('messages.copyright', ['yearto' => '2019'])</td></tr>
            <tr><td class="name">@lang('labels.product_protection'):</td><td class="value">@lang('messages.product_protection')</td></tr>
            <tr><td class="name">@lang('labels.optimized_for_browser'):</td><td class="value">@lang('messages.optimized_for_browser')</td></tr>
            <tr><td class="name">@lang('labels.supported_browsers'):</td>
                <td class="value">
                    <ul class="supportedbrowser">
                        <li><a href="http://www.google.com/chrome" target="_blank">http://www.google.com/chrome</a></li>
                        {{--<li><a href="http://www.mozilla.org/firefox" target="_blank">http://www.mozilla.org/firefox</a></li>--}}
                        <li><a href="http://www.microsoft.com/en-us/windows/microsoft-edge" target="_blank">http://www.microsoft.com/en-us/windows/microsoft-edge</a></li>
                    </ul>
                </td>
            </tr>
            <tr><td class="name">@lang('labels.popup_blocker'):</td><td class="value">@lang('messages.popup_blocker')</td></tr>
            </tbody>
        </table>
    </div>
</div>

@section('footer')
    @parent
    <script>
        var appGeoLocation = document.getElementById("app-geoLocation");
        $(document).ready(function() {
//        appGeoLocation = document.getElementById("app-geoLocation");
//        getLocation();
        });

        function getLocation() {
            if (navigator.geolocation) {
                appGeoLocation.innerHTML = navigator.geolocation.getCurrentPosition(showPosition, showPositionError);
            } else {
                appGeoLocation.innerHTML = "Geolocation is not supported by this browser.";
            }
        }
        function showPosition(position) {
            appGeoLocation.innerHTML =  "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;
        }
        function showPositionError(error) {
            var error_msg = "Missing error code";
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    error_msg = "User denied the request for Geolocation.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    error_msg = "Location information is unavailable.";
                    break;
                case error.TIMEOUT:
                    error_msg = "The request to get user location timed out.";
                    break;
                case error.UNKNOWN_ERROR:
                    error_msg = "An unknown error occurred.";
                    break;
            }
            appGeoLocation.innerHTML =  error_msg;
        }
    </script>
@endsection