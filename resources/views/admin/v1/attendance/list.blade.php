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
                            <h4 class='breadcrumbs'>Attendence / </h4>

                        </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                    <!-- <h4 class="card-title">Attendence list</h4> -->

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
                                                        <th>S.no.</th>
                                                        <th>ID</th>

                                                        <th>Course name</th>

                                                        <th>Student name</th>
                                                        {{--<th>Cirricullum</th>--}}
                                                        <th>Total no. of class</th>
                                                        <th>Class date</th>
                                                        <th>Classes attended</th>
                                                        {{--<th>Teachers</th>--}}
                                                        <th>Class remaining</th>

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    @foreach ($categories as $category)

                                                        <tr role="row" class="odd">

                                                            <td class="sorting_1">{{ $category->id }}</td>

                                                            <td>{{ $category->course?->title }}</td>

                                                            {{--<td>{{ $category->circullum?->topic }}</td>--}}

                                                            {{--<td>{{ $category->teacher->name }}</td>--}}

                                                            <td>{{ $category->usered->name }}</td>
                                                            <td>
                                                                @php
                                                                    $days = $category->duration;

    $start_date = new DateTime(date("Y/m/d"));
    $end_date = new DateTime(date("Y/m/d",strtotime("+$days days")));
    $dd = date_diff($start_date,$end_date);  
    $end = date('Y-m-d', strtotime("+$dd->m months", strtotime($category->created_at)));
    $startMonth = date('m', strtotime($category->created_at));
    $months = $startMonth;
    $num_sundays='';
    
    for($j=1;$j<=$dd->m;$j++) 
    {
        $years=date('Y',strtotime($category->created_at));     
        $monthName = date("F", mktime(0, 0, 0, $months));
        $fromdt=date('Y-m-01 ',strtotime("First Day Of  $monthName")) ;
        $todt=date('Y-m-d ',strtotime("Last Day of $monthName $years"));

        for ($i = 0; $i < ((strtotime($todt) - strtotime($fromdt)) / 86400); $i++)
        {
            $heldDays = explode(' ', $category->class_held_on);
            foreach($heldDays as $day)
            {
                if(date('l',strtotime($fromdt) + ($i * 86400)) == $day)
                {
                        $num_sundays++;
                }
            }    
        }
        $months = date('m', strtotime('First Day Of '.+$j.' month'));
    }
    echo $num_sundays;
                                                                @endphp
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

