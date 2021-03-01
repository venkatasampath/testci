{{--<div class="table-responsive">--}}
{{--    <table class="table table-bordered table-striped">--}}
{{--        <tbody>--}}
{{--        <tr><td><b>@lang('labels.last_login_time')</b></td><td>@cora_converttime($theUser->last_login_at)</td></tr>--}}
{{--        <tr><td><b>@lang('labels.device')</b></td><td>{{ $theUser->last_login_device}}</td></tr>--}}
{{--        <tr><td><b>@lang('labels.ip_address')</b></td><td>{{ $theUser->last_login_ip_address}}</td></tr>--}}
{{--        <tr><td><b>@lang('labels.total_num_logins')</b></td><td>{{ $theUser->number_of_logins}}</td></tr>--}}
{{--        <tr><td><b>@lang('labels.password_last_changed')</b></td><td>@cora_converttime($theUser->password_updated_at)</td></tr>--}}
{{--        </tbody>--}}
{{--    </table>--}}
{{--    {{$theUser}}--}}
    <lastlogon :user_items="{{$theUser}}"></lastlogon>
{{--</div>--}}
