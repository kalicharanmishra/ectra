<style>
    .item_inner {
        width: 100%;
        height: 500px;
        position: relative;
    }

    .owl-carousel .owl-item img {
        height: 455px;
        object-fit: contain
    }

    .wd {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color:#FFFBEB;
    }

    .wd h2 {
        background: #a30a0a;
        padding: 5px 15px;
        border-radius: 10px;
        margin-bottom: 0px !important;
    }

    @media screen and (max-width: 767px) {
        .item_inner {
        height: 350px;
    }
        .owl-carousel .owl-item img {
        height: 300px;
        object-fit: contain
    }

        .wd h2 {
            font-size: 18px;
            line-height: 20px;
            margin-bottom: 0px !important;
        }
    }
</style>
<?php

$banners = \App\Models\Banner::whereDate('start_date', '<=', \Carbon\Carbon::now())

    ->whereDate('end_date', '>=', \Carbon\Carbon::now())

    ->where('section', Request::is('/') ? 'home-main' : '')

    ->get()
    ->toArray();

?>





@if (Request::is('/') && count($banners) == 0)
    <div class="hero_banner image-cover image_bottom"
        style="background: url(https://themezhub.net/skillup-live/skillup/assets/img/banner-3.jpg) no-repeat;"
        data-overlay="5">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-xl-6 col-lg-7 col-md-8 col-sm-12">

                    <div class="simple-search-wrap text-left">

                        <div class="hero_search-2">

                            <div class="elsio_tag">LISTEN TO OUR NEW ANTHEM</div>

                            <h3 class="banner_title mb-4" style="font-size: 20px;">Talent is something you’re born with,
                                skills have to be developed.
                                And in life, you can achieve success only through skills.</h3>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@else
    <div>
        <div class="owl-carousel">
            @foreach ($banners as $key => $item)
                <div class="item">
                    <div class="item_inner">

                        <img src="{{ url('/uploads/banners') }}/{{ $item['image'] }}" alt="">
                        <div class="wd">
                            <h2 style=" color: #fff">{{ $item['banner_text'] }}</h2>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endif


<script>
    $(document).ready(function() {
        $(".owl-carousel").owlCarousel({
            items: 1,
            loop: true,
            autoplay: true, 
            autoplayTimeout: 9000,
            dots: false

        });
    });
</script>
