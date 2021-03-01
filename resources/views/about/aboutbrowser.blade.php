<div class="card-body card-body-aboutbrowser">
    <div class="table-responsive" style="margin: 0px;">
        <table class="table table-striped aboutbrowser">
            <tbody> <!-- Table Body -->
            <tr>
                <td class="name">@lang('labels.browser_name'):</td>
                <td class="value">
                    <script>
                        document.write(navigator.appName);
                        document.write(" (codename: "); document.write(navigator.appCodeName); document.write(")");
                    </script>
                </td>
            </tr>
            <tr><td class="name">@lang('labels.browser_version'):</td><td class="value"><script>document.write(navigator.appVersion);</script></td></tr>
            <tr><td class="name">@lang('labels.cookies'):</td><td class="value"><script>document.write(navigator.cookieEnabled);</script></td></tr>
            {{--<tr><td class="name">@lang('labels.geo_location'):</td><td id="app-geoLocation" class="value"></td></tr>--}}
            <tr><td class="name">@lang('labels.language'):</td><td class="value"><script>document.write(navigator.language);</script></td></tr>
            <tr><td class="name">@lang('labels.online'):</td><td class="value"><script>document.write(navigator.onLine);</script></td></tr>
            <tr><td class="name">@lang('labels.product'):</td><td class="value"><script>document.write(navigator.product);</script></td></tr>
            <tr><td class="name">@lang('labels.operating_system'):</td><td class="value"><script>document.write(navigator.platform);</script></td></tr>
            <tr><td class="name">@lang('labels.user_agent'):</td><td class="value"><script>document.write(navigator.userAgent);</script></td></tr>
            </tbody>
        </table>
    </div>
</div>
