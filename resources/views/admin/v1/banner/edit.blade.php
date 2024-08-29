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
                            <h4 class='breadcrumbs'>Banner / Edit Banner</h4>
                 </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title">Edit Banner</h4>

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

                                            <li><a class="btn btn-light" data-action="expand">Expand</a></li>

                                        </ul>

                                    </div>

                                </div>

                                <div class="card-content collapse show">

                                    <div class="card-body card-dashboard">

                                        <form method="POST" accept="{{ route('admin.v1.banner.editSubmit',['id' => $banner->id]) }}"

                                            enctype="multipart/form-data">

                                            @csrf

                                            <div class="form-group">

                                                <label for="image">image</label>

                                                <i>Dimension: 375X172</i>

                                                <input type="file" name="image" id="image" class="form-control">

                                                {{$banner->image}}

                                                @if ($errors->has('image'))

                                                    <div class="error text-danger">{{ $errors->first('image') }}

                                                    </div>

                                                @endif

                                               

                                            </div>

                                            <div class="form-group">

                                                <label for="banner_text">Banner Text</label>

                                               

                                                <input type="text" name="banner_text" id="banner_text" class="form-control" value="{{ $banner->banner_text }}">

                                                @if ($errors->has('banner_text'))

                                                    <div class="error text-danger">{{ $errors->first('banner_text') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <label for="start_date">Starting Date</label>

                                               

                                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{Carbon\Carbon::parse($banner->start_date)->format('Y-m-s')}}">

                                                @if ($errors->has('start_date'))

                                                    <div class="error text-danger">{{ $errors->first('start_date') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <label for="end_date">End Date</label>

                                               

                                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{Carbon\Carbon::parse($banner->end_date)->format('Y-m-s')}}">

                                                @if ($errors->has('end_date'))

                                                    <div class="error text-danger">{{ $errors->first('end_date') }}

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

