@extends('admin.v1.templates.main')

@section('content')
<style>
   /* body.vertical-layout[data-color=bg-gradient-x-purple-blue] {
        background-color: red !important;
    } */
</style>


    <div class="app-content content">

        <div class="content-wrapper">

            <div class="content-wrapper-before"></div>

            <div class="content-header row">

            </div>

            @if (session('message'))

                <div class="alert alert-danger alert-dismissible fade show" role="alert">

                    {{ session('message') }}

                </div>

            @endif

            <div class="content-body">

                <div class="row">

                    <div class="col-md-12 col-lg-12">

                        @if (auth()->user()->can('dashboard_user'))

                        {{-- users --}}

                        <div class="card">

                            <div class="card-header p-1">

                                <h4 class="card-title float-left">Our Guests<span

                                        class="blue-grey lighten-2 font-small-3 mb-0"></span></h4>

                                <span class="badge badge-pill badge-info float-right m-0"></span>

                            </div>

                            <div class="card-content collapse show">

                                <div class="card-footer text-center p-1">

                                    <div class="row">

                                        <div

                                            class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">

                                            <p class="blue-grey lighten-2 mb-0">Today</p>

                                            <p class="font-medium-5 text-bold-400">{{ $user['today'] ?? '0' }}</p>

                                        </div>

                                        <div

                                            class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">

                                            <p class="blue-grey lighten-2 mb-0">7 day</p>

                                            <p class="font-medium-5 text-bold-400">{{ $user['sevenday'] ?? '0' }}</p>

                                        </div>

                                        <div

                                            class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">

                                            <p class="blue-grey lighten-2 mb-0">30 day</p>

                                            <p class="font-medium-5 text-bold-400">{{ $user['thirtyday'] ?? '0' }}</p>

                                        </div>

                                        <div

                                            class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">

                                            <p class="blue-grey lighten-2 mb-0">All Time</p>

                                            <p class="font-medium-5 text-bold-400">{{ $user['total_users'] ?? '0' }}</p>

                                        </div>



                                    </div>

                                    <hr>

                                    <!--span class="text-muted"><a href="#" class="danger darken-2">Project X</a> Statistics</span-->

                                </div>

                            </div>

                        </div>

                        @endif

                        @if (auth()->user()->can('course_view'))

                        {{-- users --}}

                        <div class="card">

                            <div class="card-header p-1">

                                <h4 class="card-title float-left">@if(auth()->user()->hasRole('tutor')) My Students @else Our Students @endif  <span

                                        class="blue-grey lighten-2 font-small-3 mb-0"></span></h4>

                                <span class="badge badge-pill badge-info float-right m-0"></span>

                            </div>

                            <div class="card-content collapse show">

                                <div class="card-footer text-center p-1">

                                    <div class="row">

                                        <div

                                            class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">

                                            <p class="blue-grey lighten-2 mb-0">Today</p>

                                            <p class="font-medium-5 text-bold-400">{{ $student['today'] ?? '0' }}</p>

                                        </div>

                                        <div

                                            class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">

                                            <p class="blue-grey lighten-2 mb-0">7 day</p>

                                            <p class="font-medium-5 text-bold-400">{{ $student['sevenday'] ?? '0' }}</p>

                                        </div>

                                        <div

                                            class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">

                                            <p class="blue-grey lighten-2 mb-0">30 day</p>

                                            <p class="font-medium-5 text-bold-400">{{ $student['thirtyday'] ?? '0' }}</p>

                                        </div>

                                        <div

                                            class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">

                                            <p class="blue-grey lighten-2 mb-0">All Time</p>

                                            <p class="font-medium-5 text-bold-400">{{ $student['total_users'] ?? '0' }}</p>

                                        </div>



                                    </div>

                                    <hr>

                                    <!--span class="text-muted"><a href="#" class="danger darken-2">Project X</a> Statistics</span-->

                                </div>

                            </div>

                        </div>

                        @endif



                        @if (auth()->user()->can('dashboard_user'))

                        {{-- users --}}

                        <div class="card">

                            <div class="card-header p-1">

                                <h4 class="card-title float-left">Our Teachers<span

                                        class="blue-grey lighten-2 font-small-3 mb-0"></span></h4>

                                <span class="badge badge-pill badge-info float-right m-0"></span>

                            </div>

                            <div class="card-content collapse show">

                                <div class="card-footer text-center p-1">

                                    <div class="row">

                                        <div

                                            class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">

                                            <p class="blue-grey lighten-2 mb-0">Today</p>

                                            <p class="font-medium-5 text-bold-400">{{ $teacher['today'] ?? '0' }}</p>

                                        </div>

                                        <div

                                            class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">

                                            <p class="blue-grey lighten-2 mb-0">7 day</p>

                                            <p class="font-medium-5 text-bold-400">{{ $teacher['sevenday'] ?? '0' }}</p>

                                        </div>

                                        <div

                                            class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">

                                            <p class="blue-grey lighten-2 mb-0">30 day</p>

                                            <p class="font-medium-5 text-bold-400">{{ $teacher['thirtyday'] ?? '0' }}</p>

                                        </div>

                                        <div

                                            class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">

                                            <p class="blue-grey lighten-2 mb-0">All Time</p>

                                            <p class="font-medium-5 text-bold-400">{{ $teacher['total_users'] ?? '0' }}</p>

                                        </div>



                                    </div>

                                    <hr>

                                    <!--span class="text-muted"><a href="#" class="danger darken-2">Project X</a> Statistics</span-->

                                </div>

                            </div>

                        </div>

                        @endif

                        

                        @if (auth()->user()->can('dashboard_user'))

                        {{-- users --}}

                        <div class="card">

                            <div class="card-header p-1">

                                <h4 class="card-title float-left">Course Listed<span

                                        class="blue-grey lighten-2 font-small-3 mb-0"></span></h4>

                                <span class="badge badge-pill badge-info float-right m-0"></span>

                            </div>

                            <div class="card-content collapse show">

                                <div class="card-footer text-center p-1">

                                    <div class="row">

                                        <div

                                            class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">

                                            <p class="blue-grey lighten-2 mb-0">Today</p>

                                            <p class="font-medium-5 text-bold-400">{{ $courses['today'] ?? '0' }}</p>

                                        </div>

                                        <div

                                            class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">

                                            <p class="blue-grey lighten-2 mb-0">7 day</p>

                                            <p class="font-medium-5 text-bold-400">{{ $courses['sevenday'] ?? '0' }}</p>

                                        </div>

                                        <div

                                            class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">

                                            <p class="blue-grey lighten-2 mb-0">30 day</p>

                                            <p class="font-medium-5 text-bold-400">{{ $courses['thirtyday'] ?? '0' }}</p>

                                        </div>

                                        <div

                                            class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">

                                            <p class="blue-grey lighten-2 mb-0">All Time</p>

                                            <p class="font-medium-5 text-bold-400">{{ $courses['total_users'] ?? '0' }}</p>

                                        </div>



                                    </div>

                                    <hr>

                                    <!--span class="text-muted"><a href="#" class="danger darken-2">Project X</a> Statistics</span-->

                                </div>

                            </div>

                        </div>

                        @endif







                        @if (auth()->user()->can('dashboard_user'))

                        {{-- users --}}

                        <div class="card">

                            <div class="card-header p-1">

                                <h4 class="card-title float-left">Transactions<span

                                        class="blue-grey lighten-2 font-small-3 mb-0"></span></h4>

                                <span class="badge badge-pill badge-info float-right m-0"></span>

                            </div>

                            <div class="card-content collapse show">

                                <div class="card-footer text-center p-1">

                                    <div class="row">

                                        <div

                                            class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">

                                            <p class="blue-grey lighten-2 mb-0">Today</p>

                                            <p class="font-medium-5 text-bold-400">{{ $transacs['today'] ?? '0' }}</p>

                                        </div>

                                        <div

                                            class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">

                                            <p class="blue-grey lighten-2 mb-0">7 day</p>

                                            <p class="font-medium-5 text-bold-400">{{ $transacs['sevenday'] ?? '0' }}</p>

                                        </div>

                                        <div

                                            class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">

                                            <p class="blue-grey lighten-2 mb-0">30 day</p>

                                            <p class="font-medium-5 text-bold-400">{{ $transacs['thirtyday'] ?? '0' }}</p>

                                        </div>

                                        <div

                                            class="col-md-3 col-12 border-right-blue-grey border-right-lighten-5 text-center">

                                            <p class="blue-grey lighten-2 mb-0">All Time</p>

                                            <p class="font-medium-5 text-bold-400">{{ $transacs['total_users'] ?? '0' }}</p>

                                        </div>



                                    </div>

                                    <hr>

                                    <!--span class="text-muted"><a href="#" class="danger darken-2">Project X</a> Statistics</span-->

                                </div>

                            </div>

                        </div>

                        @endif









                    </div>

                </div>

            </div>

        </div>

    </div>



   

@endsection



