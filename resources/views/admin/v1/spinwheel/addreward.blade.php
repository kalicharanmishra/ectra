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
                                    <h4 class="card-title">Add SpinWheel Reward</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        </ul>
                                    </div>
                                    @if (Auth()->user()->role == 2 || $permission->reward_view)
                                        <h6 class="mt-2">
                                            <a class="menu-item" href="{{ route('admin.v1.spinWheel.rewards') }}">View
                                                Rewards</a>
                                        </h6>
                                    @endif
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">

                                        <form method="POST" action="{{ route('admin.v1.spinWheel.addRewardSubmit') }}">
                                            @csrf
                                            <!-- Amount -->
                                            <div class="form-group">
                                                <label for="amount">Amount</label>
                                                <input type="text" name="amount" id="amount" class="form-control">
                                                @if ($errors->has('amount'))
                                                    <div class="error text-danger">{{ $errors->first('amount') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <!-- Currency code -->
                                            <div class="form-group">
                                                <label for="currency">Currency Code</label>
                                                <select name="currency" id="currency" class="form-control">
                                                    @if (!empty($currencies))
                                                        @foreach ($currencies as $currency)
                                                            <option value="{{ $currency->code }}">{{ $currency->code }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if ($errors->has('currency'))
                                                    <div class="error text-danger">{{ $errors->first('currency') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <!-- Currency Symbol -->
                                            {{-- <div class="form-group">
                                                <label for="currency_symbol">Currency symbol</label>                                                
                                                <select name="currency_symbol" id="currency_symbol" class="form-control">
                                                    @if (!empty($currencies))
                                                        @foreach ($currencies as $currency)
                                                            <option @if ($currency->code == $SpinRewardObj->currency) selected @endif
                                                                value="{{ $currency->code }}">{{ $currency->code }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if ($errors->has('currency_symbol'))
                                                    <div class="error text-danger">{{ $errors->first('currency_symbol') }}
                                                    </div>
                                                @endif
                                            </div> --}}
                                            <!-- Probability Percentage  -->
                                            <div class="form-group">
                                                <label for="probability_percentage">Probability percentage</label>
                                                <input type="number" name="probability_percentage"
                                                    id="probability_percentage" class="form-control">
                                                @if ($errors->has('probability_percentage'))
                                                    <div class="error text-danger">
                                                        {{ $errors->first('probability_percentage') }}
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
