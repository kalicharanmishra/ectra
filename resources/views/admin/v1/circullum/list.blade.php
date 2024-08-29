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
                            <h4 class='breadcrumbs'> Manage Courses / My Course / Circullum list</h4>
                    </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title">Circullum list</h4>

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

                                            @if(auth()->user()->can('course_add'))

                                        <li><a class="btn btn-light" href="{{ route('admin.v1.circullum.add',['id' => $course->id]) }}">Add </a></li>

                                        @endif

                                            <li><a class="btn btn-light" data-action="expand">Expand</a></li>

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

                                                        <th>ID</th>

                                                        <th>Topic</th>

                                                        <th>Description</th>

                                                        <th>Class Url</th>

                                                        @if(auth()->user()->can('course_add'))

                                                       <th>Action</th>

                                                       @else

                                                       <th>Attendance List</th>

                                                       @endif

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    @if($categories)

                                                    @foreach ($categories->circullum_topic as $key=>$category)

                                                        <tr role="row" class="odd">

                                                            <td class="sorting_1">{{ $key+1 }}</td>

                                                            <td>{{ $category->topic }}</td>

                                                            <td>{{ $category->description }}</td>

                                                            <td>{{ $category->class_url }}</td>

                                                        @if(auth()->user()->can('course_add'))



                                                            <td>

                                                            

                                                                    <a href={{ route('admin.v1.attendence.list', ['id' => $category->id]) }}

                                                                        class="btn btn-light btn-sm Edit">

                                                                        View Attendence 

                                                                    </a>

                                                            

                                                                    <a href={{ route('admin.v1.circullum.edit', ['id' => $category->id]) }}

                                                                        class="btn btn-danger btn-sm Edit">

                                                                        Edit

                                                                    </a>

                                                               

                                                            

                                                                    <a onclick="return confirm('Are you sure want to delete this category {{ $category->title }}.?')"

                                                                        href={{ route('admin.v1.circullum.delete', ['id' => $category->id]) }}

                                                                        class="btn btn-danger btn-sm Delete">

                                                                        <span class="text-warning" >Delete</span>

                                                                    </a>

                                                              

                                                            

                                                            </td>

                                                        @else

                                                            <td>

                                                                    <a href={{ route('admin.v1.attendence.list', ['id' => $category->id]) }}

                                                                        class="btn btn-light btn-sm Edit">

                                                                        View Attendence 

                                                                    </a>

                                                            </td>

                                                        @endif

                                                        </tr>

                                                    @endforeach

                                                    @endif

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

