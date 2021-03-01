<div class="col-md-6 col-md-offset-3">
    <p class="text">@lang('messages.dear_user')</p>
    <p class="text">{{ $notification->data['shortMessage'] }}, created {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</p>
    <p class="text">{{ $notification->data['longMessage'] }}</p>
    <div class="form-group">
        <div class="col-md-12 p-2 border" style="margin-bottom: 2rem">
            <p class="text p-2"><b>@lang('labels.actions')</b></p>
            <div class="col-md-12 p-0" style="margin-bottom: 2rem">
                @if($theProject->id === $notification->data['payload']['project_id'])
                    <a href="{{ url('skeletalelements/'.$notification->data['payload']['id']) }}" class="btn btn-primary" target="_blank"><i class="fas fa-btn fa-eye"></i>@lang('labels.view_model', ['model'=>'Specimen'])</a>
                @else
                    <span class="btn btn-warning disabled"><i class="fas fa-btn fa-exclamation-triangle"></i>Specimen not in current project.</span>
                @endif
                <a href="{{ url('/users/'.$theUser->id.'/notifications') }}" class="btn btn-primary"><i class="fas fa-btn fa-bell"></i>@lang('labels.back_to_notifications')</a>
            </div>
        </div>
    </div>
    <p class="text">@lang('labels.thanks')<br>@lang('labels.cora_team')</p>
    <div class="bg-light">
        <p class="content">@lang('labels.cora_copyright')</p>
    </div>
</div>
