@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="float-left col-4">
                            {{ Breadcrumbs::render('reports.search') }}
                        </div>
                        <div class="col-4"><h4 style="text-align:center;">{{$heading}}</h4></div>
                    </div>
                </div>
                
                <!-- search inputs form  -->
                <form action='{{ url('reports/searchgo') }}' method='GET' class='form-horizontal' onsubmit="return ">
                    <div class='card-body'>
                        
                        @include('common.errors')
                        @include('common.flash')
                        
                        <div class="card-group" id="accordion">
                            <div class="card">
                                <div class="card-header" style="height: 35px;">
                                    <div class="float-left">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseSE" class="">Element Search<span class="caret"></span></a>
                                    </div>
                                    <div class="float-right">
                                        {!! Form::button('<i class="fas fa-btn fa-list"></i>Generate', ['type' => 'submit', 'class' => 'btn btn-primary','dusk'=>'report-generate']) !!}
                                    </div>
                                </div>
                                
                                <div id="collapseSE" class="card-collapse card-body collapse in">
                                    <div class="col-lg-12 form-group se-search">
                                        
                                        <!-- search input -->
                                        <div class="row" style="height: 40px; margin: 0px;">
                                            <div class="col-lg-12">
                                                <div class="input-group form-group" style="display: flex !important; flex-wrap: nowrap !important;">
                                                    
                                                    <input id='searchstring' type="text" name="searchstring" value="{{ $searchstring }}" 
                                                           class="form-control" aria-label="..." placeholder="Search for Skeletal Element."/>
                                                    {{ Form::hidden('searchby', 'AN', ['id' => 'searchby', 'class' => 'searchby']) }}
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-default dropdown-toggle" 
                                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fas fa-btn fa-search"></i></span>
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-menu-right">
                                                            <li class="searchby AN"><a href="#">By Accession</a></li>
                                                            <li class="searchby P1"><a href="#">By Provenance 1</a></li>
                                                            <li class="searchby P2"><a href="#">By Provenance 2</a></li>
                                                            <li class="searchby DN"><a href="#">By Designator</a></li>
                                                        </ul>
                                                        {{--<label class="control-label">Element</label>--}}
                                                    </div><!-- /btn-group -->
                                                </div><!-- /input-group -->
                                            </div><!-- /.col-lg-6 -->
                                        </div><!-- /.row -->

                                        <br />

                                        <div class="row" style="height: 40px; margin: 0px;">
                                            <div class="col-lg-12">
                                                <div class="form-group">

                                                    <select name='reporttype' id='reporttype' class='form-control' style="height: auto !important;">
                                                        <option value='' selected='selected'>Select report type</option>
                                                        <option value='methods'>Methods</option>
                                                        <option value='measurements'>Measurements</option>
                                                        <option value='dna'>DNA</option>
                                                    </select>

                                                </div><!-- /select form group -->
                                            </div><!-- /col-lg-12 -->
                                        </div><!-- /row -->

                                        <!-- end search inputs -->

                                    </div>
                                </div>
                            </div>
                        </div>
 
                        <!-- Show results -->
                        @if(isset($reporttype) && isset($results) && count($results) > 0)
                            @if($reporttype == 'methods')
                                @include('reports.components.methodresults')
                            @elseif($reporttype == 'measurements')
                                @include('reports.components.measurementresults')
                            @else
                                @include('reports.components.dnaresults')
                            @endif
                        @endif

                    </div>

                </form> <!-- search inputs form  -->
            </div>
        </div>
    </div>
        
</div>
@endsection

@section('footer')

   <!-- <script>

