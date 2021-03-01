{{--
 * Flash Message Partial
 *
 * @category   Flash Message Section for Views
 * @package    Common
 * @author     Sachin Pawaskar - spawaskar@unomaha.edu
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
--}}

@if(Session::has('flash_message'))
    <snackbar snackbar snackbar_text="{{ Session::get('flash_message') }}"></snackbar>

    {{-- <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div> --}}
@endif

@if(Session::has('alert_message'))
    <snackbar snackbar snackbar_text="{{ Session::get('alert_message') }}"></snackbar>
    {{-- <div class="alert alert-danger">
        {{ Session::get('alert_message') }}
    </div> --}}
@endif

@if (session('status'))
    <snackbar snackbar snackbar_text="{{ Session::get('status') }}"></snackbar>

    {{-- <div class="alert alert-success">
        {{ session('status') }}
    </div> --}}
@endif

@if (session('error'))
    <snackbar snackbar snackbar_text="{{ Session::get('error') }}"></snackbar>

    {{-- <div class="alert alert-danger">
        {{ session('error') }}
    </div> --}}
@endif

@if (session('success'))
    <snackbar snackbar snackbar_text="{{ Session::get('success') }}"></snackbar>

    {{-- <div class="alert alert-success">
        {{ session('success') }}
    </div> --}}
@endif

@if (session('warn'))
    <snackbar snackbar snackbar_text="{{ Session::get('warn') }}"></snackbar>

    {{-- <div class="alert alert-warning">
        {{ session('warn') }}
    </div> --}}
@endif

@if (session('info'))
    <snackbar snackbar snackbar_text="{{ Session::get('info') }}"></snackbar>

    {{-- <div class="alert alert-info">
        {{ session('info') }}
    </div> --}}
@endif

@if (session('message'))
    <snackbar snackbar snackbar_text="{{ Session::get('message') }}"></snackbar>

    {{-- <div class="alert alert-info">
        {{ session('message') }}
    </div> --}}
@endif

