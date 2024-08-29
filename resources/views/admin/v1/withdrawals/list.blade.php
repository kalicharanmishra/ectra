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
                                    <h4 class="card-title">Transaction history</h4>
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
                                                        <th>User</th>
                                                        <th>Currency</th>
                                                        <th>Amount</th>
                                                        <th>Transaction ID</th>
                                                        <th>Transaction Status</th>
                                                        <th>Date</th>
                                                        @if (Auth()->user()->role == 2 || $permission->withdrawal_edit)
                                                            <th>Action</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($withdrawals as $withdrawal)
                                                        <tr role="row" class="odd">
                                                            <td class="sorting_1">{{ $withdrawal->id }}</td>
                                                            <td>{{ App\Models\User::find($withdrawal->user_id)->name }}</td>
                                                            <td>{{ $withdrawal->currency }}</td>
                                                            <td>{{ $withdrawal->amount }}</td>
                                                            <td>{{ $withdrawal->transaction_id ?? 'N/A' }}</td>
                                                            <td>{{ $withdrawal->transaction_status }}</td>
                                                            <td>{{ $withdrawal->created_at }}</td>
                                                            @if (Auth()->user()->role == 2 || $permission->withdrawal_edit)
                                                                <td>
                                                                    <a href="{{ route('admin.v1.withdraw.edit', ['id' => $withdrawal->id]) }}"
                                                                        class="btn btn-success btn-sm Block">
                                                                        View/Edit
                                                                    </a>
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
