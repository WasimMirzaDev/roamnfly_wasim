<style>

    .footer_one{
        .footer-center-content{
                    & a{
                        &:hover{
                        color: orange !important;
                    }
                    }
        }
    }
</style>
<div class="footer_one pt-60 pb-60">
    <div class="row y-gap-40 justify-between xl:justify-start text-white">
        @if($list_widget_footers = setting_item_with_lang("list_widget_footer"))
            <?php $list_widget_footers = json_decode($list_widget_footers); ?>
            @foreach($list_widget_footers as $key=>$item)
                <div class="col-xl-2 col-lg-3 col-sm-6 footer-center-content" @if($key == 1) style="margin-right:450px;" @endif>
                    <h5 class="text-16 fw-500 mb-30">{{ $item->title }}</h5>
                    {!! $item->content  !!}
                </div>
            @endforeach
        @endif
    </div>
</div>
