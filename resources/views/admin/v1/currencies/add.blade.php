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
                                    <h4 class="card-title">Add New Currency</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <form method="POST" action="{{ route('admin.v1.currencies.add-submit') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="code">Code</label>
                                                <input type="text" name="code" id="code"
                                                    class="form-control" value="{{ old('code') }}">
                                                @if ($errors->has('code'))
                                                    <div class="error text-danger">{{ $errors->first('code') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label for="symbol">symbol</label>
                                                <input type="text" name="symbol" id="symbol"
                                                    class="form-control" value="{{ old('symbol') }}">
                                                @if ($errors->has('symbol'))
                                                    <div class="error text-danger">{{ $errors->first('symbol') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="currency-image">Upload Image</label>
                                                <input type="file" name="currency-image" id="currency-image"
                                                    class="form-control">
                                                @if ($errors->has('currency-image'))
                                                    <div class="error text-danger">
                                                        {{ $errors->first('currency-image') }}
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
