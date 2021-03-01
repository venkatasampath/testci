<!-- Creates the bootstrap modal where the image will appear -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            @if ($showheader)
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Image preview</h4>
            </div>
            @endif

            <div class="modal-body">
                <img src="" id="imagePreview" style="width: 500px; height: 500px;" >
            </div>

            @if ($showfooter)
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            @endif
        </div>
    </div>
</div>

@section('footer')
    @parent
    <script>
    $(document).ready(function($) {
        $("#popImage").on("click", function() {
            // here assign the image to the modal when the user click the image
            $('#imagePreview').attr('src', $('.img-enlarge').attr('src'));
            // imageModal is the id attribute assigned to the bootstrap modal
            $('#imageModal').modal({
                backdrop: true,
                show: true
            })
        });
    });
    </script>
@endsection
