@extends('admin.v1.templates.main')

@section('content')

    <div class="app-content content">

        <div class="content-wrapper">

            <div class="content-wrapper-before"></div>

            <div class="content-header row">

            </div>

            <!-- Multi-column ordering table -->

            <div class="content-body">

                <section id="multi-column">

                    <div class="row">
                    <div class="col-lg-12 col-md-12">
                            <h4 class='breadcrumbs'>Main Courses / List Main Course / Edit Course</h4>
                 </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title">Edit Course</h4>

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>

                                        </ul>

                                    </div>

                                </div>

                                <div class="card-content collapse show">

                                    <div class="card-body card-dashboard">

                                        <form method="POST" action="{{ route('admin.v1.course.edit',['id'=>$course->id]) }}" enctype="multipart/form-data">

                                            @csrf

                                            <div class="form-group">

                                                <label for="title">Title</label>

                                                <input type="text" name="title" id="title"

                                                    class="form-control" value="{{ old('title')?old('title') : $course->title }}">

                                                @if ($errors->has('title'))

                                                    <div class="error text-danger">{{ $errors->first('title') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <label for="title">Preview video</label>

                                                <input type="file" name="video" id="video" accept="video/mp4"

                                                    class="form-control" value="{{ old('video') }}">

                                                    @if($course->video)

                                                    <a href="{{Storage::url($course->video)}}" target="_blank">click To view</a>

                                                    @endif

                                                @if ($errors->has('video'))

                                                    <div class="error text-danger">{{ $errors->first('video') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <label for="video_thumbnail">Video thumbnail</label>

                                                <input type="file" name="video_thumbnail" id="video_thumbnail" accept="image/png, image/jpeg"

                                                    class="form-control" value="{{ old('video_thumbnail') }}" onChange="img_pathUrl(this,'video_thumbnail_prev');">

                                                    <img src="{{Storage::url($course->video_thumbnail)}}" id="video_thumbnail_prev" width="40" height="40" style="border-radius: 50%" onerror="this.src='/thrill/v1/icon/paint-palette.png'">

                                                @if ($errors->has('video_thumbnail'))

                                                    <div class="error text-danger">{{ $errors->first('video_thumbnail') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <label for="image">Image</label>

                                                <input type="file" name="image" id="image" accept="image/png, image/jpeg"

                                                    class="form-control" value="{{ old('image') }}" onChange="img_pathUrl(this,'img_prev');">

                                                    <img src="{{Storage::url($course->image)}}" width="40" height="40" id="img_prev" style="border-radius: 50%" onerror="this.src='/thrill/v1/icon/paint-palette.png'">

                                                @if ($errors->has('image'))

                                                    <div class="error text-danger">{{ $errors->first('image') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <label for="price_type">Available for</label>

                                                <div class="form-check form-check-inline">

  <input class="form-check-input" type="radio" name="price_type" id="inlineRadio1" value="Free" onclick="showPrice(this)" @if(old('price_type')? old('price_type') == "Free" : $course->price_type == "Free") checked @endif>

  <label class="form-check-label" for="inlineRadio1">Free</label>

</div>

<div class="form-check form-check-inline">

  <input class="form-check-input" type="radio" name="price_type" id="inlineRadio2" value="Paid" onclick="showPrice(this)" @if(old('price_type')? old('price_type') == "Paid" : $course->price_type == "Paid") checked @endif>

  <label class="form-check-label" for="inlineRadio2">Paid</label>

</div>

                                                @if ($errors->has('price_type'))

                                                    <div class="error text-danger">{{ $errors->first('price_type') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group price" @if(old('price_type')? old('price_type') == "Paid" : $course->price_type == "Paid") @else style="display:none;" @endif>

                                                <label for="price">Price</label>

                                                <input type="text" name="price" id="price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"

                                                    class="form-control" value="{{ old('price')? old('price') : $course->price }}">

                                                @if ($errors->has('price'))

                                                    <div class="error text-danger">{{ $errors->first('price') }}

                                                    </div>

                                                @endif

                                            </div>


                                            

                                            <div class="form-group">
                                                <label for="short_desc">Course timing</label>
                                                <div class="input-group clockpicker pull-center" data-placement="left" data-align="top" data-autoclose="true">
                                                    <input type="text" class="form-control" name="timing" value="{{$course->timing}}" placeholder="12:00" require> 
                                                </div>  
                                            </div>


                                            
                                            
                                            <div class="form-group">

                                            <label for="class_h_o">Class held On</label>
                                            <?php $days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday']; ?>
                                            <script>
                                                $(function()
                                                {
                                                $(".js-example-basic-multiple").select2();
                                                });
                                                $(".js-example-basic-multiple-limit").select2(
                                                {
                                                maximumSelectionLength: 2
                                                });
                                            </script>
                                            <select name="class_h_o[]"  class="js-example-basic-multiple demo-default form-control" multiple="multiple" placeholder="Select a day..."  value="{!! old('class_held_on') !!}" >
                                              
                                            @foreach($days as $key => $day)
                                            
                                               <option value="{{ $day }}" @if(str_contains($course->class_held_on, $day)) selected="" @endif>{{ $day }}</option>
                                               {{--  @if( $day,json_decode($course->class_held_on)) selected @endif> {{ $day }}  --}}
                                          @endforeach
                                            
                                                
                                            </select>

                                            @if ($errors->has('class_h_o'))

                                            <div class="error text-danger">{{ $errors->first('class_h_o') }}

                                            </div>

                                            @endif

                                        </div>
  <div class="form-group">

                                                <!-- <label for="appt">Timing </label>

                                                <input type="time" id="appt" name="timing"

                                                    class="form-control" value="{{ old('timing')?old('timing') : $course->timing }}">

                                                @if ($errors->has('timing'))

                                                    <div class="error text-danger">{{ $errors->first('timing') }}

                                                    </div>

                                                @endif -->

                                            </div>

                                            <!-- <div class="form-group">

                                                <label for="start_date">Start Date</label>

                                                <input type="date" name="start_date" id="start_date"

                                                    class="form-control" value="{{ old('start_date')? old('start_date') : $course->start_date }}">

                                                @if ($errors->has('start_date'))

                                                    <div class="error text-danger">{{ $errors->first('start_date') }}

                                                    </div>

                                                @endif

                                            </div> -->

                                            <!-- <div class="form-group">

                                                <label for="is_certification">Certification Available </label>

                                                <div class="form-check form-check-inline">

  <input class="form-check-input" type="hidden" name="is_certification" id="inlineRadio1" value="1" @if(old('is_certification')? old('is_certification') == 1 : $course->is_certification == 1) checked @endif>

  <label class="form-check-label" for="inlineRadio1">Yes</label>

</div>

<div class="form-check form-check-inline">

  <input class="form-check-input" type="hidden" name="is_certification" id="inlineRadio2" value="0" @if(old('is_certification')? old('is_certification') == 0 : $course->is_certification == 0) checked @endif>

  <label class="form-check-label" for="inlineRadio2">No</label>

</div>

                                                @if ($errors->has('is_certification'))

                                                    <div class="error text-danger">{{ $errors->first('is_certification') }}

                                                    </div>

                                                @endif

                                            </div> -->

                                            <div class="form-group">

                                            <label for="tag">Related tag</label>



                                            <select id="tag" name="hashtags[]" multiple class="demo-default" class="form-control" placeholder="Select a tag..."   >

                                                <option value="">Related tag</option>

                                                @foreach(DB::table('hash_tags')->where('is_active',1)->get() as $item)

                                                <option value="{{$item->name}}" @if( in_array($item->name,json_decode($course->hashtags))) ) selected @endif>{{$item->name}}</option>

                                                @endforeach

                                            </select>

                                            @if ($errors->has('hashtags'))

                                            <div class="error text-danger">{{ $errors->first('hashtags') }}

                                            </div>

                                            @endif

                                        </div>

                                           

                                            <div class="form-group">

                                                <label for="dob">Category</label>

                                                <select name="category" class="form-control">

                                                @foreach(\App\Models\Categories::where('parent','!=',null)->with('parent_cat_data')->withCount('childcat')->get() as $item)
                                                @if($item->childcat_count==0)
                                                <option value="{{$item->id}}" @if(old('category')? old('category') :$course->category == $item->id) selected @endif> {{$item->name}} ({{$item->parent_cat_data['name']}}) </option>
@endif
                                                @endforeach

                                                </select>

                                                @if ($errors->has('category'))

                                                    <div class="error text-danger">{{ $errors->first('category') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <label for="dob">Skill level</label>

                                                <select name="skill_level" class="form-control">

                                               

                                                <option value="Beginner" @if(old('skill_level')? old('skill_level') :$course->skill_level == "Beginner") selected @endif @if(old('category') == "Beginner") selected @endif> Beginner </option>

                                                <option value="Intermediate" @if(old('skill_level')? old('skill_level') :$course->skill_level == "Intermediate") selected @endif>Intermediate</option>

                                                <option value="Advanced" @if(old('skill_level')? old('skill_level') :$course->skill_level == "Advanced") selected @endif>Advanced</option>

                                              

                                                </select>

                                                @if ($errors->has('skill_level'))

                                                    <div class="error text-danger">{{ $errors->first('skill_level') }}

                                                    </div>

                                                @endif

                                            </div>




                                            <div class="form-group">
                                                <label for="short_desc">Course duration</label>

                                                <script>
                                                    function chakval(){
                                                            var val = $(".ch").val();
                                                         
                                                            if(val=='day'){
                                                                $('.numb').attr('max', 365); 
                                                                $('.numb').attr('placeholder', 'Select day'); 
                                                            }

                                                           if(val=='month'){
                                                                $('.numb').attr('max', 12); 
                                                                $('.numb').attr('placeholder', 'Select month'); 
                                                            }

                                                            if(val=='year'){
                                                                $('.numb').attr('max', 10); 
                                                                $('.numb').attr('placeholder', 'Select year'); 
                                                            }                                                     
                                                    }
                                                </script>

                                                <select name="cduration" class="form-control ch" onchange="chakval()" require>
                                                    <option value="">Select Duration</option>
                                                    <option value="day">Day</option>
                                                    <option value="month">Month</option>
                                                    <option value="year">Year</option>
                                                </select>

                                                @if ($errors->has('cduration'))
                                                    <div class="error text-danger">{{ $errors->first('cduration') }} </div>
                                                @endif
                                                    <br>
                                                    
                                                <input type="number" name="cdurationval" class="form-control numb" value="{{$course->duration}}">

                                                @if ($errors->has('cdurationval'))
                                                    <div class="error text-danger">{{ $errors->first('cdurationval') }} </div>
                                                @endif
                                            </div>


                                            

                                            <div class="form-group">

                                                <label for="short_desc">Short description</label>

                                               <textarea name="short_desc" class="form-control short_desc" id="short_desc" maxlength="255">{{old('short_desc')? old('short_desc') :$course->short_desc}}</textarea>

                                                @if ($errors->has('short_desc'))

                                                    <div class="error text-danger">{{ $errors->first('short_desc') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <label for="description">Description</label>

                                               <textarea name="description" class="form-control description" id="description">{{old('description')? old('description') :$course->description}}</textarea>

                                                @if ($errors->has('description'))

                                                    <div class="error text-danger">{{ $errors->first('description') }}

                                                    </div>

                                                @endif

                                            </div>





                                            <div class="form-group">

                                                <label for="description">Requirments for the course</label>

                                               <textarea name="course_req_descrip" class="form-control description" id="description2">{{old('course_req_descrip')? old('course_req_descrip') :$course->course_requirment_description}}</textarea>

                                                @if ($errors->has('description'))

                                                    <div class="error text-danger">{{ $errors->first('course_req_descrip') }}

                                                    </div>

                                                @endif

                                            </div>



                                            <button type="submit" class="btn btn-primary">Submit</button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>

            </div>

        </div>

    </div>

@endsection

