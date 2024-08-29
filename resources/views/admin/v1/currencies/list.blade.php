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
                                    <h4 class="card-title">Currency list</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        </ul>
                                    </div>
                                    @if (Auth()->user()->role == 2 || $permission->currency_add)
                                        <h6 class="mt-2"><a href="{{ route('admin.v1.currencies.add') }}">Create
                                                Currency</a>
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
                                                        <th>Code</th>
                                                        <th>Symbol</th>
                                                        <th>Image</th>
                                                        @if (Auth()->user()->role == 2 || $permission->network_view)
                                                            <th>Networks</th>
                                                        @endif
                                                        @if (Auth()->user()->role == 2 || $permission->currency_delete)
                                                            <th>Action</th>
                                                        @endif
                                                        {{-- @if (Auth()->user()->role == 2 || $permission->currency_delete)
                                                            <th>Delete Account</th>
                                                        @endif --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($currency as $curr)
                                                        <tr role="row" class="odd">
                                                            <td class="sorting_1">{{ $curr->id }}</td>
                                                            <td>{{ $curr->code }}</td>
                                                            <td>{{ $curr->symbol }}</td>
                                                            <td>
                                                                <a target="_blank"
                                                                    href="{{ asset('uploads/currency/' . $curr->image) }}">
                                                                    {{ $curr->image }}
                                                                </a>
                                                            </td>
                                                            @if (Auth()->user()->role == 2 || $permission->network_view)
                                                                <td>
                                                                    <a
                                                                        href="{{ route('admin.v1.currencies.networks', ['currency_id' => $curr->id]) }}">Go
                                                                        to Networks</a>
                                                                </td>
                                                            @endif
                                                            @if (Auth()->user()->role == 2 || $permission->currency_delete)
                                                                <td>
                                                                    @php
                                                                        $status = $curr->is_active == 1 ? 'Deactivate' : 'Activate';
                                                                        $alert_class = $curr->is_active == 1 ? 'danger' : 'success';
                                                                        $is_active = $curr->is_active == 1 ? 0 : 1;
                                                                    @endphp
                                                                    <a onclick="return confirm('Are you sure want to this.')"
                                                                        href={{ route('admin.v1.currencies.status', ['id' => $curr->id, 'status' => $is_active]) }}
                                                                        class="btn btn-{{ $alert_class }} btn-sm Delete">
                                                                        {{ $status }}
                                                                    </a>
                                                                </td>
                                                            @endif
                                                            {{-- @if (Auth()->user()->role == 2 || $permission->currency_delete)
                                                                <td>
                                                                    <a onclick="return confirm('Are you sure want to delete this Currency {{ $curr->name }}.?')"
                                                                        href={{ route('admin.v1.currencies.delete', ['id' => $curr->id]) }}
                                                                        class="btn btn-danger btn-sm Delete">
                                                                        Delete
                                                                    </a>
                                                                </td>
                                                            @endif --}}
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
