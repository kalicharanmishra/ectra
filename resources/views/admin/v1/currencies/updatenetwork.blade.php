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

                                    <h4 class="card-title">Update Network: {{ $network->network_name }} to Currency:

                                        {{ $currency->code }}</h4>

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>

                                        </ul>

                                    </div>



                                        <h6 class="mt-2">

                                            <a

                                                href="{{ route('admin.v1.currencies.networks', ['currency_id' => $currency->id]) }}">Go

                                                to Network</a>

                                        </h6>

                                </div>

                                <div class="card-content collapse show">

                                    <div class="card-body card-dashboard">

                                        <form method="POST"

                                            action="{{ route('admin.v1.currencies.updateNetworkSubmit', ['currency_id' => $currency->id, 'network_id' => $network->id]) }}">

                                            @csrf

                                            <div class="form-group">

                                                <label for="network_name">Network Name</label>

                                                <input type="text" name="network_name" id="network_name"

                                                    class="form-control" value="{{$network->network_name}}">

                                                @if ($errors->has('network_name'))

                                                    <div class="error text-danger">

                                                        {{ $errors->first('network_name') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <label for="min_amount">Min Amount</label>

                                                <input type="text" name="min_amount" id="min_amount"

                                                    class="form-control" value="{{$network->min_amount}}">

                                                @if ($errors->has('min_amount'))

                                                    <div class="error text-danger">

                                                        {{ $errors->first('min_amount') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <label for="max_amount">Max Amount</label>

                                                <input type="text" name="max_amount" id="max_amount"

                                                    class="form-control" value="{{$network->max_amount}}">

                                                @if ($errors->has('max_amount'))

                                                    <div class="error text-danger">

                                                        {{ $errors->first('max_amount') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <label for="fee_digit">Fee</label>

                                                <input type="text" name="fee_digit" id="fee_digit"

                                                    class="form-control" value="{{$network->fee_digit}}">

                                                @if ($errors->has('fee_digit'))

                                                    <div class="error text-danger">

                                                        {{ $errors->first('fee_digit') }}

                                                    </div>

                                                @endif

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

