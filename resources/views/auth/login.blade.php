@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".trans('labels.login'))

@section('content')
<div class="container">
{{--    <coralogin></coralogin>--}}
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-header"><h4>@lang('labels.login')</h4></div>
                <div class="card-body">
                    @include('common.errors')
                    @include('common.flash')

                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}" dusk="login-email">
                            <label for="email" class="col-md-4 control-label">@lang('labels.email_address')</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}" dusk="login-password">
                            <label for="password" class="col-md-4 control-label">@lang('labels.password')</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group" dusk="login-remember_me-check">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('labels.remember_me')</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" dusk="login-forgot_password">
                            <div class="col-md-8 col-md-offset-4" >
                                <button type="submit" class="btn btn-primary" dusk="login">@lang('labels.login')</button>
                                <a class="btn btn-link" href="{{ route('password.request') }}">@lang('labels.forgot_your_password')</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
