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
                            <h4 class='breadcrumbs'>My Profile / Edit Teacher</h4>
                    </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                            <div class="col-lg-12 col-md-12">&nbsp;</div>
                            <div class="col-lg-12 col-md-12">
                                        <h4 ><U>Personal profile</U></h4>
                                    </div>
                             
                                <div class="card-header">

                                    <h4 class="card-title">Edit Tutor {{$user->name}}</h4>

                                    

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>

                                        </ul>

                                    </div>

                                </div>

                                <div class="card-content collapse show">

                                    <div class="card-body card-dashboard">

                                        <form method="POST"

                                            action="{{route('admin.v1.tutor.edit-submit',['id'=>$user->id])}}" enctype="multipart/form-data">

                                            @csrf

                                            <!-- <div class="form-group">

                                                <label for="profile_name">Profile Name</label>

                                                <input type="text" name="profile_name" id="profile_name"

                                                    class="form-control" value="{{ $user->teacher_profile['profile_name'] }}">

                                                @if ($errors->has('profile_name'))

                                                    <div class="error text-danger">{{ $errors->first('profile_name') }}

                                                    </div>

                                                @endif

                                            </div> -->

                                            <div class="form-group">

                                                <label for="username">Name</label>

                                                <input type="name" name="name" id="name"

                                                    class="form-control" value="{{ $user->name }}">

                                                @if ($errors->has('name'))

                                                    <div class="error text-danger">{{ $errors->first('name') }}

                                                    </div>

                                                @endif

                                            </div>


                                        <div class="form-group">

                                            <label for="dob">Date OF Birth</label>

                                            <input type="date" name="dob" id="dob" class="form-control" value="{{ old('dob')?old('dob'):$user->dob }}">

                                            @if ($errors->has('dob'))

                                            <div class="error text-danger">{{ $errors->first('dob') }}

                                            </div>

                                            @endif

                                        </div>




                                            <div class="form-group">

                                                <label for="tutor-email">Email</label>

                                                <input type="email" name="email" id="tutor-email"

                                                    class="form-control" value="{{ $user->email }}">

                                                @if ($errors->has('tutor-email'))

                                                    <div class="error text-danger">{{ $errors->first('tutor-email') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <label for="phone">Phone</label>

                                                <input type="phone" name="phone" id="phone"

                                                    class="form-control" value="{{ $user->phone }}">

                                                @if ($errors->has('phone'))

                                                    <div class="error text-danger">{{ $errors->first('phone') }}

                                                    </div>

                                                @endif

                                            </div>



                                            <div class="form-group">

                                            <label for="phone">Gender</label>

                                            <select name="gender" id="gender" class="form-control">

                                            <option value="Male" @if($user->gender == "Male") selected @endif>Male</option>

                                                <option value="Female" @if($user->gender == "Female") selected @endif>Female</option>

                                            </select>



                                            @if ($errors->has('gender'))

                                                <div class="error text-danger">{{ $errors->first('gender') }}

                                                </div>

                                            @endif

                                            </div>



                                            <div class="form-group">

                                            <label for="city">City</label>

                                            <input type="text" name="city" id="city" maxlength="255" value="{{ $user->teacher_profile['city'] }}" class="form-control">

                                            @if ($errors->has('city'))

                                            <div class="error text-danger">{{ $errors->first('city') }}

                                            </div>

                                            @endif

                                            </div>

                                            <div class="form-group">

                                            <label for="country">Country</label>

                                            <input type="text"  name="country" id="country" maxlength="255" value="{{ $user->teacher_profile['country'] }}" class="form-control">

                                            @if ($errors->has('country'))

                                            <div class="error text-danger">{{ $errors->first('country') }}

                                            </div>

                                            @endif

                                            </div>



                                            <div class="form-group">

                                                <label for="location">location</label>

                                                <input type="text" name="location" id="location"

                                                    class="form-control" value="{{ $user->location }}">

                                                @if ($errors->has('location'))

                                                    <div class="error text-danger">{{ $errors->first('location') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <button type="submit" class="btn btn-primary">Submit</button>

                                        </div>
                                        </div>
                                        </div>

                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <br>

                                        

                         <div class="card">

                         <div class="col-lg-12 col-md-12">&nbsp;</div>
                        <div class="col-lg-12 col-md-12">
                            <h4 ><U>Professional profile</U></h4>
                        </div>

                         <div class="card-header">

                        

                        <div class="col-lg-12 col-md-12">&nbsp;</div>
                                            <div class="form-group">

                                            <label for="experence">Experence (in years)</label>

                                            <input type="number" name="experence" id="experence" class="form-control" value="{{ old('experence')?old('experence'):$user->teacher_profile['experence'] }}">

                                            @if ($errors->has('experence'))

                                            <div class="error text-danger">{{ $errors->first('experence') }}

                                            </div>

                                            @endif

                                        </div>

                                           

                                            <div class="form-group">

                                            <label for="tag">Expertise In</label>



                                            <select id="tag" name="tag[]" multiple class="demo-default" class="form-control" placeholder="Select your area of expertise"  value="{{$user->teacher_profile['tag']}}" >

                                                <option value="">Select your area of expertise</option>

                                                @foreach(DB::table('categories')->whereNotNull('parent')->get() as $item)


                                                <option value="{{$item->name}}" {{--@if(isset($user->teacher_profile['tag']) && in_array($item->code,old('teacher_profile')?old('teacher_profile'):json_decode($user->teacher_profile['tag']))) ) selected @endif --}}>{{$item->name}}</option>

                                                @endforeach

                                            </select>

                                            @if ($errors->has('tag'))

                                            <div class="error text-danger">{{ $errors->first('tag') }}

                                            </div>

                                            @endif

                                        </div>






                                        <!-- <div class="form-group">

                                            <label for="area">Select your area of expertise</label>



                                            <select id="area" name="area" class="form-control" placeholder="Select your area of expertise">

                                                <option value="">Select your area of expertise</option>

                                                @foreach(DB::table('currencies')->where('is_active',1)->get() as $item)
                                               
                                              {{-- @php //$teacher = DB::table('teacher_profile')->where('currency', $item->code)->get();  echo $item->currency; @endphp --}}
                                                
                                                <option value="{{$item->code}}"> {{$item->code}} </option>

                                                @endforeach

                                            </select>

                                            @if ($errors->has('area'))

                                            <div class="error text-danger">{{ $errors->first('area') }}

                                            </div>

                                            @endif

                                        </div> -->

                                            <!-- <div class="form-group">

                                                <label for="dob">Date Of Birth</label>

                                                <input type="date" name="dob" id="dob"

                                                    class="form-control" value="{{ $user->dob }}">

                                                @if ($errors->has('dob'))

                                                    <div class="error text-danger">{{ $errors->first('dob') }}

                                                    </div>

                                                @endif

                                            </div> -->

                                            <div class="form-group">

                                                <label for="tutor-password">Change password (Only if required)</label>

                                                <input type="password" name="tutor-password" id="tutor-password"

                                                    class="form-control" value="{{ old('tutor-password') }}">

                                                @if ($errors->has('tutor-password'))

                                                    <div class="error text-danger">

                                                        {{ $errors->first('tutor-password') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                            <label for="banner">Teacher's photo</label>

                                            <input type="file" name="avtars" id="avtars" class="form-control" accept="image/png, image/jpeg" value="{{ old('avtars') }}">

                                            <img src="{{aws_url($user->avtars)}}" width="40" height="40" style="border-radius: 50%" onerror="this.src='/thrill/v1/icon/teacher.png'">

                                            @if ($errors->has('avtars'))

                                            <div class="error text-danger">{{ $errors->first('avtars') }}

                                            </div>

                                            @endif

                                        </div>

                                        <div class="form-group">

                                            <label for="banner">Video Preview</label>

                                            <input type="file" name="intro_video" id="intro_video" accept="video/mp4" class="form-control" value="{{ old('intro_video') }}">

                                            <a href="{{aws_url($user->teacher_profile['intro_video'])}}" target="_blank">click to view</a>

                                            @if ($errors->has('intro_video'))

                                            <div class="error text-danger">{{ $errors->first('intro_video') }}

                                            </div>

                                            @endif

                                        </div>

                                        <div class="form-group">

                                            <label for="intro_text">Introduction</label>

                                            <textarea name="intro_text" id="intro_text" maxlength="255" class="form-control">{{ $user->teacher_profile['intro_text'] }}</textarea>

                                            @if ($errors->has('intro_text'))

                                            <div class="error text-danger">{{ $errors->first('intro_text') }}

                                            </div>

                                            @endif

                                        </div>

                                       

                                        <div class="form-group">

                                            <label for="city">Degree Obtained</label>

                                            <input type="text" name="degree_obtained" id="degree_obtained" maxlength="255" value="{{ $user->teacher_profile['degree_obtained'] }}" class="form-control">

                                            @if ($errors->has('degree_obtained'))

                                            <div class="error text-danger">{{ $errors->first('degree_obtained') }}

                                            </div>

                                            @endif

                                        </div>

                                        <div class="form-group">

                                            <label for="country">Degree From</label>

                                            <input type="text"  name="degree_from" id="degree_from" maxlength="255" value="{{ $user->teacher_profile['degree_from'] }}" class="form-control">

                                            @if ($errors->has('degree_from'))

                                            <div class="error text-danger">{{ $errors->first('degree_from') }}

                                            </div>

                                            @endif

                                        </div><div class="form-group">

                                            <label for="city">Passing Out</label>

                                            <input type="text" name="passing_out" id="passing_out" maxlength="255" value="{{ $user->teacher_profile['passing_out'] }}" class="form-control">

                                            @if ($errors->has('passing_out'))

                                            <div class="error text-danger">{{ $errors->first('passing_out') }}

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

