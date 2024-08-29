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
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add New circullum</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <form method="POST" action="{{ route('admin.v1.circullum.add-submit') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="circullum-name">Cirricullum title</label>
                                            <input type="text" name="title" id="title" class="form-control" value="{{ $coursecir?$coursecir->title:'' }}" >
                                            @if ($errors->has('title'))
                                            <div class="error text-danger">{{ $errors->first('title') }}
                                            </div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="course">Course Name</label>

                                            <input type="text" name="course" id="course" maxlength="250" class="form-control" value="{{ $course->title }}"  readonly >
                                            @if ($errors->has('course'))
                                            <div class="error text-danger">{{ $errors->first('course') }}
                                            </div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="add circullum">Add Circullum Topic</label>
                                        </div>
                                        <div id="wholediv" >
                                            <div id="wholefun">
                                                <div class="form-group">
                                                    <label for="topic">Topic</label>
                                                    <input type="text" name="topic" id="topic" class="form-control" value="{{ old('topic') }}">
                                                    @if ($errors->has('topic'))
                                                    <div class="error text-danger">{{ $errors->first('topic') }}
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea name="description" id="description" class="form-control" ></textarea>
                                                    @if ($errors->has('description'))
                                                    <div class="error text-danger">{{ $errors->first('description') }}
                                                    </div> 
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="url">Url</label>
                                                    <input type="text" name="url" id="url" class="form-control" value="{{ old('url') }}">
                                                    @if ($errors->has('url'))
                                                    <div class="error text-danger">{{ $errors->first('url') }}
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="complete">Complete</label>
                                                    <select name="complete" class="form-control">
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                    @if ($errors->has('complete'))
                                                    <div class="error text-danger">{{ $errors->first('complete') }}
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="cover_time">Cover Time</label>
                                                    <input type="time" name="cover_time" id="cover_time" class="form-control" value="{{ old('cover_time') }}">
                                                    @if ($errors->has('cover_time'))
                                                    <div class="error text-danger">{{ $errors->first('cover_time') }}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <hr>
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