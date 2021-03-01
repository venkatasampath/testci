@php
    $defaultProject = $theUser->getCurrentProject();
    $currentProject = $defaultProject;
    $SEactivity = $currentProject->se_activities_by_user($theUser, 10);
    $DNAactivity = $currentProject->dna_activities_by_user($theUser, 10);
@endphp


{{$SEactivity}}
<div class="col-sm-12">
    <div id="activityFeed">
        <h4 style="margin-top: 10px; border-bottom: 1px  solid #e8ebed; padding: 5px"><b>@lang('labels.user_activity_feed_skel')</b></h4>
        <div class="table-responsive Skeletalactivityfeed-datatable"></div>
        <useractivity :table_data="{{$SEactivity}}"></useractivity>

        <h4 style="margin-top: 10px; border-bottom: 1px solid #e8ebed; padding: 5px"><b>@lang('labels.user_activity_feed_DNA')</b></h4>
        <div class="table-responsive DNAactivityfeed-datatable"></div>
        <useractivity :table_data="{{$DNAactivity}}"></useractivity>
{{--        <datatable v-bind:labels= "['Key', 'Mito Sequence Number', 'Mito Sequence Subgroup', 'Updated At' ]"--}}
{{--                   v-bind:table-object="{{$DNAactivity}}"--}}
{{--                   v-bind:columns="['skeletalElementsKey', 'mito_sequence_number', 'mito_sequence_subgroup', 'updated_at']"--}}
{{--                   v-bind:table="'dna_feed'"--}}
{{--                   --}}{{----}}{{--v-bind:table style="width: 150%"--}}
{{--        ></datatable>--}}
    </div>
</div>

{{--@section('footer')--}}
{{--    @parent--}}
{{--    <script>--}}
{{--        var activityFeed = null;--}}
{{--        new Vue({--}}
{{--            el: '#activityFeed',--}}
{{--            data: {--}}
{{--                message: 'Hello Sachin'--}}
{{--            },--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}
