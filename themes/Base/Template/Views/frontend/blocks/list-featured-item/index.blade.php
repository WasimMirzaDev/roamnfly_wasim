@if($list_item)
    <div class="bravo-featured-item {{$style ?? ''}}" style="    margin-top: 100px;
    margin-bottom: 66px;">
        <div class="container">
            <div class="row">
                @foreach($list_item as $k=>$item)
                    <?php $image_url = get_file_url($item['icon_image'], 'full') ?>
                    <div class="col-md-4">
                        <center style="    margin-bottom: 20px;">
                        <div class="featured-item">
                            <div class="image">
                                @if(!empty($style) and $style == 'style2')
                                    <span class="number-circle">{{$k+1}}</span>
                                @else
                                @php
                                $imagePath = [
                                    0 => asset('/images/Good.svg'),
                                    1 => asset('/images/worldGlobal.svg'),
                                    2 => asset('/images/24HourService.svg'),
                                ];
                                
                                $selectedImage = $imagePath[$k] ?? asset('/images/default.svg'); // Default image fallback
                                @endphp
                                
                                <img src="{{ $selectedImage }}" class="img-fluid" alt="{{ $item['title'] }}">
                                
                                @endif
                            </div>
                            <div class="content">
                                <h3 class="title text-black">
                                    {{$item['title']}}
                                </h3>
                                <div class="desc text-black">{!! clean($item['sub_title']) !!}</div>
                            </div>
                        </div>
                    </center>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
