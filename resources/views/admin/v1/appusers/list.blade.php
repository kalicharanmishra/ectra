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
                            <h4 class='breadcrumbs'>Our Students / </h4>

                        </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title">

                                        @if (Route::is('admin.v1.appuser.list'))

                                        Students list

                                        @endif

                                        @if (Route::is('admin.v1.appuser.referred_user'))

                                            Referred User list

                                        @endif

                                    </h4>

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

                                        @if (auth()->user()->can('add_user'))

                                        <li><a class="btn btn-light" href="{{ route('admin.v1.user.add') }}">Add Student</a></li>

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

                                                        <th>S.No.</th>

                                                        <th>Avatar</th>

                                                        <th>Name</th>                                                                                                              

                                                        <th>DOB</th>

                                                        <th>Age</th> 

                                                        <th>Phone</th> 

                                                        <th>Email</th>

                                                        <th>Gender</th>

                                                        <th>Registration Date</th>

                                                        <th>Course Selected</th>

                                                        <th>Teacher </th>

                                                        <th>Fees Paid</th>

                                                        <th>Paid On</th>



                                                      

                                                        <!-- <th>Referred User</th> -->

                                                        

                                                        @if (Auth::user()->can('appuser_block'))

                                                            <th>Action</th>

                                                        @endif



                                                      

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    @foreach ($users as $key=>$user)

                                                        <tr role="row" class="odd">

                                                            <td class="sorting_1">{{ $key+1 }}</td>

                                                            <td><image src="{{Storage::url($user->avtars)}}" style="border-radius:50%;width:40px;height:40px;" onerror="this.src='/thrill/v1/icon/student.png'"></td>

                                                        

                                                            <td><a href="{{ url('/admin/v1/appuser/list') }}/{{ $user->id }}">{{ $user->name }}</a></td>

                                                            <td>{{ $user->dob }}</td>

                                                            <td>{{ Carbon\Carbon::parse($user->dob)->age }}</td>

                                                            <td>{{ $user->phone ?? 'N/A' }}</td>

                                                            <td>{{ $user->email  }}</td>

                                                            <td>{{ $user->gender }}</td>

                                                            <td>{{ Carbon\Carbon::parse($user->created_at)->format('Y-m-d') }}</td>

                                                            <td>

                                                                <ol>

                                                                @foreach($user->coursesenroll as $usercourse)

                                                                 <?php $coursename = App\Models\Course::where('id',$usercourse->course_id)->first(); ?>

                                                                 <li>{{ $coursename->slug?$coursename->slug:'' }} </li>

                                                               

                                                                @endforeach

</ol>

                                                                



                                                            </td>

                                                            <td>

                                                                <ol>

                                                                @foreach($user->coursesenroll as $usercourse)

                                                                 <?php $coursename = App\Models\Course::where('id',$usercourse->course_id)->first(); ?>

                                                                <li>{{ $coursename->course_owner->name?$coursename->course_owner->name:'' }} </li>

                                                               

                                                                @endforeach

</ol>

                                                            </td>

                                                            <td>

                                                                <ol>@foreach($user->coursesenroll as $usercourse)

                                                                <?php $coursename = App\Models\Course::where('id',$usercourse->course_id)->first(); ?>

                                                                <li>{{ $coursename->price?$coursename->price:'' }} </li>

                                                               

                                                                @endforeach</ol></td>



                                                                <td><ol>@foreach($user->coursesenroll as $usercourse)

                                                                 <?php $coursename = App\Models\Transaction::where('course_id',$usercourse->course_id)->where('subscriber_id',$user->id)->first(); ?>

                                                                    <li>{{ $coursename?->created_at }}</li>

                                                               

                                                                @endforeach</ol></td>



                                                            <!-- @if (Auth::user()->can('withdrawal_view'))

                                                                <td>

                                                                    <a

                                                                        href="{{ route('admin.v1.withdraw.list', ['user_id' => $user->id]) }}">

                                                                        Go To Request

                                                                    </a>

                                                                </td>

                                                            @endif -->



                                                            

                                                            <!-- @if (isset($user->user_activity_counters->invite_counter))

                                                                <td>{{ $user->user_activity_counters->invite_counter }}</td>

                                                            @else

                                                                <td>0</td>

                                                            @endif -->



                                                            

                                                            <td style="display: flex;">



                                                                <a href="{{ url('/admin/v1/appuser/list') }}/{{ $user->id }}"

                                                                    class="btn btn-info btn-sm">

                                                                   View

                                                                </a>

                                                           

                                                                @if (Auth::user()->can('appuser_edit'))

                                                                    <a href="{{ route('admin.v1.user.edit', ['id' => $user->id]) }}" class="btn btn-secondary btn-sm Block">

                                                                       Modify

                                                                    </a>

                                                            @endif

                                                                <!-- @if (Auth::user()->can('appuser_block'))

                                                                    <a href="{{ route('admin.v1.appuser.block', ['id' => $user->id, 'action' => $user->status == 'active' ? 'block' : 'unblock']) }}"

                                                                        class="btn {{ $user->status == 'active' ? 'btn-success' : 'btn-danger' }} btn-sm Block">

                                                                        @if ($user->status == 'active')

                                                                         <i class="ft-slash text-warning"></i>

                                                                        @else

                                                                          <i class="ft-check-circle text-success"></i>

                                                                        @endif

                                                                    </a>

                                                                    @endif -->

                                                                   

                                                               

                                                         

                                                          

                                                            {{-- @if (Auth::user()->can('appuser_deactivation'))

                                                               

                                                                    <!-- @if ($user->deactivation_request == 1)

                                                                        <i>New request</i>

                                                                        <a href="{{ route('admin.v1.appuser.block', ['id' => $user->id, 'action' => 'block']) }}"

                                                                            class="btn btn-danger btn-sm Block">

                                                                            @if ($user->status == 'active')

                                                                                Approve

                                                                            @else

                                                                                Approved

                                                                            @endif

                                                                        </a>

                                                                    @else

                                                                        <i>No request</i>

                                                                    @endif -->

                                                                

                                                            @endif --}}

                                                            <!-- @if (Auth::user()->can('appuser_varify'))

                                                            

                                                                    <a href="{{ route('admin.v1.appuser.verify', ['id' => $user->id, 'action' => $user->is_verified == 1 ? 'unverify' : 'verify']) }}"

                                                                        class="btn {{ $user->is_verified == 1 ? 'btn-success' : 'btn-danger' }} btn-sm Block">

                                                                        @if ($user->is_verified == 1)

                                                                            Verified

                                                                        @else

                                                                            Unverified

                                                                        @endif

                                                                    </a>

                                                               

                                                            @endif -->

                                                           @if (Auth::user()->can('appuser_delete'))

                                                              

                                                                    <a onclick="return confirm('Are you sure want to delete this user {{ $user->name }}.?')"

                                                                        href={{ route('admin.v1.appuser.delete', ['id' => $user->id]) }}

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

