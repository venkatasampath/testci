@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".$heading)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="float-left col-4">
                            @if($theUser->isProjectManager($theProject) && !($isAdminOrOrgAdmin))
                            @else
                            {{ Breadcrumbs::render('projects.edit', $project) }}
                            @endif
                        </div>
                        <div class="col-4"><h4>{{ $heading }}</h4></div>
                        <div class="float-right col-4"> <!-- Action Button Section -->
                            @if($theUser->isProjectManager($theProject) && !($isAdminOrOrgAdmin))
                                <div class="float-right col-4"> <!-- Action Button Section -->
                                    <button type="button" class="btn btn-default btn-primary dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        @lang('labels.actions')
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('/projects/'. $project->id ) }}"><i class="fas fa-fw fa-btn fa-undo"></i>@lang('labels.discard_changes')</a></li>
                                    </ul>
                                </div>
                            @else
                            @include ('common._action', ['CRUD_Action' => 'Update', 'object' => $project, 'resource' => 'projects', 'disableMenu' => ['delete'] ])
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    {!! Form::model($project, ['method' => 'PATCH', 'action' => ['ProjectsController@update', $project->id], 'class' => 'form-horizontal', 'onsubmit' => 'return validateOnSave();']) !!}
                    @include('common.errors')
                    @include('common.flash')
                    @include ('projects.partial', ['CRUD_Action' => 'Update'])
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