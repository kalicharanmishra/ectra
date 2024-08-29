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
                            <h4 class='breadcrumbs'>Settings / List</h4>
                 </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title">Site Settings</h4>

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

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

                                                        <th>Name</th>

                                                        <th>Value</th>

                                                        @if (Auth::user()->can('sitesetting_edit'))

                                                            <th>Action</th>

                                                        @endif

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    @foreach ($settings_arr as $setting)

                                                        <tr role="row" class="odd">

                                                            <td class="sorting_1">{{ $setting['id'] }}</td>

                                                            <td>{{ $setting['name'] }}</td>

                                                            <td>

                                                                @if ($setting['name'] == 'advertisement_image')

                                                                    @if (!empty($setting['value']))

                                                                        <a target="_blank"

                                                                            href="{{ url('uploads/profile_images/' . $setting['value']) }}">

                                                                            <img src="{{ url('uploads/profile_images/' . $setting['value']) }}"

                                                                                alt="{{ $setting['name'] }}"

                                                                                style="width: 50px">

                                                                        </a>

                                                                    @else

                                                                        N/A

                                                                    @endif

                                                                @else

                                                                    {{ $setting['value'] }}

                                                                @endif

                                                            </td>

                                                                <td>

                                                                    <a href="{{ route('admin.v1.settings.edit', ['id' => $setting['id']]) }}"

                                                                        class="btn btn-success btn-sm Block">

                                                                        Edit

                                                                    </a>

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

