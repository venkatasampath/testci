{{--
 * Change Password
 *
 * @category   Change Password Views
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
                <div class="card-header">
                    <div class="row">
                        <div class="float-left col-4">
                            {{ Breadcrumbs::render('changePassword') }}
                        </div>
                        <div class="col-4">
                            <h4>@lang('labels.change_password')</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('common.errors')
                    @include('common.flash')

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/change') }}">{!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">@lang('labels.old_password')</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="old_password">
                                @if ($errors->has('old_password'))
                                    <span class="help-block"><strong>{{ $errors->first('old_password') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">@lang('labels.new_password')</label>
                            <div class="col-md-6"><input type="password" class="form-control" name="password"></div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">@lang('labels.confirm_password')</label>
                            <div class="col-md-6"><input type="password" class="form-control" name="password_confirmation"></div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="alert alert-info">{{ App\Http\Traits\PasswordsTrait::getPasswordRequirementText() }}</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-6">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-btn fa-save"></i>@lang('labels.save')</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
