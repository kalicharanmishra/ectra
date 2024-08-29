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
                            <h4 class='breadcrumbs'>Our Students / Edit Student</h4>

                        </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title">Edit Student</h4>

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

                                            action="{{route('admin.v1.user.edit-submit',['id'=>$user->id])}}" enctype="multipart/form-data">

                                            @csrf

                                           

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

                                                <label for="dob">Date Of Birth</label>

                                                <input type="date" name="dob" id="dob"

                                                    class="form-control" value="{{ $user->dob }}">

                                                @if ($errors->has('dob'))

                                                    <div class="error text-danger">{{ $errors->first('dob') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <label for="tutor-password">password</label>

                                                <input type="password" name="tutor-password" id="tutor-password"

                                                    class="form-control" value="{{ old('tutor-password') }}">

                                                @if ($errors->has('tutor-password'))

                                                    <div class="error text-danger">

                                                        {{ $errors->first('tutor-password') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                            <label for="banner">User Profile Image</label>

                                            <input type="file" name="avtar" id="avtar" class="form-control" accept="image/png, image/jpeg" onChange="img_pathUrl(this,'profile_prev');">

                                            <img src="{{Storage::url($user->avtars)}}" id="profile_prev" width="40" height="40" style="border-radius: 50%" onerror="this.src='/thrill/v1/icon/student.png'">

                                            @if ($errors->has('avtar'))

                                            <div class="error text-danger">{{ $errors->first('avtar') }}

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

