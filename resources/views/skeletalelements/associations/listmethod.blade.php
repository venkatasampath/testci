@extends('skeletalelements.associations.common')

@section('association-content')
    <div>
        <biological-profile-methods :specimen="{{$skeletalelement}}" method_type="{{$methodType}}"
                                    :contentheader="true" :toolbar="false" :toolbar_crud="false">
        </biological-profile-methods>
    </div>
{{--    @include('skeletalelements.components.method-list')--}}
{{--    @include('skeletalelements.components.method-add')--}}
@endsection

@section('footer')
    <style>
        .fa-trash { color: red; }
    </style>
    <script>
        $(document).ready(function($) {
            $('select#sb, select#side, select#completeness').select2();
            $('select#methods').select2();

            $('table.se-methods').DataTable({
                "paging": false, "searching" : false, "info" : false,
            });
            $('.data-delete').on('click', function (e) {
                if (!confirm('Are you sure you want to delete?')) return;
                e.preventDefault();
                $('#form-delete-' + $(this).data('form')).submit();
            });
            $('a[href="#collapseSEMethods"]').click();
        });
    </script>
@endsection
