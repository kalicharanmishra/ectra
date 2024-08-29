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
                                    <h4 class="card-title">Network of Currency:
                                        <strong>{{ $currency->code }}</strong>
                                    </h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        </ul>
                                    </div>

                                    @if (Auth()->user()->role == 2 || $permission->network_add)
                                        <h6 class="mt-2">

                                            <a
                                                href="{{ route('admin.v1.currencies.addNetwork', ['currency_id' => $currency->id]) }}">Add
                                                Network</a>
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
                                                        <th>Network Name</th>
                                                        <th>Min Amount</th>
                                                        <th>Max Amount</th>
                                                        <th>Fee</th>
                                                        <th>Created At</th>
                                                        @if (Auth()->user()->role == 2 || $permission->network_edit)
                                                            <th>Action</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($networks as $network)
                                                        <tr role="row" class="odd">
                                                            <td class="sorting_1">{{ $network->id }}</td>
                                                            <td>{{ $network->network_name }}</td>
                                                            <td>{{ $network->min_amount }}</td>
                                                            <td>{{ $network->max_amount }}</td>
                                                            <td>{{ $network->fee_digit }}</td>
                                                            <td>{{ $network->created_at }}</td>
                                                            @if (Auth()->user()->role == 2 || $permission->network_edit)
                                                                <td>
                                                                    <a href="{{ route('admin.v1.currencies.updateNetwork', ['currency_id' => $network->currency_id, 'network_id' => $network->id]) }}">View/Update</a>
                                                                    <a href="{{ route('admin.v1.currencies.deleteNetworks', ['network_id' => $network->id]) }}">Delete</a>
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
