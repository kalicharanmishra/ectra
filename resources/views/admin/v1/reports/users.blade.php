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
                                    <h4 class="card-title">
                                        Reported Users
                                    </h4>
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
                                                        <th>User Details</th>
                                                        <th>Reporter User Details</th>
                                                        <th>Reason</th>
                                                        <th>Date</th>
                                                        <th>Warning Counter</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($reports as $report)
                                                        <tr role="row" class="odd">
                                                            <td class="sorting_1">{{ $report->id }}</td>
                                                            <td>
                                                                <strong>ID: </strong>{{ $report->user_detail->id }}<br>
                                                                <strong>Username:
                                                                </strong>{{ $report->user_detail->username }}<br>
                                                                <strong>Phone:
                                                                </strong>{{ $report->user_detail->phone }}<br>
                                                                <a target="_blank"
                                                                    href="{{ route('admin.v1.appuser.view', ['id' => $report->user_detail->id]) }}"
                                                                    class="btn btn-info btn-sm">View User Details</a>
                                                            </td>
                                                            <td>
                                                                <strong>ID: </strong>{{ $report->reporter_detail->id }}<br>
                                                                <strong>Username:
                                                                </strong>{{ $report->reporter_detail->username }}<br>
                                                                <strong>Phone:
                                                                </strong>{{ $report->reporter_detail->phone }}<br>
                                                                <a target="_blank"
                                                                    href="{{ route('admin.v1.appuser.view', ['id' => $report->reporter_detail->id]) }}"
                                                                    class="btn btn-info btn-sm">View User Details</a>
                                                            </td>
                                                            <td>
                                                                {{ $report->report_reason }}
                                                            </td>
                                                            <td>
                                                                {{ $report->created_at }}
                                                            </td>
                                                            <td>
                                                                @if (isset($report->warning))
                                                                    {{ $report->warning->warning_counter }}
                                                                @else
                                                                    0
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('admin.report.warn', ['id' => $report->user_detail->id]) }}"
                                                                    class="btn btn-sm btn-info">
                                                                    Warn
                                                                </a>
                                                                <a href="{{ route('admin.report.notify', ['id' => $report->user_detail->id]) }}"
                                                                    class="btn btn-sm btn-danger">
                                                                    Notify User
                                                                </a>
                                                                <a href="{{ route('admin.v1.appuser.block', ['id' => $report->user_detail->id, 'action' => $report->user_detail->status == 'active' ? 'block' : 'unblock']) }}"
                                                                    class="btn {{ $report->user_detail->status == 'active' ? 'btn-success' : 'btn-danger' }} btn-sm Block">
                                                                    @if ($report->user_detail->status == 'active')
                                                                        Block
                                                                    @else
                                                                        Unblock
                                                                    @endif
                                                                </a>
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
