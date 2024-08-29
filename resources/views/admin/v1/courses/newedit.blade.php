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
                            <h4 class='breadcrumbs'>Main Courses / List Main Course / New Class</h4>
                    </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title">New Class</h4>

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>

                                        </ul>

                                    </div>

                                </div>

                                <div class="card-content collapse show">

                                    <div class="card-body card-dashboard">

                                        <form method="POST" action="{{ route('admin.v1.course.newedit')}}" enctype="multipart/form-data">

                                            @csrf
                                            
                                            <input type="hidden" name="course_id" value="{{ $id }}">

                                            <div class="form-group">

                                                <label for="title">Course Name</label>

                                                <input type="title" name="course_nam" id="title"

                                                    class="form-control" value="{{ old('course_nam') }}">

                                                @if ($errors->has('course_nam'))

                                                    <div class="error text-danger">{{ $errors->first('course_nam') }}
                                                    </div>
                                                @endif

                                            </div>
                                            

                                            <div class="form-group price" >

                                                <label for="time">time</label>

                                                <!-- <input type="text" name="time" id="time" class="form-control" value="{{ old('time') }}"> -->
                                                <input type="time" name="time" id="time" class="form-control" value="12:00">

                                                @if ($errors->has('time'))

                                                    <div class="error text-danger">{{ $errors->first('time') }}

                                                    </div>

                                                @endif

                                            </div>



                                            <div class="form-group price">

                                                <label for="Ur_l">Url</label>
                                                <input type="text" name="Ur_l" id="Ur_l"
                                                    class="form-control" value="{{ old('Ur_l') }}">
                                                @if ($errors->has('Ur_l'))

                                                    <div class="error text-danger">{{ $errors->first('Ur_l') }}
                                                    </div>

                                                @endif

                                            </div>
                                            

                                            <div class="form-group">

                                                <label for="start_date">Start Date</label>

                                                <input type="date" name="start_date" id="start_date"

                                                    class="form-control" value="{{ old('start_date') }}">

                                                @if ($errors->has('start_date'))

                                                    <div class="error text-danger">{{ $errors->first('start_date') }}

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