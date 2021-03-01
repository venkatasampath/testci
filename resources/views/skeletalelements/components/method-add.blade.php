@if($list_method->count() > 0)
    <form action="{{ url('skeletalelements/'.$skeletalelement->id.'/methods/create') }}" method="GET">
        <div class="col-md-12">
            <div class="col-sm-12 form-group">
                <div class="col-sm-6 col-sm-offset-3" >
                    <!-- Method -->
                    <Method :options="{{$list_method}}" label="Applicable Methods" :specimen_id="{{$skeletalelement->id}}"
                            :base_url="{{json_encode(url('/'))}}"></Method>
                </div>
            </div>
        </div>
    </form>

@else
    @if (!$initialshow)
        <div class="card-body">
            <h4>No {{ $methodType }} method(s) are available for this Bone</h4>
        </div>
    @endif
@endif

