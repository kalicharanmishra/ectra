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
                            <h4 class='breadcrumbs'>Contact / </h4>

                        </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <h4 class="card-title">Contact inquiry list</h4>

                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                    <div class="heading-elements">

                                        <ul class="list-inline mb-0">

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

                                                        <th>Name</th>

                                                        <th>email</th>

                                                        <th>Mobile</th>

                                                        <th>Message</th>

                                                        <th>Date</th>

                                                    </tr>

                                                </thead>

                                                <tbody>
                                               
                                                    @foreach ($contact as $contact)
                                                        @php
                                                            $i = $loop->index + 1;
                                                        @endphp
                                                   <tr role="row" class="odd">

                                                            <td class="sorting_1">{{ $i }}</td>

                                                            <td>{{ $contact->name }}</td>

                                                            <td>{{ $contact->email }}</td>

                                                            <td>{{ $contact->mobile }}</td>

                                                            <td>{{ $contact->message}}</td>

                                                            <td>{{ $contact->created_at}}</td>

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

