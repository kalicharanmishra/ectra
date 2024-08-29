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
                            <h4 class='breadcrumbs'>Set Notifications / </h4>
                 </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title">Set Notification</h4>

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

                                        <form method="POST" action="{{ route('admin.v1.settings.send-notification') }}"

                                            multipart/form-data>

                                            @csrf

                                            <div class="form-group">

                                                <label for="title">Title</label>

                                                <input name="title" type="text" class="form-control"

                                                    value="{{ old('title') }}">

                                                @if ($errors->has('title'))

                                                    <div class="error text-danger">

                                                        {{ $errors->first('title') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <label for="message">Message</label>

                                                <input name="message" type="text" class="form-control"

                                                    value="{{ old('message') }}">

                                                @if ($errors->has('message'))

                                                    <div class="error text-danger">

                                                        {{ $errors->first('message') }}

                                                    </div>

                                                @endif

                                            </div>





                                            {{-- <div class="form-group">

                                                <label for="image">Image</label>

                                                <input name="image" type="file" class="form-control"

                                                    value="{{ old('image') }}">

                                                @if ($errors->has('image'))

                                                    <div class="error text-danger">

                                                        {{ $errors->first('image') }}

                                                    </div>

                                                @endif

                                            </div> --}}

                                            <div class="form-group">

                                                <input type="checkbox" name="alluser" id="alluser">

                                                <label for="alluser">All user</label>



                                            </div>

                                            <div class="form-group">

                                                <label for="users">Select Users</label>

                                                <select name="users[]" id="user-select" class="form-control form-select " multiple="multiple">

                                                    @foreach ($users as $user)

                                                        <option value="{{ $user->id }}">{{$user->name}}({{ $user->username }})</option>

                                                    @endforeach

                                                </select>

                                                @if ($errors->has('users'))

                                                <div class="error text-danger">

                                                    {{ $errors->first('users') }}

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

        $(document).ready(function() {

            $('#user-select').select2();





      });



    </script>

@endsection

