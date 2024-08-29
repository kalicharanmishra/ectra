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
                            <h4 class='breadcrumbs'>Course Classificate / List Course /</h4>
                 </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title">Category list</h4>

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

                                        <li><a class="btn btn-light" href="{{ route('admin.v1.category.add') }}">Add Category</a></li>

                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>

                                        </ul>

                                    </div>

                                </div>



                                <div class="card-content collapse show">

                                    <div class="card-body card-dashboard">

                                        <div class="table-responsive">

                                            <!-- modal ends -->

                                            <table class="table table-striped table-bordered file-export">

                                                <thead>

                                                    <tr>

                                                        <th>S. No.</th>
                                                         <th> Category</th>

                                                        <th>Sub category</th>

                                                        <th>Icon</th>

                                                        <th>Description</th>

                                                       

                                                        <th>Created At</th>

                                                       <th>Action</th>

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    @foreach ($categories as $category)

                                                        <tr role="row" class="odd">

                                                            <td class="sorting_1">{{ $category->id }}</td>
  <td>{{ $category->parent_cat_data ? $category->parent_cat_data['name'] :'' }}</td>
                                                            <td>{{ $category->name }}</td>

                                                            <td><img src="{{Storage::url($category->icon)}}" width="40" height="40" onerror="this.src='/thrill/v1/icon/paint-palette.png'"></td>

                                                            <td>{{ $category->short_description }}</td>

                                                          

                                                            <td>{{ $category->created_at ?? 'N/A' }}</td>

                                                            <td>

                                                            @if (Auth::user()->can('course_view'))

                                                                <a href="{{ route('admin.v1.category.list',['id' => $category->id]) }}" class="btn btn-info btn-sm">

                                                                View Course

                                                                </a>

                                                                @endif

                                                            @if (Auth::user()->can('categories_edit'))

                                                                    <a href={{ route('admin.v1.category.edit', ['id' => $category->id]) }}

                                                                        class="btn btn-danger btn-sm Edit">

                                                                        Edit

                                                                    </a>

                                                                @endif

                                                            @if (auth()->user()->can('categories_delete'))

                                                                    <a onclick="return confirm('Are you sure want to delete this category {{ $category->name }}.?')"

                                                                        href={{ route('admin.v1.category.delete', ['id' => $category->id]) }}

                                                                        class="btn btn-danger btn-sm Delete">

                                                                        <span class="text-warning" >Delete</span>

                                                                    </a>

                                                              

                                                            @endif

                                                            </td>



                                                        </tr>

                                                    @endforeach

                                                </tbody>

                                            </table>

                                        </div>

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

