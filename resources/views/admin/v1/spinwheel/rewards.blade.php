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
                                    <h4 class="card-title">Rewards list</h4>
                                    @if (Auth()->user()->role == 2 || $permission->reward_add)

                                    <a href="{{ route('admin.v1.spinWheel.addReward') }}">Add Spin Rewards</a>
                                    @endif
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
                                                        <th>Amount</th>
                                                        <th>Currency</th>
                                                        <th>Currency symbol</th>
                                                        <th>Probability out of 1000</th>
                                                        <th>Created At</th>
                                                        @if (Auth()->user()->role == 2 || $permission->reward_edit)
                                                            <th>Action</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($rewards as $reward)
                                                        <tr role="row" class="odd">
                                                            <td class="sorting_1">{{ $reward->id }}</td>
                                                            <td>{{ $reward->amount }}</td>
                                                            <td>{{ $reward->currency }}</td>
                                                            <td>{{ $reward->currency_symbol }}</td>
                                                            <td>
                                                                {{ $reward->probability }}%
                                                            </td>
                                                            <td>{{ $reward->created_at }}</td>
                                                            @if (Auth()->user()->role == 2 || $permission->reward_edit)
                                                                <td>
                                                                    <a href="{{ route('admin.v1.spinWheel.editReward', ['id' => $reward->id]) }}"
                                                                        class="btn btn-success btn-sm Block">
                                                                        Edit
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
