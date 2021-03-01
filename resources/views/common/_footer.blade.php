{{--
 * Footer section for Views
 *
 * @category   Footer section for Views
 * @package    Common
 * @author     Sachin Pawaskar - spawaskar@unomaha.edu
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
--}}

<!-- Reusable footer section buttons for views -->
<!-- Parameter passed $CRUD_Action:     string valid values "List", "Create", "View", "Update", "Delete", "Report", "Search"  -->
<!-- Parameter passed $includeStyle:    boolean true or false -->
<!-- Parameter passed $includeScript:   boolean true or false -->
<!-- Parameter passed $docTitle:        string to set the document title for the page, will work only if $includeScript is true -->
<!-- Parameter passed $pageType:        string valid values "Report", "Search" These replaced the values that were being used in the $CRUD_Action -->
<!-- Parameter passed $orderByColumn:   integer that sets the column that a datatable is default ordered by -->
<!-- Parameter passed $sortOrder:            string valid values "asc" or "desc" used for datatable ordering -->
@if(isset($CRUD_Action))
    @if($CRUD_Action === 'List')
        @if ($includeStyle == true)
            <style>
                .table td { border: 0px !important; }
            </style>
        @endif

        @if ($includeScript === true)
            <script>
                $(document).ready(function() {
                    var oTableApi = $('table.mav-datatable').dataTable().api();
                    oTableApi.page.len( {{ Auth::user()->getProfileValue('lines_per_page') }} ).draw();
                });
            </script>
        @endif
    @elseif($CRUD_Action === 'Create')
        @if ($includeStyle === true)
            <style>
                {{-- Place some styles here --}}
            </style>
        @endif

        @if ($includeScript === true)
            <script>
                $(document).ready(function($) {
                    $('mav-select').select2();
                });
            </script>
        @endif
    @elseif($CRUD_Action === 'View')
        @if ($includeStyle === true)
            <style>
                {{-- Place some styles here --}}
            </style>
        @endif

        @if ($includeScript === true)
            <script>
                $(document).ready(function($) {
                    $('mav-select').select2();
                    $('.form-control').prop("disabled", true);
                    $('.form-control-checkbox').prop("disabled", true);
                });
            </script>
        @endif
    @elseif($CRUD_Action === 'Update' || $CRUD_Action === 'Edit')
        @if ($includeStyle === true)
            <style>
                {{-- Place some styles here --}}
            </style>
        @endif

        @if ($includeScript === true)
            <script>
                $(document).ready(function($) {
                    $('mav-select').select2();
                    // $(".mav-tag-select").select2({
                    //     tags: true,
                    //     tokenSeparators: [',', ' ']
                    // });
                    $('input#org_name').prop("disabled", true);
                });
            </script>
        @endif
    @endif
@endif

