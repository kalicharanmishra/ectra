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
                                    <h4 class="card-title">Activity list</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
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
                                                        <th>name</th>
                                                        @if (Auth()->user()->role == 2 || $permission->activitylevels_view)
                                                            <td>Levels</td>
                                                        @endif
                                                        <th>Created At</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($activities as $activity)
                                                        <tr role="row" class="odd">
                                                            <td class="sorting_1">{{ $activity->id }}</td>
                                                            <td>{{ $activity->name }}</td>
                                                            @if (Auth()->user()->role == 2 || $permission->activitylevels_view)
                                                                <td>
                                                                    <a
                                                                        href="{{ route('admin.v1.spinWheel.activitylevels', ['activity_id' => $activity->id]) }}">Go
                                                                        to levels</a>
                                                                </td>
                                                            @endif
                                                            <td>{{ $activity->created_at }}</td>
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
