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
                            <h4 class='breadcrumbs'>Settings / Permission</h4>
                 </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title">Role Has Permissions</h4>

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

                                            <li><a class="btn btn-light" href="{{ route('admin.v1.settings.permission.add') }}"><i class="ft-plus"></i></a></li>

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

                                                        <th>ID</th>

                                                        <th>Role</th>

                                                        <th>Permission</th>

                                                        @if (auth()->user()->roles->pluck('name')[0] == "super admin")

                                                            <th>Action</th>

                                                        @endif

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    @foreach ($role_permissions as $item)

                                                 

                                                        <tr role="row" class="odd">

                                                        <td class="sorting_1">{{ $item['id'] }}</td>

                                                            <td>{{ $item['name'] }}</td>

                                                            <td>

                                                                <ul>

                                                                   @foreach($item->permissions as $permission)

                                                                    <li>{{$permission['name']}}</li>

                                                                    @endforeach

                                                                   

                                                                </ul>

                                                            </td>

                                                            @if (auth()->user()->roles->pluck('name')[0] == "super admin")

                                                                <td>

                                                                    <a href="{{ route('admin.v1.settings.permission.edit', ['id' => $item['id']]) }}"

                                                                        class="btn btn-success btn-sm Block">

                                                                        Edit

                                                                    </a>

                                                                    @if($item->id >3)

                                                                    <a href="{{ route('admin.v1.settings.permission.delete', ['id' => $item['id']]) }}"

                                                                        class="btn btn-success btn-sm Block" onclick="return confirm('Are you sure you want to delete this item')">

                                                                        Delete

                                                                    </a>

                                                                    @endif

                                                                </td>

                                                            @endif

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

