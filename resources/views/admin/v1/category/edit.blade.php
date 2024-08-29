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
                            <h4 class='breadcrumbs'>Course Classificate / List Course / Edit Category</h4>
                 </div>

                    <div class="col-lg-12 col-md-12">

                        <div class="card">

                            <div class="card-header">

                                <h4 class="card-title">Edit Category</h4>

                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                <div class="heading-elements">

                                    <ul class="list-inline mb-0">

                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>

                                    </ul>

                                </div>

                            </div>

                        

                            <div class="card-content collapse show">

                                <div class="card-body card-dashboard">

                                    <form method="POST" action="{{ route('admin.v1.category.edit-submit',['id'=>$categories->id]) }}" enctype="multipart/form-data">

                                        @csrf

                                        <div class="form-group">

                                            <label for="name">Name</label>

                                            <input type="text" name="name" id="name" class="form-control" value="{{ $categories->name }}">

                                            @if ($errors->has('name'))

                                            <div class="error text-danger">{{ $errors->first('name') }}

                                            </div>

                                            @endif

                                        </div>

                                        <div class="form-group">

                                            <label for="description">Short Description</label>

                                            <textarea name="short_description" id="description1" maxlength="250" class="form-control">{{ $categories->short_description }}</textarea>

                                            @if ($errors->has('short_description'))

                                            <div class="error text-danger">{{ $errors->first('short_description') }}

                                            </div>

                                            @endif

                                        </div>

                                        <div class="form-group">

                                            <label for="banner">Banner</label>

                                            <input type="file" name="icon" id="icon" class="form-control" value="{{ old('icon') }}">

                                            <img src="{{$categories->icon}}" width="40" height="40" style="border-radius: 50%" onerror="this.src='/thrill/v1/icon/paint-palette.png'">

                                            @if ($errors->has('icon'))

                                            <div class="error text-danger">{{ $errors->first('icon') }}

                                            </div>

                                            @endif

                                        </div>



                                        <div class="form-group">

                                            <div class="form-check form-switch">

                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" name="isparent" id="isparent" onclick="showcategory(this)" @if($categories->parent) checked @endif>

                                                <label class="form-check-label" for="flexSwitchCheckChecked">Select if chield category</label>

                                            </div>

                                        </div>

                                        <div class="form-group catlist" @if($categories->parent) @else style="display:none;" @endif>

                                            <label for="category-name"> Category</label>

                                            <select name="parent" class="form-control">

                                                <option value=""> select  Category</option>

                                               {{-- @foreach(DB::table('categories')->where('parent',null)->get() as $item)--}}
                                                @foreach(DB::table('categories')->get() as $item)

                                                <option value="{{$item->id}}" @if($categories->parent == $item->id) selected @endif> {{$item->name}} </option>

                                                @endforeach

                                            </select>

                                            @if ($errors->has('parent'))

                                            <div class="error text-danger">{{ $errors->first('parent') }}

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