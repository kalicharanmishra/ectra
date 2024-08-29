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
                            <h4 class='breadcrumbs'>Our Team / Add New Admin</h4>

                 </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title">Add New Admin</h4>

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>

                                        </ul>

                                    </div>

                                </div>

                                <div class="card-content collapse show">

                                    <div class="card-body card-dashboard">

                                        <form method="POST" action="{{ route('admin.v1.admin.add-submit') }}">

                                            @csrf

                                            

                                            <div class="form-group">

                                                <label for="username">Name</label>

                                                <input type="name" name="name" id="name"

                                                    class="form-control" value="{{ old('name') }}">

                                                @if ($errors->has('name'))

                                                    <div class="error text-danger">{{ $errors->first('name') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <label for="email">Email</label>

                                                <input type="email" name="email" id="email"

                                                    class="form-control" value="{{ old('email') }}">

                                                @if ($errors->has('email'))

                                                    <div class="error text-danger">{{ $errors->first('email') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <label for="phone">Phone</label>

                                                <input type="phone" name="phone" id="phone"

                                                    class="form-control" value="{{ old('phone') }}">

                                                @if ($errors->has('phone'))

                                                    <div class="error text-danger">{{ $errors->first('phone') }}

                                                    </div>

                                                @endif

                                            </div>

                                           

                                            

                                            <div class="form-group">

                                                <label for="password">password</label>

                                                <input type="password" name="password" id="password"

                                                    class="form-control" value="{{ old('password') }}">

                                                @if ($errors->has('password'))

                                                    <div class="error text-danger">{{ $errors->first('password') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <label for="phone">Role</label>

                                                <select name="role" id="role" class="form-control" require>

                                                    @foreach(DB::table('roles')->where('id', '!=', 1)->where('id', '!=', 3)->where('id', '!=', 4)->get() as $item)

                                                    <option value="{{$item->name}}">{{$item->name}}</option>

                                                    @endforeach

                                                </select>

                                               

                                                @if ($errors->has('gender'))

                                                    <div class="error text-danger">{{ $errors->first('gender') }}

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

