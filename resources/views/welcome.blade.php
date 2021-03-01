@extends('layouts.app')

@section('title', config('app.name', 'CoRA')." ".trans('labels.welcome'))

@section('content')
<v-row align="center" justify="center">
    <v-col cols="12" class="m-0 p-0">
        <contentheader title="{{trans('messages.welcome_to_application', ['appname' => config('app.name', 'CoRA')])}}"></contentheader>

        <v-row justify="center" class="m-1 p-0">
            <v-card :elevation="24" class="m-4">
                <v-card-text>
                    <v-img transition="fab-transition" max-width="500px" src="{{ setting('site.welcome_image') }}"/>
                </v-card-text>
            </v-card>
        </v-row>
        <v-row justify="center" class="m-2 p-2">
            <div class="card-body welcome-message">
                <p>@lang('messages.welcome_application_purpose')</p>
                <p>@lang('messages.welcome_application_documentation', ['appname' => config('app.name', 'CoRA'),
                'doclink' => '<a href="' . setting('site.url_online_help') . '" target="_blank"></i>CoRA Online Help <i class="far fa-btn fa-fw fa-question-circle"></i></a>'])
                </p>
            </div>
        </v-row>
    </v-col>
</v-row>
@endsection

@section('footer')
    <script>
        $(document).ready(function(){
            $('div.welcome-image').slideDown(2000);
        });
    </script>
@endsection
