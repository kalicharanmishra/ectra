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
                                    <h4 class="card-title">Change password</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        @if (session('success'))
                                            <h6 class="alert alert-success">{{ session('success') }}</h6>
                                        @endif
                                        @if (session('error'))
                                            <h6 class="alert alert-danger">{{ session('error') }}</h6>
                                        @endif
                                        <form method="POST" action="{{ route('admin.v1.appuser.changePasswordSubmit') }}">
                                            @csrf
                                            <div class="form-group">
                                                <label for="current_password">Current Password</label>
                                                <input name="current_password" type="password" class="form-control"
                                                    value="{{ old('current_password') }}">
                                                @if ($errors->has('current_password'))
                                                    <div class="error text-danger">
                                                        {{ $errors->first('current_password') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="password">New Password</label>
                                                <input name="password" id="password" type="password" class="form-control"
                                                    value="{{ old('password') }}">
                                                @if ($errors->has('password'))
                                                    <div class="error text-danger">{{ $errors->first('password') }}</div>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="password_confirmation">Confirm Password</label>
                                                <input name="password_confirmation" id="password_confirmation"
                                                    type="password" class="form-control"
                                                    value="{{ old('password_confirmation') }}">
                                                @if ($errors->has('password_confirmation'))
                                                    <div class="error text-danger">
                                                        {{ $errors->first('password_confirmation') }}</div>
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
