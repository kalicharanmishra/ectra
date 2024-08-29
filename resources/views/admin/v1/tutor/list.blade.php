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
                            <h4 class='breadcrumbs'>Our Teachers /</h4>

                        </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <!-- <h4 class="card-title">Tutor list</h4> -->

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

                                        <li><a class="btn btn-light" href="{{ route('admin.v1.tutor.add') }}">Add Teacher</a></li>

                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>

                                        </ul>

                                    </div>

                                    @if (!Auth::user()->can('tutor_add'))

                                    <h6 class="mt-2"><a href="{{ route('admin.v1.tutor.add') }}">Create tutor</a>

                                    </h6>

                                    @endif

                                </div>



                                <div class="card-content collapse show">

                                    <div class="card-body card-dashboard">

                                        <div class="table-responsive">

                                            <!-- modal ends -->

                                            <table class="table table-striped table-bordered file-export">

                                                <thead>

                                                    <tr>

                                                        <th>S.No</th>

                                                        <th>Name</th>

                                                        <th>Avatar</th>

                                                        <th>Mobile No.</th>

                                                     

                                                        <th>Email</th>

                                                        <th>Gender</th>

                                                        <th>DOB</th>

                                                        <th>Date Of Registration</th>

                                                        <th>Course Listed</th>

                                                        <th>Qualification</th>

                                                        <th>Teaching Since Year</th>

                                                        <th>Teaching Experience</th>

                                                        <th>Earnings From</th>

                                                        <th>Action</th>

                                                   

                                                      

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    @foreach ($users as $key=>$user)

                                                        <tr role="row" class="odd">

                                                            <td class="sorting_1">{{ $key+1 }}</td>

                                                            <td><a href="{{ url('admin/v1/tutor/list') }}/{{ $user->id  }}"> {{ $user->name }}</a></td>

                                                            <td><image src="{{aws_url($user->avtars)}}" style="width:40px;height:40px;border-radius:50%" onerror="this.src='/thrill/v1/icon/teacher.png'"></td>

                                                           

                                                            <td>{{ $user->phone }}</td>

                                                            <td>{{ $user->email  }}</td>

                                                            <td>{{ $user->gender }}</td>

                                                            <td>{{ $user->dob }}</td>

                                                            

                                                        <td>{{ Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}</td>

                                                        <td>

                                                            {{ $user->courses->count() }}</td>

                                                        <td>
                                                            @if(json_decode(@$user->teacher_profile['tag']))
                                                            @foreach(json_decode(@$user->teacher_profile['tag']) as $key_hashtags=>$item)

                                                            {{$item}} ,

                                                            @endforeach
                                                            @endif
                                                        </td>

                                                        <td>@if(@$user->teacher_profile['experence'])
                                                            {{  Carbon\Carbon::now()->subYears(@$user->teacher_profile['experence'])->format('Y')  }}
                                                        @endif </td>

                                                        <td>{{@$user->teacher_profile['experence']}} Year</td>

                                                        <td>

                                                            {{ @$user->transactions->sum('price') }}

                                                        </td>



                                                            {{-- {{ route('admin.v1.tutor.view', ['id' => $user->id]) }} --}}

                                                            <td>

                                                            @if (Auth::user()->can('course_view'))

                                                                <a href="{{ route('admin.v1.tutor.list',['id' => $user->id]) }}" class="btn btn-info btn-sm">

                                                                View

                                                                </a>

                                                                @endif

                                                                @if (Auth::user()->can('tutor_edit'))

                                                                    <a href={{ route('admin.v1.tutor.edit', ['id' => $user->id]) }}

                                                                        class="btn btn-danger btn-sm Edit">

                                                                        Edit

                                                                    </a>

                                                                @endif

                                                            <!-- @if (Auth::user()->can('tutor_edit') ||  Auth::user()->can('tutor_block'))

                                                          

                                                                @if (Auth::user()->can('tutor_block'))

                                                                    <a href="{{ route('admin.v1.tutor.block', ['id' => $user->id, 'action' => $user->status == 'active' ? 'block' : 'unblock']) }}"

                                                                        class="btn {{ $user->status == 'active' ? 'btn-success' : 'btn-danger' }} btn-sm Block">

                                                                        @if ($user->status == 'active')

                                                                        <i class="ft-slash text-warning"></i>

                                                                        @else

                                                                        <i class="ft-check-circle text-success"></i>

                                                                        @endif

                                                                    </a>

                                                                @endif

                                                                                                       

                                                            @endif -->



                                                            @if (Auth::user()->can('tutor_delete'))

                                                               

                                                                    <a onclick="return confirm('Are you sure want to delete this user {{ $user->name }}.?')"

                                                                        href={{ route('admin.v1.tutor.delete', ['id' => $user->id]) }}

                                                                        class="btn btn-danger btn-sm Delete">

                                                                        <span class="text-warning">Delete</span>

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





{{-- ALTER TABLE `permissions` CHANGE `view_videos` `video_view` TINYINT(1) NOT NULL DEFAULT '0', CHANGE `delete_videos` `video_delete` TINYINT(1) NOT NULL DEFAULT '0', CHANGE `view_user` `appuser_view` TINYINT(1) NOT NULL DEFAULT '0', CHANGE `delete_user` `appuser_delete` TINYINT(1) NOT NULL DEFAULT '0', CHANGE `block_user` `appuser_block` TINYINT(1) NOT NULL DEFAULT '0', CHANGE `view_comment` `comments_view` TINYINT(1) NOT NULL DEFAULT '0', CHANGE `delete_comment` `comments_delete` TINYINT(1) NOT NULL DEFAULT '0';



resources\views\admin\v1\tutor\access.blade.php

app\Http\Controllers\Admin\V1\tutorsController.php

app\Models\Permission.php --}}

