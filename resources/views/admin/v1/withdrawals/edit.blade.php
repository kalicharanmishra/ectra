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
                                    <h4 class="card-title">Edit Request</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <form method="POST"
                                            action="{{ route('admin.v1.withdraw.editSubmit', ['id' => $withdrawal->id]) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="user">User</label>
                                                <input type="text" disabled id="user" class="form-control"
                                                    value="{{ $withdrawal->user_id }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="currency">currency</label>
                                                <input type="text" disabled id="currency" class="form-control"
                                                    value="{{ $withdrawal->currency }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="payment_address_user">payment_address_user</label>
                                                <input type="text" disabled id="payment_address_user"
                                                    class="form-control" value="{{ $withdrawal->payment_address_user }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="payment_network_user">payment_network_user</label>
                                                <input type="text" disabled id="payment_network_user"
                                                    class="form-control" value="{{ $withdrawal->payment_network_user }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="commission_fee_amount">commission_fee_amount</label>
                                                <input type="text" disabled id="commission_fee_amount"
                                                    class="form-control" value="{{ $withdrawal->commission_fee_amount }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="amount">amount</label>
                                                <input type="text" disabled id="amount" class="form-control"
                                                    value="{{ $withdrawal->amount }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="transaction_status">transaction_status</label>
                                                @if ($withdrawal->transaction_status == 'Completed')
                                                    <select type="text" id="transaction_status" class="form-control"
                                                        disabled>
                                                        <option selected>Completed</option>
                                                    </select>
                                                @else
                                                    <select type="text" name="transaction_status" id="transaction_status"
                                                        class="form-control">
                                                        <option value="Pending"
                                                            {{ $withdrawal->transaction_status == 'Pending' ? 'selected' : '' }}>
                                                            Pending</option>
                                                        <option value="Cancelled"
                                                            {{ $withdrawal->transaction_status == 'Cancelled' ? 'selected' : '' }}>
                                                            Cancelled</option>
                                                        <option value="Completed"
                                                            {{ $withdrawal->transaction_status == 'Completed' ? 'selected' : '' }}>
                                                            Completed</option>
                                                    </select>
                                                @endif
                                                @if ($errors->has('transaction_status'))
                                                    <div class="error text-danger">
                                                        {{ $errors->first('transaction_status') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="transaction_id">transaction_id / Cancellation Reason</label>
                                                @if ($withdrawal->transaction_status == 'Completed')
                                                <input type="text" id="transaction_id"
                                                    class="form-control" value="{{ $withdrawal->transaction_id }}" disabled>
                                                @else
                                                <input type="text" name="transaction_id" id="transaction_id"
                                                    class="form-control" value="{{ $withdrawal->transaction_id }}">
                                                @endif
                                                
                                                @if ($errors->has('transaction_id'))
                                                    <div class="error text-danger">
                                                        {{ $errors->first('transaction_id') }}
                                                    </div>
                                                @endif
                                                <i>Note: Give reason in case of cancellation here.</i>
                                            </div>


                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
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
