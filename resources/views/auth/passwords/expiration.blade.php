{{--
 * Password Expiration
 *
 * @category   Password Expiration Views
 * @package    Auth.Password
 * @author     Sachin Pawaskar - spawaskar@unomaha.edu
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
--}}
@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">@lang('labels.password_expired')</div>
                    <div class="card-body">
                        @include('common.errors')
                        @include('common.flash')

                        <form class="form-horizontal" method="POST" action="{{ route('passwordExpiration') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="col-md-4 control-label">Current Password</label>
                                <div class="col-md-6">
                                    <input id="current-password" type="password" class="form-control" name="current-password" required>
                                    @if ($errors->has('current-password'))
                                        <span class="help-block"><strong>{{ $errors->first('current-password') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="col-md-4 control-label">New Password</label>
                                <div class="col-md-6">
                                    <input id="new-password" type="password" class="form-control" name="new-password" required>
                                    @if ($errors->has('new-password'))
                                        <span class="help-block"><strong>{{ $errors->first('new-password') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="new-password-confirm" class="col-md-4 control-label">Confirm New Password</label>
                                <div class="col-md-6"><input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required></div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="alert alert-info">{{ App\Http\Traits\PasswordsTrait::getPasswordRequirementText() }}</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">@lang('labels.change_password')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
