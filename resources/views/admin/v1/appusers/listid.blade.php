@extends('admin.v1.templates.main')

@section('content')

<style>

      table, td, th {

         border: 1px solid black;

         width: 40%;

         text-align:left;

         vertical-align: center;

      }

   </style>

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

                                            <li><a class="btn btn-light" data-action="expand">Expand</a></li>

                                        </ul>

                                    </div>

                                </div>

                                <div class="card-header">

                                    <h4 class="card-title">

                                    {{ $users->name }}  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  with us since {{ Carbon\Carbon::parse($users->created_at)->format('Y-m-d') }}   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Registration number {{ $users->id }}

                                    </h4>

                                    <br>

                                    <table border=1 >

                                        <tr>

                                                <td style="text-align:center;padding-top:10px;"><h6>Personal Details</h6></td></tr>

                                                <tr><td>

                                                <ul>

                                                    <li><strong>DOB</strong> : {{ $users->dob }}</li>

                                                @php  

                                                    $years = Carbon\Carbon::parse($users->dob)->age;

                                                @endphp 

                                                    <li><strong>Age</strong>  : {{ $years }} Yrs.</li>

                                                    <li><strong>Bio</strong>  : {{ $users->bio }}</li>

                                                    <li><strong>Email-id</strong> : {{ $users->email }}</li>

                                                    <li><strong>Mobile</strong> : {{ $users->phone }}</li>

                                                    <li><strong>Gender</strong> : {{ $users->gender }}</li>

                                                    <li><strong>Address</strong> : {{ $users->location }}</li>

                                                </ul>

                                                </td></tr>

                                    </table>

                                    

                                </div>



                                <div class="card-content collapse show">

                                    <div class="card-body card-dashboard">

                                        <div class="table-responsive">

                                            <!-- modal ends -->

                                            <h4>Registration Details</h4>

                                            <br>

                                            <table class="table table-striped table-bordered file-export">

                                                <thead>

                                                    <tr>

                                                        <th>S.No.</th>

                                                        <th>Avatar</th>

                                                        <th>Name</th>

                                                        <th>Email</th>

                                                        <th>Gender</th>

                                                        <th>Phone</th>

                                                        <th>DOB</th>

                                                        <th>Course Registration Date</th>

                                                        <th>Course Selected</th>

                                                        <th>Teacher </th>

                                                        <th>Fees Paid</th>



                                                      

                                                        <!-- <th>Referred User</th> -->

                                                        

                                                        @if (Auth::user()->can('appuser_block'))

                                                            <th>Action</th>

                                                        @endif



                                                      

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    @foreach ($transaction as $key=>$transactions)

                                                        <tr role="row" class="odd">

                                                            <td class="sorting_1">{{ $key+1 }}</td>

                                                            <td><image src="{{Storage::url($users->avtars)}}" style="border-radius:50%;width:40px;height:40px;" onerror="this.src='/thrill/v1/icon/student.png'"></td>

                                                        

                                                            <td><a href="{{ url('/admin/v1/appuser/list') }}/{{ $users->id }}">{{ $users->name }}</a></td>

                                                            <td>{{ $users->email  }}</td>

                                                            <td>{{ $users->gender }}</td>

                                                            <td>{{ $users->phone ?? 'N/A' }}</td>

                                                            <td>{{ $users->dob }}</td>

                                                            <td>{{ Carbon\Carbon::parse($transactions->created_at)->format('Y-m-d') }}</td>

                                                            <td>

                                                                 {{ $transactions->course->title }}                                                              

                                                            </td>

                                                            <td>

                                                                 {{ $transactions->teacher->name }}  

                                                            </td>

                                                            <td>

                                                            <?php $enroll = App\Models\Course_enroll::where('course_id',$transactions->course_id)->where('user_id',$users->id)->first(); ?>

                                                            @if($enroll)

                                                                Paid

                                                            @else

                                                                Un-Paid

                                                            @endIf

                                                            </td>



                                                            <!-- @if (Auth::user()->can('withdrawal_view'))

                                                                <td>

                                                                    <a

                                                                        href="{{ route('admin.v1.withdraw.list', ['user_id' => $users->id]) }}">

                                                                        Go To Request

                                                                    </a>

                                                                </td>

                                                            @endif -->



                                                            

                                                            <!-- @if (isset($users->user_activity_counters->invite_counter))

                                                                <td>{{ $users->user_activity_counters->invite_counter }}</td>

                                                            @else

                                                                <td>0</td>

                                                            @endif -->



                                                            

                                                            <td style="display: flex;">



                                                                <!-- <a href="{{ route('admin.v1.appuser.view', ['id' => $users->id]) }}"

                                                                    class="btn btn-info btn-sm">

                                                                   <i class="ft-eye"></i>

                                                                </a>

                                                            -->

                                                                @if (Auth::user()->can('appuser_edit'))

                                                                    <a href="{{ route('admin.v1.user.edit', ['id' => $users->id]) }}" class="btn btn-secondary btn-sm Block">

                                                                       Edit

                                                                    </a>

                                                            @endif

                                                                <!-- @if (Auth::user()->can('appuser_block'))

                                                                    <a href="{{ route('admin.v1.appuser.block', ['id' => $users->id, 'action' => $users->status == 'active' ? 'block' : 'unblock']) }}"

                                                                        class="btn {{ $users->status == 'active' ? 'btn-success' : 'btn-danger' }} btn-sm Block">

                                                                        @if ($users->status == 'active')

                                                                         <i class="ft-slash text-warning"></i>

                                                                        @else

                                                                          <i class="ft-check-circle text-success"></i>

                                                                        @endif

                                                                    </a>

                                                                    @endif -->

                                                                   

                                                               

                                                         

                                                          

                                                            {{-- @if (Auth::user()->can('appuser_deactivation'))

                                                               

                                                                    <!-- @if ($users->deactivation_request == 1)

                                                                        <i>New request</i>

                                                                        <a href="{{ route('admin.v1.appuser.block', ['id' => $users->id, 'action' => 'block']) }}"

                                                                            class="btn btn-danger btn-sm Block">

                                                                            @if ($users->status == 'active')

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

                                                            

                                                                    <a href="{{ route('admin.v1.appuser.verify', ['id' => $users->id, 'action' => $users->is_verified == 1 ? 'unverify' : 'verify']) }}"

                                                                        class="btn {{ $users->is_verified == 1 ? 'btn-success' : 'btn-danger' }} btn-sm Block">

                                                                        @if ($users->is_verified == 1)

                                                                            Verified

                                                                        @else

                                                                            Unverified

                                                                        @endif

                                                                    </a>

                                                               

                                                            @endif -->

                                                           @if (Auth::user()->can('appuser_delete'))

                                                              

                                                                    <a onclick="return confirm('Are you sure want to delete this user {{ $users->name }}.?')"

                                                                        href={{ route('admin.v1.appuser.delete', ['id' => $users->id]) }}

                                                                        class="btn btn-danger btn-sm Delete">

                                                                        <!-- <i class="ft-trash-2 text-warning"></i> -->

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

                                <div class="card-content collapse show">

                                    <div class="card-body card-dashboard">

                                        <div class="table-responsive">

                                            <!-- modal ends -->

                                            <h4>Attendence Details</h4>

                                            <br>

                                            <table class="table table-striped table-bordered file-export">

                                                <thead>

                                                    <tr>

                                                        <th>Sr No.</th>

                                                        <th>Course Selected</th>

                                                        <th>Teachers Name</th>

                                                        <th>Total No. of Classes</th>

                                                        <th>Class Dates</th>

                                                        <th>Class Attended</th>

                                                        <th>Class Remaining</th>

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    @foreach ($transaction as $key=>$transactions)

                                                        <tr role="row" class="odd">

                                                            <td class="sorting_1">{{ $key+1 }}</td>

                                                            <td>

                                                                 {{ $transactions->course->title }}                                                              

                                                            </td>

                                                            <td>

                                                                 {{ $transactions->teacher->name }}  

                                                            </td>

                                                            <td>

                                                                 {{ $transactions->Circullum_topic->count() }}  

                                                            </td>

                                                            <td>

                                                                <ol>

                                                                @foreach ($transactions->Circullum_topic as $key=>$circullums)

                                                                   <li> {{ Carbon\Carbon::parse($circullums->created_at)->format('Y-m-d') }} </li>

                                                                @endforeach

                                                            </ol>

                                                            </td>

                                                            <td>

                                                                <ol>

                                                                @foreach ($transactions->Circullum_topic as $key=>$circullums)

                                                                    <li>

                                                                            <?php $attend = App\Models\Attendence::where('circullum_id',$circullums->id)

                                                                        ->where('teacher_id',$transactions->teacher_id)

                                                                        ->where('course_id',$transactions->course_id)

                                                                        ->where('user_id',$users->id)

                                                                        ->first(); ?> 

                                                                        @if($attend)

                                                                                Attended

                                                                                @else

                                                                                Not Attended

                                                                            @endif

                                                                    </li>

                                                                @endforeach

                                                            </ol>

                                                            </td>

                                                            <td>

                                                            <?php 

                                                            $onval = $transactions->Circullum_topic->count();

                                                            $attend = App\Models\Attendence::where('course_id',$transactions->course_id)

                                                                        ->where('user_id',$users->id)

                                                                        ->get();

                                                                   $toval = $attend->count();



                                                                        ?> 

                                                            {{ $onval-$toval }} 

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

