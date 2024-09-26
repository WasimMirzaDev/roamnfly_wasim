

<div class="row" style="min-height: 250px; height:100%;">
    
    <ul class="nav nav-tabs" id="myTab" role="tablist">
    @foreach($rows as $index => $onward)
        <li class="nav-item" role="presentation">
          <button class="nav-link {{$index == 0 ? 'active' : '' }}" id="home-tab{{$index}}" data-bs-toggle="tab" data-bs-target="#home-tab-pane{{$index}}" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">{{$onward['ONWARD'][0]['sI'][0]['fD']['aI']['name'] .'  Filghts '. count($onward['ONWARD'])}}</button>
        </li>
    @endforeach
      </ul>

      {{-- <div class="col-lg-12 "> --}}



        {{-- @include('Flight::frontend.layouts.return.search.multi-loop-grid',['wrap_class'=>'item-loop-wrap inner-loop-wrap']) --}}

        
    {{-- </div> --}}
   
      <div class="tab-content" id="myTabContent">
        @foreach($rows as $index => $onward)

        <div class="tab-pane fade show {{$index == 0 ? 'active' : '' }}" id="home-tab-pane{{$index}}" role="tabpanel" aria-labelledby="home-tab{{$index}}" tabindex="0">

            <div class="col-lg-12 custom-cards">
                @foreach($onward['ONWARD'] as $row)
                        <div class="col-lg-12">
                            @include('Flight::frontend.layouts.return.search.multi-loop-grid',['wrap_class'=>'item-loop-wrap inner-loop-wrap'])
                        </div>
                @endforeach
                </div>
        </div>
        @endforeach

      </div>


</div>

<div class="bravo-pagination">
    {{$rows->appends(request()->query())->links()}}
    @if($rows->total() > 0)
        <div class="text-center mt-30 md:mt-10">
            <div class="text-14 text-light-1">{{ __("Showing :from - :to of :total flights",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}</div>
        </div>
    @endif
</div>
