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
                                    <h4 class="card-title">Edit SpinWheel Reward</h4>
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

                                        <form method="POST"
                                            action="{{ route('admin.v1.spinWheel.editRewardSubmit', ['id' => $id]) }}">
                                            @csrf
                                            <!-- Probability Percentage  -->
                                            <div class="form-group">
                                                <label for="probability">Probability (%)</label>
                                                <input type="number" name="probability" id="probability"
                                                    class="form-control" value="{{ $SpinRewardObj->probability }}">
                                                @if ($errors->has('probability'))
                                                    <div class="error text-danger">
                                                        {{ $errors->first('probability') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="amount">Amount</label>
                                                <input type="text" name="amount" id="amount" onkeypress='validate(event)' class="form-control"
                                                    value="{{ $SpinRewardObj->amount }}">
                                                @if ($errors->has('amount'))
                                                    <div class="error text-danger">
                                                        {{ $errors->first('amount') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="currency">Currency</label>
                                                <select name="currency" id="currency" class="form-control"
                                                    value="{{ $SpinRewardObj->currency }}">
                                                    @if (!empty($currencies))
                                                        @foreach ($currencies as $currency)
                                                            <option @if ($currency->code == $SpinRewardObj->currency) selected @endif
                                                                value="{{ $currency->code }}">{{ $currency->code }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @if ($errors->has('currency'))
                                                    <div class="error text-danger">
                                                        {{ $errors->first('currency') }}
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

<script>
    function validate(evt) {
  var theEvent = evt || window.event;

  // Handle paste
  if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
  } else {
  // Handle key press
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
  }
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}
</script>

@endsection
