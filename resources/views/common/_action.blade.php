{{--
 * Action buttons for Views
 *
 * @category   Action for Views
 * @package    Common
 * @author     Sachin Pawaskar - spawaskar@unomaha.edu
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
--}}

{{--
 * Reusable action buttons for views based off view context (CRUD functionality)
 * @params: $CRUD_Action : ['List', 'Create', 'View', 'Update']
 * @params: $resource : The route resource name e.g. 'users', 'roles'
 * @params: $object : The actual instance of the model
 * @params: $disableMenu : ['list', 'create', 'update', 'delete', 'discard']
 * @params: $pluginMenus : []
   eg. 'pluginMenus' => [array('url' => 'users/'.$user->id.'/settings', 'menuicon' => 'fa-cog', 'menulabel' => 'labels.profiles'),
                         array('url' => 'users/'.$user->id.'/settings', 'menuicon' => 'fa-institution', 'menulabel' => 'labels.orgs')]])
--}}

{{--Migrated to bootstrap 4--}}
@if($CRUD_Action == 'List')
    @can('add', $object )
    <div class='float-right'>
        <button dusk="actions-button" type="button" class="btn btn-secondary btn-primary dropdown-toggle"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @lang('labels.actions')
        </button>
        <ul class="dropdown-menu">
            @if (! in_array("list", $disableMenu))
                <li><a dusk="actions-create-menu" href="{{ url('/' . $resource. '/create') }}"><i class="fas fa-fw fa-btn far fa-file"></i>@lang('labels.create')</a></li>
            @endif
        </ul>
    </div>
    @endcan
@else
    <div class='float-right'>
        <button dusk="actions-button" type="button" class="btn btn-default btn-primary dropdown-toggle"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @lang('labels.actions')
        </button>
        <ul class="dropdown-menu">
            @if (! in_array("list", $disableMenu))
                @can('browse', $object)
                    <li><a dusk="actions-all-menu" href="{{ url('/' . $resource) }}"><i class="fas fa-fw fa-btn fa-list-alt"></i>@lang('labels.all')</a></li>
                @endcan
            @endif
            @if($CRUD_Action != 'Create')
                @if (! in_array("create", $disableMenu))
                    @can('add', $object)
                        <li><a dusk="actions-create-menu" href="{{ url('/' . $resource. '/create') }}"><i class="fas fa-fw fa-btn far fa-file"></i>@lang('labels.create')</a></li>
                    @endcan
                @endif
                @if($CRUD_Action == 'Update')
                    @if (! in_array("discard", $disableMenu))
                        @can('read', $object)
                            <li><a dusk="actions-discard-changes-menu" href="{{ url('/' . $resource . '/' . $object->id) }}"><i class="fas fa-fw fa-btn fa-undo"></i>@lang('labels.discard_changes')</a></li>
                        @endcan
                    @endif
                @else
                    @if (! in_array("edit", $disableMenu))
                        @can('edit', $object)
                            <li><a dusk="actions-edit-menu" href="{{ url('/' . $resource . '/' . $object->id . '/edit') }}"><i class="fas fa-fw fa-btn far fa-edit"></i>@lang('labels.edit')</a></li>
                        @endcan
                    @endif
                @endif
                @if (! in_array("delete", $disableMenu))
                    @can('delete', $object)
                        <li>
                            <form class= 'delete-menu' action="{{ url('/' . $resource . '/' . $object->id) }}" method="POST" onsubmit="return deleteConfirm();">
                                {{ csrf_field() }}{{ method_field('DELETE') }}
                                <button dusk="actions-delete-button" type="submit" id="delete" class="actionlink"><i class="fas fa-fw fa-btn far fa-trash-alt"></i>@lang('labels.delete')</button>
                            </form>
                        </li>
                    @endcan
                @endif
            @endif
            @if (! empty($pluginMenus))
                <li class="dropdown-divider"></li>
                @foreach($pluginMenus as $menu)
                    <li><a dusk="actions-plugin-menu" href="{{ url($menu['url']) }}"><i class="fas fa-fw fa-btn {{ $menu['menuicon'] }}"></i>@lang($menu['menulabel'])</a></li>
                @endforeach
            @endif
        </ul>
    </div>
@endif