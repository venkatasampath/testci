@component('mail::message')
# Introduction
{{ trans('messages.dear_user') }}
{{ $notification['shortMessage'] }}

{{ trans('labels.an') }} $notification['an']
{{ trans('labels.provenance1') }} $notification['p1']
{{ trans('labels.provenance2') }} $notification['p2']
{{ trans('labels.starting_designator') }} $notification['de']
{{ trans('messages.created_elements') }}

@component('mail::panel')
    This is the panel content.
@endcomponent

@component('mail::button', ['url' => 'reports/bonegroup/' . $notification['bone_group_id']])
{{ trans('labels.skeletal_elements') }}
@endcomponent

{{ trans('labels.thanks') }}
{{ config('app.name') }}

{{ trans('labels.cora_copyright') }}
@endcomponent
