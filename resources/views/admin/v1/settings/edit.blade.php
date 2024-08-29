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
                            <h4 class='breadcrumbs'>Settings / List / Edit Setting</h4>
                 </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title">Edit Setting {{ $setting->name }}</h4>

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

                                            action="{{ route('admin.v1.settings.editSubmit', ['id' => $setting->id]) }}"

                                            enctype="multipart/form-data">

                                            @csrf

                                            <div class="form-group">

                                                <label for="setting-name">Setting Name</label>

                                                <input disabled type="text" id="setting-name" class="form-control"

                                                    value="{{ $setting->name }}">

                                            </div>

                                            @if ($setting->name == 'advertisement_image')

                                                <div class="form-group">

                                                    @if (!empty($setting->value))

                                                        <a target="_blank"

                                                            href="{{ url('public/uploads/profile_images/' . $setting->value) }}">

                                                            <img src="{{ url('public/uploads/profile_images/' . $setting->value) }}"

                                                                alt="{{ $setting->name }}" style="width: 50px">

                                                        </a>

                                                        <br>

                                                    @endif

                                                    <label for="setting-value">Setting Value</label>

                                                    <input type="file" name="setting-value" id="setting-value"

                                                        class="form-control">

                                                    @if ($errors->has('setting-value'))

                                                        <div class="error text-danger">

                                                            {{ $errors->first('setting-value') }}

                                                        </div>

                                                    @endif                                                    

                                                </div>                                            

                                            @else

                                                <div class="form-group">

                                                    <label for="setting-value">Setting Value</label>

                                                    <input type="text" name="setting-value" id="setting-value"

                                                        class="form-control" value="{{ $setting->value }}">

                                                    @if ($errors->has('setting-value'))

                                                        <div class="error text-danger">

                                                            {{ $errors->first('setting-value') }}

                                                        </div>

                                                    @endif

                                                </div>

                                            @endif

                                            @if ($setting->name == 'advertisement_link')    

                                            <b>Note: Don't use protocol (HTTP/HTTPS) before url: Example google.com </b>

                                            <br>

                                            @endif

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

