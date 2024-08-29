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
                            <h4 class='breadcrumbs'>Our Teachers / Add Teacher</h4>

                 </div>

                    <div class="col-lg-12 col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <h4 class="card-title">Add New Tutor</h4>

                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                <div class="heading-elements">

                                    <ul class="list-inline mb-0">

                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>

                                    </ul>

                                </div>

                            </div>

                            <div class="card-content collapse show">

                                <div class="card-body card-dashboard">

                                    <form method="POST" action="{{ route('admin.v1.tutor.add-submit') }}" enctype="multipart/form-data">

                                        @csrf

                                        <!-- <div class="form-group">

                                            <label for="username">Profile Name</label>

                                            <input type="username" name="profile_name" id="username" class="form-control" value="{{ old('profile_name') }}">

                                            @if ($errors->has('profile_name'))

                                            <div class="error text-danger">{{ $errors->first('profile_name') }}

                                            </div>

                                            @endif

                                        </div> -->

                                        <div class="form-group">

                                            <label for="username">Name</label>

                                            <input type="name" name="name" id="name" class="form-control" value="{{ old('name') }}">

                                            @if ($errors->has('name'))

                                            <div class="error text-danger">{{ $errors->first('name') }}

                                            </div>

                                            @endif

                                        </div>

                                        <div class="form-group">

                                            <label for="email">Email</label>

                                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">

                                            @if ($errors->has('email'))

                                            <div class="error text-danger">{{ $errors->first('email') }}

                                            </div>

                                            @endif

                                        </div>

                                        <div class="form-group">

                                            <label for="phone">Phone</label>

                                            <input type="phone" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">

                                            @if ($errors->has('phone'))

                                            <div class="error text-danger">{{ $errors->first('phone') }}

                                            </div>

                                            @endif

                                        </div>

                                        <div class="form-group">

                                            <label for="dob">Date OF Birth</label>

                                            <input type="date" name="dob" id="dob" class="form-control" value="{{ old('dob') }}">

                                            @if ($errors->has('dob'))

                                            <div class="error text-danger">{{ $errors->first('dob') }}

                                            </div>

                                            @endif

                                        </div>

                                        <div class="form-group">

                                            <label for="experence">Experence (in years)</label>

                                            <input type="number" name="experence" id="experence" class="form-control" value="{{ old('experence') }}">

                                            @if ($errors->has('experence'))

                                            <div class="error text-danger">{{ $errors->first('experence') }}

                                            </div>

                                            @endif

                                        </div>

                                        <div class="form-group">

                                            <label for="phone">Gender</label>

                                            <select name="gender" id="gender" class="form-control">

                                                <option value="Male">Male</option>

                                                <option value="Female">Female</option>

                                            </select>



                                            @if ($errors->has('gender'))

                                            <div class="error text-danger">{{ $errors->first('gender') }}

                                            </div>

                                            @endif

                                        </div>

                                        <div class="form-group">

                                            <label for="tag">Expertise In</label>



                                            <select id="tag" name="tag[]" multiple class="demo-default" class="form-control" placeholder="Select a Expertia..." >

                                                <option value="">Select a expertia</option>

                                                @foreach(DB::table('hash_tags')->where('is_active',1)->get() as $item)

                                                <option value="{{$item->name}}">{{$item->name}}</option>

                                                @endforeach

                                            </select>

                                            @if ($errors->has('tag'))

                                            <div class="error text-danger">{{ $errors->first('tag') }}

                                            </div>

                                            @endif

                                        </div>



                                        <div class="form-group">

                                            <label for="commission">Admin Commission</label>

                                            <input type="number" name="admin_commission" id="admin_commission" class="form-control" value="{{ old('admin_commission') }}">

                                            @if ($errors->has('admin_commission'))

                                            <div class="error text-danger">{{ $errors->first('admin_commission') }}

                                            </div>

                                            @endif

                                        </div>

                                        <div class="form-group">

                                            <label for="password">password</label>

                                            <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}">

                                            @if ($errors->has('password'))

                                            <div class="error text-danger">{{ $errors->first('password') }}

                                            </div>

                                            @endif

                                        </div>

                                        <div class="form-group">

                                            <label for="banner">Teacher Image</label>

                                            <input type="file" name="avtars" id="avtars" class="form-control" accept="image/png, image/jpeg" value="{{ old('avtars') }}">

                                            @if ($errors->has('avtars'))

                                            <div class="error text-danger">{{ $errors->first('avtars') }}

                                            </div>

                                            @endif

                                        </div>

                                        <div class="form-group">

                                            <label for="banner">Short Intro Video</label>

                                            <input type="file" name="intro_video" id="intro_video" class="form-control" accept="video/mp4" value="{{ old('intro_video') }}">

                                            @if ($errors->has('intro_video'))

                                            <div class="error text-danger">{{ $errors->first('intro_video') }}

                                            </div>

                                            @endif

                                        </div>

                                        <div class="form-group">

                                            <label for="intro_text">Short Intro Text</label>

                                            <textarea name="intro_text" id="intro_text" class="form-control" maxlength="255">{{ old('intro_text') }}</textarea>

                                            @if ($errors->has('intro_text'))

                                            <div class="error text-danger">{{ $errors->first('intro_text') }}

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