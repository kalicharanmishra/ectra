<section class="min ">

    <div class="container">

        @php
            
            if (
                request()
                    ->route()
                    ->getName() == 'front.category'
            ) {
                $category = \App\Models\Categories::where('name', request()->category)->orderBy('indexing', 'ASC')->first();
                $cat_arr = \App\Models\Categories::whereHas('parent_cat_data', function ($q) {
                    $q->where('name', '=', request()->category);
                })
            
                    ->withCount('courses')
                    ->with('childcat')
                    ->orderBy('indexing', 'ASC')
                    ->get()
            
                    ->toArray();
            } else {
                $cat_arr = \App\Models\Categories::where('parent', null)->orWhere('parent',0)
                    ->withCount('courses')
                    ->with('childcat')
                    ->orderBy('indexing', 'ASC')
                    ->get()
                    ->toArray();
            }
            
        @endphp

        <div class="row justify-content-center">

            <div class="col-lg-7 col-md-8">

                <div class="sec-heading center">

                    @if (request()->route()->getName() == 'front.category')
                        <h2>Select your course in <span class="theme-cl">{{ request()->category }}</span></h2>
                        <p>{{ $category->short_description }}</p>
                    @else
                        <h2 class="homepagehd">Select your categories</h2>
                       
                    @endif
                </div>

            </div>

        </div>



        <div class="row justify-content-center">


            @if (!$cat_arr)
                <p class="cat-description">No course found</p>
            @endif


            @foreach ($cat_arr as $category)
                 @if ($category['courses_count'] > 0)
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">



                        <div class="cates_crs_wrip">

                            <a href="{{ route('front.course', ['category' => $category['name']]) }}">

                                <div class="crs_trios">

                                    <div class="crs_cate_icon">



                                        <img style="border-radius: 4px;" class="img-fluid"
                                            src="{{ Storage::url($category['icon']) }}" alt=""
                                            onerror="this.src='thrill/v1/icon/2659360.png'">

                                    </div>

                                    <div class="crs_cate_link"></div>
                                </div>

                                <div class="crs_capt_cat">
                                    <h4>{{ $category['name'] }}</h4>

                                </div>

                            </a>

                        </div>

                    </div>
                @else
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                @if ($category['courses_count'] > 0)
                    @php $coursePath = route('front.course', ['category' => $category['name']]);@endphp
                @else
                    @php $coursePath = route('front.category', ['category' => $category['name']]);@endphp
                @endif


                        <div class="cates_crs_wrip">

                            <a href="{{ route('front.category', ['category' => $category['name']]) }}">
                                <div class="crs_trios">
                                    <div class="crs_cate_icon">

                                        <img style="border-radius: 4px;" class="img-fluid"
                                            src="{{ Storage::url($category['icon']) }}" alt=""
                                            onerror="this.src='thrill/v1/icon/2659360.png'">
                                    </div>
                                </div>

                                <div class="crs_capt_cat">

                                    <h4>{{ $category['name'] }}</h4>

                                    <ul class="cate_description"
                                        @if (count($category['childcat']) >= 1) style="height: 300px" @endif>
                                        @if (request()->route()->getName() == 'front.category')
                                            @foreach ($category['childcat'] as $subcat)
                                                <li> <a
                                                        href="{{ route('front.course', ['category' => $subcat['name']]) }}">{{ $subcat['name'] }}
                                                    </a></li>
                                            @endforeach
                                        @else
                                            @foreach ($category['childcat'] as $subcat)
                                                <li> <a
                                                        href="{{ route('front.category', ['category' => $subcat['name']]) }}">{{ $subcat['name'] }}
                                                    </a></li>
                                            @endforeach
                                        @endif

                                    </ul>

                                </div>

                            </a>

                        </div>

                    </div>
                @endif

            @endforeach

        </div>
    </div>

</section>
