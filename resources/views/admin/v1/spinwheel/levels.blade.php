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
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Level list of Activity:
                                        <strong>{{ $activity->name }}</strong>
                                    </h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        </ul>
                                    </div>
                                    @if (Auth()->user()->role == 2 || $permission->activitylevels_add)
                                        <h6 class="mt-2">
                                            <a href="{{ route('admin.v1.spinWheel.addLevel', ['activity_id' => $activity->id]) }}">Add
                                            Level</a>
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
                                                        <th>ID</th>
                                                        <th>name</th>
                                                        <th>Spin Reward</th>
                                                        @if (Auth()->user()->role == 2 || $permission->activitylevels_edit)
                                                            <th>Conditions</th>
                                                        @endif
                                                        <th>Created At</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($levels as $level)
                                                        <tr role="row" class="odd">
                                                            <td class="sorting_1">{{ $level->id }}</td>
                                                            <td>{{ $level->name }}</td>
                                                            <td>{{ $level->spin_reward }}</td>
                                                            @if (Auth()->user()->role == 2 || $permission->activitylevels_edit)
                                                                <td>
                                                                    <a
                                                                        href="{{ route('admin.v1.spinWheel.updateLevel', ['activity_id' => $level->activity_id, 'level_id' => $level->id]) }}">View/Update
                                                                        Conditions
                                                                    </a>
                                                                </td>
                                                            @endif
                                                            <td>{{ $level->created_at }}</td>
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
