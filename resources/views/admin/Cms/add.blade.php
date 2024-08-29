@extends('admin.v1.templates.main')

@section('content')

    <div class="app-content content">

        <div class="content-wrapper">

            <div class="content-wrapper-before"></div>

            <div class="content-header row">

            </div>

            <div class="content-body">

                <section id="mulit-column">

                    <div class="row">
                    <div class="col-lg-12 col-md-12">
                            <h4 class='breadcrumbs'>CMS / Add CMS</h4></div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title">CMS Add</h4>

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>

                                        </ul>

                                    </div>

                                </div>

                                <div class="card-content collapse show">

        

                                    <div class="card-body card-dashboard">

                                        <form action="{{ route('admin.v1.cms.add') }}" method="POST">

                                            @csrf

                                            <div class="row">

                                                <div class="col-md-12">

                                                    <div class="form-group">

                                                        <label>Title</label>

                                                        <input type="text" name="title" class="form-control">

                                                         @if ($errors->has('title'))

                                                            <div class="error text-danger">{{ $errors->first('title') }}

                                                            </div>

                                                        @endif

                                                    </div>

                                                </div>

                                                <div class="col-md-12">

                                                    <div class="form-group">

                                                        <label>Slug</label>

                                                        <input type="text" name="slug" class="form-control">

                                                         @if ($errors->has('slug'))

                                                            <div class="error text-danger">{{ $errors->first('slug') }}

                                                            </div>

                                                        @endif

                                                    </div>

                                                </div>

                                                <div class="col-md-12">

                                                    <div class="form-group">

                                                        <label>Description</label>

                                                        <textarea name="description" class="form-control description" id="description" rows="10" cols="50"></textarea>

                                                        @if ($errors->has('description'))

                                                            <div class="error text-danger">{{ $errors->first('description') }}

                                                            </div>

                                                        @endif

                                                    </div>

                                                </div>

                                                <div class="col-md-6">

                                                    <div class="form-group">

                                                        <button class="btn btn-primary">Save</button>

                                                        <a href="{{ route('admin.v1.cms.index') }}"><button type="button"

                                                                class="btn btn-danger">Cancel</button></a>

                                                    </div>

                                                </div>

                                            </div>

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

