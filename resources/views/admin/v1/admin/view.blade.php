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
                                    <h4 class="card-title">View User: {{ $userFieldsObj->name }}</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <form>
                                            <div class="form-group">
                                                <label for="">Name</label>
                                                <input disabled type="text" class="form-control"
                                                    value="{{ $userFieldsObj->name }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="">username</label>
                                                <input disabled type="text" class="form-control"
                                                    value="{{ $userFieldsObj->username }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="">dob</label>
                                                <input disabled type="text" class="form-control"
                                                    value="{{ $userFieldsObj->dob }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="">phone</label>
                                                <input disabled type="text" class="form-control"
                                                    value="{{ $userFieldsObj->phone }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="">avatar</label>
                                                <img src="{{ asset('uploads/profile_images/' . $userFieldsObj->avatar) ?? asset('thrill/v1/images/noavatar.png') }}"
                                                    alt="avatar">
                                            </div>
                                            <div class="form-group">
                                                <label for="">social_login_id</label>
                                                <input disabled type="text" class="form-control"
                                                    value="{{ $userFieldsObj->social_login_id }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="">social_login_type</label>
                                                <input disabled type="text" class="form-control"
                                                    value="{{ $userFieldsObj->social_login_type }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="">first_name</label>
                                                <input disabled type="text" class="form-control"
                                                    value="{{ $userFieldsObj->first_name }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="">last_name</label>
                                                <input disabled type="text" class="form-control"
                                                    value="{{ $userFieldsObj->last_name }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="">gender</label>
                                                <input disabled type="text" class="form-control"
                                                    value="{{ $userFieldsObj->gender }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="">website_url</label>
                                                <input disabled type="text" class="form-control"
                                                    value="{{ $userFieldsObj->website_url }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="">bio</label>
                                                <input disabled type="text" class="form-control"
                                                    value="{{ $userFieldsObj->bio }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="">youtube</label>
                                                <input disabled type="text" class="form-control"
                                                    value="{{ $userFieldsObj->youtube }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="">facebook</label>
                                                <input disabled type="text" class="form-control"
                                                    value="{{ $userFieldsObj->facebook }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="">instagram</label>
                                                <input disabled type="text" class="form-control"
                                                    value="{{ $userFieldsObj->instagram }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="">twitter</label>
                                                <input disabled type="text" class="form-control"
                                                    value="{{ $userFieldsObj->twitter }}">
                                            </div>
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
