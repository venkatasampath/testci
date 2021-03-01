@extends('skeletalelements.associations.common')

@section('association-content')
    @include('skeletalelements.components.methods')
    @include('skeletalelements.components.add-methods')
@endsection

@section('footer')
    @parent
    <script>
        $(document).ready(function($) {
            $('select#sb, select#side, select#completeness').select2();
            $('select#methods').select2();

            $('table.se-methods').DataTable({
                "paging": false, "searching" : false, "info" : false,
            });
            $('a[href="#collapseSEMethods"]').click();
        });
    </script>
@endsection