@if(isset($pageType))
    @if($pageType === 'Report' || $pageType === 'Search' || $pageType === 'List')
        @if ($includeStyle === true)
            {{--<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css"/>--}}
            <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.3/css/buttons.dataTables.min.css" integrity="sha256-Wx2XYCITzlycwmzFTluhvWrVwW1MUv9V6QU/Wg89jRk= sha384-4zgE69bwrfaNYUZPA2TaKwT/mjqMcBEvQmjHf1qkjg3c2JSWfEGflXXz6xXBLGGN sha512-T4oh5/2WL+aFqy1XzpWPYHn0IEarpabo3RIuAXHrJS2P7jzO09xVNtqIFlwO+4fA9UcSqOTToz56nOzAQd5YGA==" crossorigin="anonymous">
            <style>
                a.dt-button { padding: 5px !important }
                div.dataTables_wrapper .dt-buttons { float:left !important; text-align:center;  }
                table.mav-datatable-report { margin-top: 25px !important; }
                .table td { border: 0px !important; }
                .tooltip-inner { white-space: pre-wrap; max-width: 400px; }
                div.accordion-report-search { padding-bottom: 1em; }
            </style>
        @endif

        @if ($includeScript === true)
            {{--<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>--}}
            <script src="https://cdn.datatables.net/buttons/1.5.3/js/dataTables.buttons.min.js" integrity="sha256-tDIbh274s/JfB7pQ890Br0xo7XlgvA9WQtDhHZqVLwE= sha384-CW8iNcfEUmTYdZn/59F+GzfTRVpQlXh55fhOai1P5qdFi2oR1THS5OaTT7APQgWz sha512-pvbGRnYBWMM7y/98tu5RfAHvjvGrrka3X6Zw4W3+meL/K48tV7OIbbtjk4MIis8YWcWYFePIE0UiHVoBlG25XA==" crossorigin="anonymous"></script>
            {{--<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.bootstrap4.min.js"></script>--}}
            <script src="https://cdn.datatables.net/buttons/1.5.3/js/buttons.bootstrap4.min.js" integrity="sha256-no5iDuQguL+foSCva5T0DIkOxlbdCFMDfAHYZiqOSC4= sha384-H75Im0hYf95pyemFnfPSA3ISVz2lFzhujSTwYwoh/gGzYnm6bvRXmOQVvHxRFhZ2 sha512-YTLqvqI0wesW0kWdVnDAXZ/Rtq1TOfXh/PPEut2p3MiorLgtjQwOy/8wV20Uunb1Xb6aoClDwv43d19l8LGYtg==" crossorigin="anonymous"></script>
            {{--<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>--}}
            <script src="https://cdn.datatables.net/buttons/1.5.3/js/buttons.html5.min.js" integrity="sha256-hhbZbzhHDnJhcF6s1UhbVGyh9Hr+0Eauq1FLHjfwKTE= sha384-EzXZHFRG/n4Omd1nQTNbrErjupvcy1TetvtLCAR9wX6U7/CnXYYe8Ea6l6n1KtM5 sha512-j9lmXNcDzJIUen47fR791rCLSZzjpBLV3lepeefLGNChLNB31ZlbxfSALpxK70wwtwxd9MhKTfHsxaU9arVyoQ==" crossorigin="anonymous"></script>
            {{--<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>--}}
            <script src="https://cdn.datatables.net/buttons/1.5.3/js/buttons.print.min.js" integrity="sha256-SVRj6UvNbFiIxKlSysAoQCg2q15h4tX8rsEB1whXSo8= sha384-31DtOFaUFs03XqdNrZC0IU1FdQ8ddeC8LVF+EgXYfKY9R7rsidRwrfrEeFbfHlCB sha512-fBwOD7/5FdnTdcRzhn9hyyWHqX+ap/UmqgNJ51Ha2zjGz4Z5SuS2hJMW9a9xViDE4mYRt/gpPe0hT8YvqwlbHw==" crossorigin="anonymous"></script>
            {{--<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>--}}
            <script src="https://cdn.datatables.net/buttons/1.5.3/js/buttons.colVis.min.js" integrity="sha256-8ttYEikcF74aDLvNOgsVZjCP+IUtgpIcCbnNzdZQUQU= sha384-VHGJBanF5CTco90m3Azk1cbOm42rAlT/sUm2atyizfSMqXnYoYM5fbdkfulfS7d8 sha512-sYxu4XlgUrxIKzOi5cKQ9jQnMon0ff6PsIFhEJTUCSTcRgI7dnLzChPmPaeDPOn2QW1MaNOR0YTZSi8lhGF0DQ==" crossorigin="anonymous"></script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.37/pdfmake.min.js" integrity="sha256-Un+hW/zqIe4A7tNVDTwy5Kalw0dcoE0c7fM9Re4CZe4=" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.37/vfs_fonts.js" integrity="sha256-XLgfpwdUBwR1k46YWTWaJoEiybYsrBVOu44SDoEmYsw=" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js" integrity="sha256-PZ/OvdXxEW1u3nuTAUCSjd4lyaoJ3UJpv/X11x2Gi5c=" crossorigin="anonymous"></script>

            <script>
                $(document).ready(function ($) {
                    let table = null;
                    @if($pageType === 'Report')
                        table = $('table.mav-datatable-report').DataTable({
                            dom: 'Bfrtip',
                            buttons: ['pageLength', 'excel', 'pdf', 'colvis'],
                            // stateSave: true,
                            @if(isset($orderByColumn))
                                order: [[{{$orderByColumn}}, '{{ $sortOrder }}' ]],
                            @endif
                            @if(isset($ordering))
                                ordering: false,
                            @endif
                            @if(isset($autoWidth))
                                autoWidth: false,
                            @endif
                        });
                        // table.buttons().container().appendTo('#dataTables_wrapper .col-md-6:eq(0)');
                        table.columns( '.hidecol' ).visible( false );

                        var oTableApi = $('table.mav-datatable-report').dataTable().api();
                        oTableApi.page.len( {{ Auth::user()->getProfileValue('lines_per_page') }} ).draw();
                    @elseif($pageType === 'Search')
                        table = $('table.mav-datatable-search').DataTable({
                            dom: 'Bfrtip',
                            buttons: ['pageLength', 'excel', 'pdf', 'colvis'],
                            // stateSave: true,
                            @if(isset($orderByColumn))
                                order: [[{{$orderByColumn}}, '{{ $sortOrder }}' ]],
                            @endif
                            @if(isset($ordering))
                                ordering: false,
                            @endif
                            @if(isset($autoWidth))
                                autoWidth: false,
                            @endif
                        });
                        table.columns( '.hidecol' ).visible( false );

                        var oTableApi = $('table.mav-datatable-search').dataTable().api();
                        oTableApi.page.len( {{ Auth::user()->getProfileValue('lines_per_page') }} ).draw();
                    @elseif($pageType === 'List')
                        table = $('table.mav-datatable-list').DataTable({
                            dom: 'Bfrtip',
                            buttons: ['pageLength', 'excel', 'pdf', 'colvis'],
                            // stateSave: true,
                            @if(isset($orderByColumn))
                                order: [[{{$orderByColumn}}, '{{$sortOrder}}' ]],
                            @endif
                            @if(isset($ordering))
                                ordering: false,
                            @endif
                            @if(isset($autoWidth))
                                autoWidth: false,
                            @endif
                        });
                        table.columns( '.hidecol' ).visible( false );

                        var oTableApi = $('table.mav-datatable-list').dataTable().api();
                        oTableApi.page.len( {{ Auth::user()->getProfileValue('lines_per_page') }} ).draw();
                    @endif

                    @if (isset($docTitle))
                        let doctitle = <?php echo json_encode($docTitle); ?>;
                        document.title = doctitle;
                    @endif

                    @if (!$initialshow)
                        $('div#collapseReportSearch').removeClass('show');
                    @endif
                });
            </script>

            <script>
                $(document).ready(function(){
                    var  report_params = $('#report_params_update').hide();
                    $(document).ajaxStart(function() {
                        report_params.show();
                    }).ajaxStop(function() {
                        report_params.hide();
                    });
                })
            </script>

            <script>
                $(document).ready(function() {
                    $("select[name='an_select']").change(function () {
                        var an_select = $(this).val();
                        $.ajax({
                            url: "{{ route('reports.jsonp1array') }}",
                            method: 'POST',
                            data: {an_select: an_select},
                            success: function (data) {
                                var P1_Select = $("select[name='p1_select']");
                                var P1_value = document.getElementById('p1_select').value;
                                P1_Select.empty();
                                P1_Select.append($("<option></option>").attr("value", "").text("{{trans('messages.select_p1')}}"));
                                $.each(data, function (value, key) {
                                    P1_Select.append($("<option></option>").attr("value", key).text(value));
                                });
                                $("select[name='p1_select']").val(P1_value);
                            }
                        });
                        $.ajax({
                            url: "{{ route('reports.jsonp2array') }}",
                            method: 'POST',
                            data: {an_select: an_select},
                            success: function (data) {
                                var P2_Select = $("select[name='p2_select']");
                                var P2_value = document.getElementById('p2_select').value;
                                P2_Select.empty();
                                P2_Select.append($("<option></option>").attr("value", "").text("{{trans('messages.select_p2')}}"));
                                $.each(data, function (value, key) {
                                    P2_Select.append($("<option></option>").attr("value", key).text(value));
                                });
                                $("select[name='p2_select']").val(P2_value);
                            }
                        })
                    });

                    $("select[name='p1_select']").change(function() {
                        var p1_select = $(this).val();
                        var p2_select = document.getElementById("p2_select").value;
                        $.ajax({
                            url: "{{ route('reports.jsonanarray') }}",
                            method: 'POST',
                            data: { p1_select: p1_select, p2_select: p2_select},
                            success: function(data){
                                var AN_Select = $("select[name='an_select']");
                                var AN_value = document.getElementById('an_select').value;
                                AN_Select.empty();
                                AN_Select.append($("<option></option>").attr("value", "").text("{{trans('messages.select_an')}}"));
                                $.each(data, function (value, key) {
                                    AN_Select.append($("<option></option>").attr("value", key).text(value));
                                });
                                $("select[name='an_select']").val(AN_value);
                            }
                        })
                    });

                    $("select[name='p2_select']").change(function() {
                        var p1_select = document.getElementById("p1_select").value;
                        var p2_select = $(this).val();
                        $.ajax({
                            url: "{{ route('reports.jsonanarray') }}",
                            method: 'POST',
                            data: { p1_select: p1_select, p2_select: p2_select},
                            success: function(data){
                                var AN_Select = $("select[name='an_select']");
                                var AN_value = document.getElementById('an_select').value;
                                AN_Select.empty();
                                AN_Select.append($("<option></option>").attr("value", "").text("{{trans('messages.select_an')}}"));
                                $.each(data, function (value, key) {
                                    AN_Select.append($("<option></option>").attr("value", key).text(value));
                                });
                                $("select[name='an_select']").val(AN_value);
                            }
                        })
                    })
                })
            </script>
        @endif
    @endif
@endif
@if(isset($dnaPage))
    <script>
        $(document).ready(function() {
            confidenceChange('mito');
            confidenceChange('austr');
            confidenceChange('ystr');

            $('#mito_results_confidence').change(function() { confidenceChange('mito'); });
            $('#austr_results_confidence').change(function() { confidenceChange('austr'); });
            $('#ystr_results_confidence').change(function() { confidenceChange('ystr'); });
        });

        function confidenceChange($dnaType) {
            switch ($('#' + $dnaType + '_results_confidence').val()) {
                case 'Inconclusive':
                case 'Cancelled':
                    if ($dnaType == 'mito') {
                        document.getElementById($dnaType + '_sequence_number').disabled = true;
                        document.getElementById($dnaType + '_sequence_subgroup').disabled = true;
                        document.getElementById($dnaType + '_sequence_similar').disabled = true;
                        document.getElementById($dnaType + '_match_count').disabled = true;
                        document.getElementById($dnaType + '_total_count').disabled = true;
                        document.getElementById($dnaType + '_base_pairs').disabled = true;
                        document.getElementById($dnaType + '_confirmed_regions').disabled = true;
                        document.getElementById($dnaType + '_polymorphisms').disabled = true;
                        $($dnaType + '_fasta_sequence').disabled = true;
                        document.getElementById($dnaType + '_haplogroup_id').disabled = true;
                        document.getElementById($dnaType + '_mcc_date').disabled = true;
                    } else if ($dnaType == 'austr') {
                        document.getElementById($dnaType + '_sequence_number').disabled = true;
                        document.getElementById($dnaType + '_sequence_subgroup').disabled = true;
                        document.getElementById($dnaType + '_sequence_similar').disabled = true;
                        document.getElementById($dnaType + '_num_loci').disabled = true;
                        document.getElementById($dnaType + '_loci').disabled = true;
                        document.getElementById($dnaType + '_mcc_date').disabled = true;
                    } else {
                        document.getElementById($dnaType + '_sequence_number').disabled = true;
                        document.getElementById($dnaType + '_sequence_similar').disabled = true;
                        document.getElementById($dnaType + '_match_count').disabled = true;
                        document.getElementById($dnaType + '_total_count').disabled = true;
                        document.getElementById($dnaType + '_num_loci').disabled = true;
                        document.getElementById($dnaType + '_loci').disabled = true;
                        document.getElementById($dnaType + '_haplogroup').disabled = true;
                        document.getElementById($dnaType + '_mcc_date').disabled = true;
                    }
                    break;
                case 'Reportable':
                case 'Select Confidence':
                case 'Unable to Assign':
                case null:
                    if ($dnaType == 'mito') {
                        document.getElementById($dnaType + '_sequence_number').disabled = false;
                        document.getElementById($dnaType + '_sequence_subgroup').disabled = false;
                        document.getElementById($dnaType + '_sequence_similar').disabled = false;
                        document.getElementById($dnaType + '_match_count').disabled = false;
                        document.getElementById($dnaType + '_total_count').disabled = false;
                        document.getElementById($dnaType + '_base_pairs').disabled = false;
                        document.getElementById($dnaType + '_confirmed_regions').disabled = false;
                        document.getElementById($dnaType + '_polymorphisms').disabled = false;
                        $($dnaType + '_fasta_sequence').disabled = false;
                        document.getElementById($dnaType + '_haplogroup_id').disabled = false;
                        document.getElementById($dnaType + '_mcc_date').disabled = false;
                    } else if ($dnaType == 'austr') {
                        document.getElementById($dnaType + '_sequence_number').disabled = false;
                        document.getElementById($dnaType + '_sequence_subgroup').disabled = false;
                        document.getElementById($dnaType + '_sequence_similar').disabled = false;
                        document.getElementById($dnaType + '_num_loci').disabled = false;
                        document.getElementById($dnaType + '_loci').disabled = false;
                        document.getElementById($dnaType + '_mcc_date').disabled = false;
                    } else {
                        document.getElementById($dnaType + '_sequence_number').disabled = false;
                        document.getElementById($dnaType + '_sequence_similar').disabled = false;
                        document.getElementById($dnaType + '_match_count').disabled = false;
                        document.getElementById($dnaType + '_total_count').disabled = false;
                        document.getElementById($dnaType + '_num_loci').disabled = false;
                        document.getElementById($dnaType + '_loci').disabled = false;
                        document.getElementById($dnaType + '_haplogroup').disabled = false;
                        document.getElementById($dnaType + '_mcc_date').disabled = false;
                    }
                    break;
            }
        }
        </script>
    @endif