//        $(document).ready(function() {
//            $('table.mav-datatable').on( 'draw.dt', function () {
//                $('tr').tooltip({html: true, placement: 'auto' });
//            } );
//
//            $('tr').tooltip({html: true, placement: 'auto' });
//        } );
    </script>-->

    <style>
        a.dt-button { padding: 5px !important }
        table.mav-datatable-report {margin-top: 25px !important;}
        div.dataTables_wrapper .dataTables_length { float:left !important; text-align:center;  }
        div.dataTables_wrapper .dt-buttons { float:left !important; text-align:center; padding-left: 180px; }
        div.dataTables_wrapper .dataTables_length .form-control{height: auto !important;}
        .table td { border: 0px !important; }
        .tooltip-inner { white-space:pre-wrap; max-width: 400px; }
    </style>

   {{--The cdn.datatables.net SRI where generated by Sachin--}}
   {{--<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css" integrity="sha256-1QhqWkX+/a13PvcHGu1ef6cpzB2fTC1AQSKO1/CNl7o= sha384-+HuqSo2jltxblyQxEWXqMxros/OMTbQj97cQmCg02u0tDBM6ua+n6riJITcaYLZv sha512-sEbniBlNhlkA+FO5+JoHk/FiugGQECr07pQPR4q2tuREh2q4LCdSZ/519yqxt/fGZqwm1GZdHccu6H0SdKohrA==" crossorigin="anonymous">--}}

   {{--<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js" integrity="sha256-JX8A01otZNUwZ/96fg38qJJEqjeDEHUgovDYIhusby4= sha384-6HTzjzs9z4e++DpwUslzHjPEQLurPtfOOr1EENaFoaLY2XTdteWLxIaTdSm+G+Z7 sha512-usceWqMONV4+a/yaBewx8Q9UCdp+7kkyRyKp4fxB0LvKQ7g9gQ1iS6ztYt4eshGeuygBAPIOvKvQsPYVq838Zg==" crossorigin="anonymous"></script>--}}
   {{--<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js" integrity="sha256-nO6twHurwTTWWCM5jC3c5MRWsd1GkOsSFc1SNoFpk6g= sha384-ZbRaugJJbCmrmnyQcZU1fqaWT2VXtHoNIK9EJH63nsc+F+GOnY5pipIUBOKT/Aga sha512-g7r79V2H5EirPopoNeFbLqCxvB3qFOK4bLCY17+X44KrdQhwFOt2UPzLRoThU+zlTw+5ysncnO/z9TYCHAPLmA==" crossorigin="anonymous"></script>--}}

   {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.4/jszip.min.js" integrity="sha256-/1hjUCFxE/1IivzFCHoS/Et2IQ3z79iNnk42PkZeXhA=" crossorigin="anonymous"></script>--}}
   {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.33/pdfmake.min.js" integrity="sha256-g/E4VHjOmUR6XM3rS0ysSAamcAopVJSGDCyj7A/BN3M=" crossorigin="anonymous"></script>--}}
   {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.33/vfs_fonts.js" integrity="sha256-HM47olZz1oQ8keYmS4UQy/EypVZ8gpFenpuNeYQib+g=" crossorigin="anonymous"></script>--}}

   {{--<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js" integrity="sha256-3Q7fE5fiylv3agZcVLKCywHVtuDSHSXKM5YIr/Z0FpM= sha384-MGofXzcROcQ3bZUqtn2mEI8nhXNmKZ9Qq4FcEapwT3JBKUlgVY+ngyYFNXXUgzSS sha512-/JfTyPFuqrC3Kpbg05uMvVGrDzNUal4xOGJZevKKP8ikOIKHJT9Ux+Fu3mGsncRxqVr0krmkblmv8pkMWIvHmA==" crossorigin="anonymous"></script>--}}
   {{--<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js" integrity="sha256-gsf4GD4Wlg76ZDLglWHFgx4B0Q4rviAxS0mOkRsFs94= sha384-6LRoAn1kvkBMPNsHa6Y/6XDwiX/0cU1FHViqG3kokG9eJ3y0xM1rjQNRxprscuX6 sha512-JybXwXemGVGYrz28jIbszgT5QIh0K2xxVAwOU0VUDarDbGWyKODeCRBEBqOR7ObL1pWhDjQorA4lhwYlUHMDOA==" crossorigin="anonymous"></script>--}}


   {{--new datatable cdn files--}}
   <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.bootstrap4.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/1.5.1/css/buttons.bootstrap4.min.css"></script>

   <script>

    function validateInput() {
        if ($(this).hasClass('AN')) {
            $('input.searchby').val('AN');
        } else if ($(this).hasClass('P1')) {
            $('input.searchby').val('P1');
        } else if ($(this).hasClass('P2')) {
            $('input.searchby').val('P2');
        } else if ($(this).hasClass('DN')) {
            $('input.searchby').val('DN');
        } else {
            $('input.searchby').val('AN');
        }

        if($('#reporttype').val() != '' && $('#reporttype').val()!= undefined) {
            return true;
        }

        return false;
    }
        
    var initialshow = '<?php echo $initialshow; ?>';
    var reporttype = '<?php echo $reporttype ?>';
    var searchstring = '<?php echo $searchstring ?>';
    var searchby = '<?php echo $searchby ?>';    
        
    $(document).ready(function($){
        $('table.mav-datatable-report').DataTable( {
            dom: 'lBfrtip',
            lengthChange: true,
            buttons: ['pageLength', 'excel', 'pdf', 'colvis']
        } );

        $('a.dt-button').addClass('fas fa-btn');
        $('a.buttons-pdf').addClass('fa-file-pdf-o');
        $('a.buttons-excel').addClass('fa-file-excel-o');
        $('a.buttons-csv').addClass('fa-file-text-o');
        $('a.buttons-copy').addClass('fa-copy');
        $('a.buttons-print').addClass('fa-print');
        $('a.dt-button > span').each(function() {
            var title = $( this ).text();
            $(this).text(" " + title);
        });
        document.title = 'CoRA Skeletal Elements Report';
        
        if (reporttype != '' && reporttype != undefined) {
            $('select[name="reporttype"]').val(reporttype);
        }

        if (searchstring != '' && searchstring != undefined) {
            $('#searchstring').val(searchstring);
        }

        if (searchby != '' && searchby != undefined) {
            $('input.searchby').val(searchby);
        }   

        if (initialshow != 1) {
            $('a[data-toggle="collapse"]').click();
        }

        $('li.searchby').click(function() {
            if ($(this).hasClass('AN')) {
                $('input.searchby').val('AN');
            } else if ($(this).hasClass('P1')) {
                $('input.searchby').val('P1');
            } else if ($(this).hasClass('P2')) {
                $('input.searchby').val('P2');
            } else if ($(this).hasClass('DN')) {
                $('input.searchby').val('DN');
            } else {
                $('input.searchby').val('AN');
            }
        });
    });

    </script>
@endsection

