<div class="g-rules border-bottom-light mt-40 pb-50">
    <h3 class="text-22 fw-500">{{__("Hotel Rules - Policies")}}</h3>
    <div class="description pt-10">
        <div class="row">
            <div class="col-lg-4">
                <div class="key">{{__("Check In")}}</div>
            </div>
            <div class="col-lg-8">
                <div class="value">	12:00AM </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="key">{{__("Check Out")}}</div>
            </div>
            <div class="col-lg-8">
                <div class="value">	11:00AM </div>
            </div>
        </div>
        @if(isset($row['inst']))
            <div class="row">
                <div class="col-lg-4">
                    <div class="key">{{__("Hotel Policies")}}</div>
                </div>
                <div class="col-lg-8">
                    @foreach($row['inst'] as $key => $item)
                        <div class="item @if($key > 1) d-none @endif">
                            <div class="strong fw-500">{{str_replace('_',' ',$item['type'])}}</div>
                            <div class="context">
                                @foreach (json_decode($item['msg']) as $item)
                                    {!! $item !!}
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    @if( count($row['inst']) > 2)
                        <div class="btn-show-all text-blue-1 fw-500">
                            <span class="text">{{__("Show All")}}</span>
                            <i class="fa fa-caret-down"></i>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
