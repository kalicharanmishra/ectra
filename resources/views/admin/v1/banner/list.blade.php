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
                            <h4 class='breadcrumbs'>Banner / </h4>
                 </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title">Banner list</h4>

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

                                            @if (auth()->user()->can('banner_add'))

                                            <li><a class="btn btn-light" href="{{ route('admin.v1.banner.add') }}">Add Banner</a></li>

                                            @endif

                                            <li><a class="btn btn-light" data-action="expand">Expand</a></li>

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

                                                        <th>image</th>

                                                        <th>Start Date</th>

                                                        <th>End Date</th>

                                                        <th>Created At</th>

                                                        <th>Action</th>

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    @foreach ($banners as $banner)

                                                        <tr role="row" class="odd">

                                                            <td class="sorting_1">{{ $banner->id }}</td>

                                                            <td>

                                                                <a target="_blank"

                                                                    href="{{ asset('uploads/banners/' . $banner->image) }}">

                                                                    {{ $banner->image }}

                                                                </a>

                                                            </td>

                                                            <td>{{ $banner->start_date }}</td>

                                                            <td>{{ $banner->end_date }}</td>

                                                            <td>{{ $banner->created_at->diffforhumans() }}</td>

                                                            

                                                            <td>

                                                            @if (Auth::user()->can('banner_delete'))

                                                                <a 

                                                                    href="{{ route('admin.v1.banner.edit', ['id' => $banner->id]) }}"

                                                                    class="btn btn-success btn-sm Delete">

                                                                    Edit

                                                                </a>

                                                            @endif

                                                            @if(auth()->user()->hasRole('super admin') || auth()->user()->hasRole('admin') )

                                                                <a onclick="return confirm('Are you sure want to delete this banner {{ $banner->image }}.?')"

                                                                    href="{{ route('admin.v1.banner.delete', ['id' => $banner->id]) }}"

                                                                    class="btn btn-danger btn-sm Delete">

                                                                    Delete

                                                                </a>

                                                            @endif

                                                            </td>

                                                            

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

