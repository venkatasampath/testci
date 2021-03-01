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
                            {{ Breadcrumbs::render('users.create') }}Role
                        </div>
                        <div class="col-4"><h4>{{ $heading }}</h4></div>
                        <div class="float-right col-4"> <!-- Action Button Section -->
                            @include ('common._action', ['CRUD_Action' => 'Create', 'object' => \App\User::class, 'resource' => 'users', 'disableMenu' => []])
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(['class' => 'form-horizontal', 'route' => 'users.store', 'onsubmit' => 'return validateOnSave();']) !!}
                    @include('common.errors')
                    @include('common.flash')

                    @include ('users.partial', ['CRUD_Action' => 'Create'])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include ('common._footer', ['CRUD_Action' => 'Create', 'includeStyle' => true, 'includeScript' => true])

    <script>
        $('#phone, #cell_phone').keyup(function(e) {
            if ((this.value.length < 8) && (e.keyCode > 47 && e.keyCode < 58) || (e.keyCode < 106 && e.keyCode > 95)) {
                this.value = this.value.replace(/(\d{3})\-?/g, '$1-');
                return true;
            }
            //remove all chars, except dash and digits
            this.value = this.value.replace(/[^\-0-9]/g, '');
        });

        // Checks Phone is 10 Digits
        function phonenumber(inputtxt) {
            var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
            if(inputtxt.value.match(phoneno)) {
                document.getElementById("phone_errorDiv").style.display = "none";
                return true;
            }
            else {
                document.getElementById("phone_errorDiv").style.display = "block";
                document.getElementById("phone_error").innerHTML = "Please Use  555-555-5555  Format for Phone Numbers";
                return false;
            }
        }
    </script>
@endsection
