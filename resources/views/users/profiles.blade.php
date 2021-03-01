@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card ">
                <div class="card-header">
                    <div><h4>{{ $heading }}</h4></div>
                </div>

                <div class="card-body">
                    {!! Form::model($user, ['method' => 'post', 'action' => ['UsersController@updateProfiles', $user->id], 'class' => 'form-horizontal', 'onsubmit' => 'return validateOnSave();']) !!}
                    @include('common.errors')
                    @include('common.flash')

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead> <!-- Table Headings -->
                                <th>@lang('labels.name')</th><th>@lang('labels.value')</th><th>@lang('labels.default_value')</th>
                                </thead>
                                <tbody> <!-- Table Body -->
                                @foreach ($the_user_profiles as $current)
                                    <fieldset>
                                    <tr class="user-profiles">
                                        <!-- Profile Name -->
                                        <td style="width: 50%;"><div class="form-group">
                                            <div class="col-lg-10">
                                                <a class="help" data-toggle="tooltip" data-trigger="click" data-html="true" data-title="<strong>Help:</strong> {{ $current->help }}"><i class="far fa-lg fa-question-circle" style="padding-right: 10px; color: #3097D1;"></i></a>
                                                {{ Form::label('userprofiles['.$current->id.'][description]', $current->description, ['id'=>'description']) }}
                                                {{ Form::hidden('userprofiles['.$current->id.'][id]', $current->id, ['id'=>'id']) }}
                                                {{ Form::hidden('userprofiles['.$current->id.'][name]', $current->name, ['id'=>'name']) }}
                                                {{ Form::hidden('userprofiles['.$current->id.'][kind]', $current->kind, ['id'=>'kind']) }}
                                                {{ Form::hidden('userprofiles['.$current->id.'][display_type]', $current->display_type, ['id'=>'display_type']) }}
                                            </div>
                                        </div></td>
                                        <!-- Profile User Value -->
                                        @if ($current->display_type == 'select')
                                        <td><div class="form-group">
                                            <div class="col-lg-10">
                                                @if ($current->kind === 'model')
                                                    {{ Form::select('userprofiles['.$current->id.'][value]', json_decode($user->getProfileDisplayValues($current->name)), $user->getProfileValue($current->name), ['id' => 'value', 'placeholder' => 'Select Option', 'class' => 'mav-select']) }}
                                                @else
                                                    {{ Form::select('userprofiles['.$current->id.'][value]', json_decode($user->getProfileDisplayValues($current->name)), $user->getProfileValue($current->name), ['id' => 'value', 'placeholder' => 'Select Option', 'class' => 'mav-select']) }}
                                                @endif
                                            {{--<div class="col-lg-10">{{ Form::select('userprofiles['.$current->id.'][value]', json_decode($user->getProfileDisplayValues($current->name)), $user->getProfileValue($current->name), ['id' => 'value', 'placeholder' => 'Select Option', 'class' => 'mav-select']) }}</div>--}}
                                            </div>
                                        </div></td>
                                        @elseif ($current->display_type == 'checkbox')
                                        <td class="table-text">
                                        <div class="checkbox" style="position: relative; left: 20px;">
                                            {{ Form::hidden('userprofiles['.$current->id.'][value]', false) }}{{ Form::checkbox('userprofiles['.$current->id.'][value]', true,  $user->getProfileValue($current->name), ['class' => 'form-control-checkbox']) }}
                                        </div>
                                        </td>
                                        @elseif ($current->display_type == 'number')
                                        <td class="table-text">
                                            <div class="number">
                                                {{ Form::number('userprofiles['.$current->id.'][value]', $user->getProfileValue($current->name), ['id' => 'value', 'min' => $user->getProfileValueMin($current->name), 'max' => $user->getProfileValueMax($current->name), 'step' => $user->getProfileValueStep($current->name)]) }}
                                            </div>
                                        </td>
                                        @else
                                        {{--default is "text"--}}
                                        <td class="table-text"><div>
                                            @if ($current->kind === 'url')
                                                {!! Form::url('userprofiles['.$current->id.'][value]', $user->getProfileValue($current->name), ['class' => 'col-md-6 form-control']) !!}
                                            @else
                                                {!! Form::text('userprofiles['.$current->id.'][value]', $user->getProfileValue($current->name), ['class' => 'col-md-6 form-control']) !!}
                                            @endif
                                        </div></td>
                                        @endif
                                        <!-- Profile Default Value -->
                                        <td class="table-text"><div>
                                            {{--{!! Form::text('userprofiles['.$current->id.'][default_value]', $current->default_value, ['class' => 'col-md-6 form-control', 'readonly' => 'readonly']) !!}--}}
                                            {!! Form::text('userprofiles['.$current->id.'][default_value]', $user->getProfileDisplayDefaultValue($current->name), ['class' => 'col-md-6 form-control', 'readonly' => 'readonly']) !!}
                                        </div></td>
                                    </tr>
                                    </fieldset>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-5">
                                    {!! Form::button('<i class="fas fa-btn fa-save"></i>'.trans('labels.save'), ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                                </div>
                            </div>
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
@include ('common._footer', ['CRUD_Action' => 'List', 'includeStyle' => true, 'includeScript' => true])
<style>
    /*a.btn { z-index: 1000; }*/
    .tooltip-inner { white-space:pre-wrap; max-width: 250px; }
    .tooltip { position: fixed; }
    .popover-inner { white-space:pre-wrap; max-width: 250px; }
    .popover { position: fixed; }
</style>
<script>
    $(document).ready(function($) {
        $('a.help').tooltip({html: true, placement: 'auto'});
    });
</script>
@endsection