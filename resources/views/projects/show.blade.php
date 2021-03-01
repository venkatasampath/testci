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
                            {{ Breadcrumbs::render('projects.show', $project) }}
                            @endif
                        </div>
                        <div class="col-4"><h4>{{ $heading }}</h4></div>
                        <div class="float-right col-4">
                            @if($theUser->isProjectManager($theProject) && !($isAdminOrOrgAdmin))
                                <div class="float-right col-4"> <!-- Action Button Section -->
                                    <button type="button" class="btn btn-default btn-primary dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        @lang('labels.actions')
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('/projects/'. $project->id .'/edit') }}"><i class="fas fa-fw fa-btn far fa-edit"></i>@lang('labels.edit')</a></li>
                                        @if($theProject->id == $project->id)
                                        <li><a href="{{ url('/accessions') }}"><i class="fas fa-fw fa-btn fa-list-alt"></i>@lang('labels.accession')</a></li>
                                        @endif
                                    </ul>
                                </div>
                            @else
                                @if ($theProject->id === $project->id)
                                    @include ('common._action', ['CRUD_Action' => 'View', 'object' => $project, 'resource' => 'projects', 'disableMenu' => ['delete'],
                                             'pluginMenus' => [array('url' => '/accessions', 'menuicon' => 'fa-cog', 'menulabel' => 'labels.associate_accessions')] ])
                                @else
                                    @include ('common._action', ['CRUD_Action' => 'View', 'object' => $project, 'resource' => 'projects', 'disableMenu' => ['delete']])
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    {!! Form::model($project, ['class'=>'form-horizontal']) !!}
                    @include ('projects.partial', ['CRUD_Action' => 'View'])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
@include ('common._footer', ['CRUD_Action' => 'View', 'includeStyle' => true, 'includeScript' => true])
@endsection