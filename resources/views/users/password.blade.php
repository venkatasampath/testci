@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <div class="row">
                            <div class="float-left col-4">
                                {{ Breadcrumbs::render('users.resetPassword', $user) }}
                            </div>
                            <div class="col-4"><h4>{{ $heading }}</h4></div>
                            <div class="float-right col-4">
                                <!-- Action Button Section -->
                                @include ('common._action', ['CRUD_Action' => 'Update', 'object' => $user, 'resource' => 'users', 'disableMenu' => ['delete'],
                                          'pluginMenus' => [array('url' => 'users/'.$user->id.'/profiles', 'menuicon' => 'fa-cog', 'menulabel' => 'labels.profiles')]])
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {!! Form::model($user, ['method' => 'POST', 'action' => ['UsersController@passwordResetByAdmin', $user->id], 'class' => 'form-horizontal', 'onsubmit' => 'return validateOnSave();']) !!}
                        @include('common.errors')
                        @include('common.flash')

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">@lang('labels.password')</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">
                                @if ($errors->has('password'))
                                    <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">@lang('labels.confirm_password')</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    @lang('labels.change_password')
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="alert alert-info">{{ App\Http\Traits\PasswordsTrait::getPasswordRequirementText() }}</div>
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include ('common._footer', ['CRUD_Action' => 'Update', 'includeStyle' => true, 'includeScript' => true])
@endsection