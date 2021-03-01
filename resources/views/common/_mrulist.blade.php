{{--
 * MRUList section for Views
 *
 * @category   MRUList for Views
 * @package    Common
 * @author     Sachin Pawaskar - spawaskar@unomaha.edu
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
--}}

@php
$show_MRU_menu = false;
if (isset($theUser)) {
    $defaultProjectID = $theUser->getProfileValue('default_project');
    $defaultProject = $theUser->projects->find($defaultProjectID);
    if (Auth::user()->getProfileJsonValuesCount($profile) && Auth::user()->getProfileValue($profile) != 0) {
        foreach(Auth::user()->getProfileJsonValuesArray($profile) as $current) {
            if ($current['project_id'] == $defaultProject->id) {
                $show_MRU_menu = true;
                break;
            }
        }
    }
}
@endphp

@if ($show_MRU_menu)
    <li class="dropdown-submenu">
        <a tabindex="-1" href="#"><i class="fas fa-btn fa-fw fa-list-ol"></i>@lang('labels.'.$menu)</a>
        <ul class="dropdown-menu">
            @foreach(Auth::user()->getProfileJsonValuesArray($profile) as $current)
                @if ($current['project_id'] == $defaultProject->id)
                    <li><a href="{{ url('/'.$resource.'/'.$current['id'].'/edit') }}"><i class="fas fa-btn fa-fw {{ $menuicon }}"></i>{{$current['name']}}</a></li>
                @endif
            @endforeach
        </ul>
    </li>
@endif
