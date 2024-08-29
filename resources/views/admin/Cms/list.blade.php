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
                            <h4 class='breadcrumbs'>CMS / </h4></div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title">CMS List</h4>

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

                                        <li><a class="btn btn-light" href="{{ route('admin.v1.cms.add') }}"><i class="ft-plus"></i></a></li>

                                            

                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>

                                        </ul>

                                    </div>

                                </div>



                                <div class="card-content collapse show">

                                    <div class="card-body card-dashboard">

                                        <div class="table-responsive">

                                            <!-- modal ends -->

                                            <table class="table table-striped table-bordered file-export">

                                                <thead>

                                                    <tr>

                                                        <th>ID</th>

                                                        <th>Title</th>

                                                        <th>Slug</th>

                                                        <th>Created At</th>

                                                        @if (Auth::user()->can('cms_delete'))

                                                            <th>Action</th>

                                                        @endif

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    @foreach ($list as $value)

                                                        <tr>

                                                            <td>{{ $value->id }}</td>

                                                            <td>{{ $value->title }}</td>

                                                            <td>{{ $value->slug }}</td>

                                                            <td>{{ $value->created_at->diffforhumans() }}</td>

                                                            @if ( Auth::user()->can('cms_edit') || Auth::user()->can('cms_delete'))

                                                                <td>

                                                                    @if (Auth::user()->can('cms_edit'))

                                                                        <a

                                                                            href="{{ route('admin.v1.cms.edit', ['id' => $value->id]) }}"><button

                                                                                class="btn btn-info">View/Edit</button></a>

                                                                    @endif

                                                                    @if (Auth::user()->can('cms_delete'))

                                                                        <a onclick="return confirm('Are you sure want to delete this page title {{ $value->title }}.?')"

                                                                            href="{{ route('admin.v1.cms.delete', ['id' => $value->id]) }}"><button

                                                                                class="btn btn-danger">Delete</button></a>

                                                                    @endif

                                                                </td>

                                                            @endif

                                                        </tr>

                                                    @endforeach

                                                </tbody>

                                            </table>

                                        </div>

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

