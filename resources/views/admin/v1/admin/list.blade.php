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
                            <h4 class='breadcrumbs'>Our Team /</h4>

                 </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title">

                                        Admin List

                                    </h4>

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

                                        @if (auth()->user()->can('add_admin'))

                                        <li><a class="btn btn-light" href="{{ route('admin.v1.admin.add') }}">Add</a></li>

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

                                                        <th>Name</th>

                                                        <th>Phone</th>

                                                        <th>Email</th>

                                                        <th>Role</th>



                                                      

                                                       

                                                        

                                                        @if (Auth::user()->can('admin_block'))

                                                            <th>Action</th>

                                                        @endif



                                                     

                                                      

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    @foreach ($users as $user)

                                                        <tr role="row" class="odd">

                                                            <td class="sorting_1">{{ $user->id }}</td>

                                                            <td>{{ $user->name }}</td>

                                                         

                                                            <td>{{ $user->phone ?? 'N/A' }}</td>

                                                            <td>{{ $user->email  }}</td>

                                                            <td>{{ $user->roles[0]['name'] }}</td>

                                                           

                                                            <td>

                                                                  <!-- @if (Auth::user()->can('admin_block'))

                                                               <a href="{{ route('admin.v1.admin.block', ['id' => $user->id, 'action' => $user->status == 'active' ? 'block' : 'unblock']) }}"

                                                                        class="btn {{ $user->status == 'active' ? 'btn-success' : 'btn-danger' }} btn-sm Block">

                                                                        @if ($user->status == 'active')

                                                                        <i class="ft-slash text-warning"></i>

                                                                        @else

                                                                        <i class="ft-check-circle text-success"></i>

                                                                        @endif

                                                                    </a>

                                                            @endif -->

                                                            @if (Auth::user()->can('admin_edit'))

                                                                    <a href="{{ route('admin.v1.admin.edit', ['id' => $user->id]) }}" class="btn btn-secondary btn-sm Block">

                                                                       Edit

                                                                    </a>

                                                            @endif

                                                           

                                                          @if (Auth::user()->can('admin_delete'))

                                                                    <a onclick="return confirm('Are you sure want to delete this user {{ $user->name }}.?')"

                                                                        href={{ route('admin.v1.admin.delete', ['id' => $user->id]) }}

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

