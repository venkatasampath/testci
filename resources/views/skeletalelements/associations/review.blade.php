@extends('layouts.app')

@section('styles')
<style>
.tabs-left > .nav-tabs {
  border-bottom: 0;
}

.tab-content > .tab-pane,
.pill-content > .pill-pane {
  display: none;
}

.tab-content > .active,
.pill-content > .active {
  display: block;
}

.tabs-left > .nav-tabs > li {
  float: none;
}

.tabs-left > .nav-tabs > li > a {
  min-width: 74px;
  margin-right: 0;
  margin-bottom: 3px;
}

.tabs-left > .nav-tabs {
  float: left;
  margin-right: 19px;
  border-right: 1px solid #ddd;
}

.tabs-left > .nav-tabs > li > a {
  margin-right: -1px;
  -webkit-border-radius: 4px 0 0 4px;
     -moz-border-radius: 4px 0 0 4px;
          border-radius: 4px 0 0 4px;
}

.tabs-left > .nav-tabs > li > a:hover,
.tabs-left > .nav-tabs > li > a:focus {
  border-color: #eeeeee #dddddd #eeeeee #eeeeee;
}

.tabs-left > .nav-tabs .active > a,
.tabs-left > .nav-tabs .active > a:hover,
.tabs-left > .nav-tabs .active > a:focus {
  border-color: #ddd transparent #ddd #ddd;
  *border-right-color: #ffffff;
}
</style>

@endsection


@section('content')
<div class="container-fluid">
    
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                
                <div class="card-header">
                    <div><h4>Review</h4></div>
                </div>
                
                <div class="card-body">
                    <div class="tabbable tabs-left">
                        
				<ul class="nav nav-tabs">
                                    <li class="active"><a href="#biologics" data-toggle="tab">Biological Profile</a></li>
                                    <li><a href="#dna" data-toggle="tab">DNA Profile</a></li>
                                    <li><a href="#taphonomy" data-toggle="tab">Taphonomy</a></li>
                                    <li><a href="#zone" data-toggle="tab">Zones</a></li>
                                    <li><a href='#measure' data-toggle="tab">Measurements</a></li>
                                    <li><a href='#associations' data-toggle="tab">Associations</a></li>
                                    <li><a href='#pathology' data-toggle="tab">Pathology</a></li>
				</ul>
                        
				<div class="tab-content">
                                    <div class="tab-pane active" id="biologics">                
                                        <div class="">
                                                <h1>Biological Profile</h1>
                                                <form class='' method='' id=''>
                                                    {!! csrf_field() !!}
                                                    
                                                </form>
                                        </div>
                                    </div> 
                                    
                                    <div class="tab-pane" id="dna"> 
                                        <div class="">
                                                <h1>DNA Profile</h1>
                                                <form class='' method='' id=''>
                                                    {!! csrf_field() !!}
                                                        
                                                </form>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="taphonomy"> 
                                        <div class="">
                                                <h1>Taphonomy</h1>
                                                
                                                @include ('skeletalelements.components.highlights', $skeletalelement)
                                                
                                                {!! Form::model($skeletalelement, ['class' => 'form-horizontal', 'method' => 'POST', 'action' => ['SkeletalElementsController@associateReviewTaphonomys', $skeletalelement->id]]) !!}
                                                    {{ csrf_field() }}
                                                    <div class="col-lg-12 form-group taphonomys">
                                                        <label class="col-md-4 control-label">Taphonomies</label>
                                                        {!! Form::select('taphonomylist[]', $list_taphonomy, null, ['id' => 'taphonomys', 'class' => 'form-control taphonomys mav-select', 'multiple', 'style' => 'width: 60%; margin-top: 10px;']) !!}
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-6 col-md-offset-5">
                                                            {!! Form::button('<i class="fas fa-btn fa-save"></i>Save', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                                                        </div>
                                                    </div>
                                                {!! Form::close() !!}
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="zone"> 
                                        <div class="">
                                               <h1>Zones</h1>
                                               
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane" id="measure"> 
                                        <div class="">
                                               <h1>Measurements</h1>
                                               <form class='' method='' id=''>
                                                   {!! csrf_field() !!}
                                                        
                                               </form>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane" id="association">
                                        <div class="">
                                               <h1>Associations</h1>
                                               <form class='' method='' id=''>
                                                   {!! csrf_field() !!}
                                                   
                                               </form>
                                        </div>
                                    </div>
                                    
                                    <div class="tab-pane" id="pathology"> 
                                        <div class="">
                                               <h1>Pathology</h1>
                                               <form class='' method='' id=''>
                                                   {!! csrf_field() !!}
                                                   
                                               </form>
                                        </div>
                                    </div>
				</div>
			</div>
			<!-- /tabs -->
                    
                    
                    <div class='col-sm-7 col-md-8'>
                        
                        @yield('review')
                        
                    </div>
                    
                </div><!-- card body -->
                    
            </div><!-- card definition -->
        </div> <!-- column definition  -->
    </div><!-- row -->
</div><!-- container -->

@endsection