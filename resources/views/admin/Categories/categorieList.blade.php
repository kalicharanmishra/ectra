@section('content')

<div class="content-wrapper">

   <div class="content-header">

      @extends('admin.master')

      <div class="row">

         <div class="col-12">

            <div class="card">

               <div class="card-header">

                  <h3 class="card-title">Category List</h3>

<!--                   <div class="card-tools">

                     <div class="input-group input-group-sm" style="width: 150px;">

                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">

                           <button type="submit" class="btn btn-default">

                           <i class="fas fa-search"></i>

                           </button>

                        </div>

                     </div>

                  </div> -->

               </div>

               <div class="card-body table-responsive p-0">

                  <table class="table table-hover text-nowrap" id="tableID">

                     <thead>

                        <tr>

                           <th>ID</th>

                           <th>Title</th>

                           <th>Status</th>

                           <th>Cearted_At</th>

                           <th>Action</th>

                        </tr>

                     </thead>

                     <tbody>

                        @foreach($list as $value)

                        <tr>

                           <td>{{$value->id}}</td>

                           <td>{{$value->title}}</td>

                           <td>

                              <div class="input-group input-group-lg mb-3">

                                 <div class="input-group-prepend">

                                    @if($value->status == 'active')

                                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                                    {{ ucfirst($value->status)}}

                                    </button>

                                    <ul class="dropdown-menu" style="">

                                       <li class="dropdown-item"><a href="{{route('changeStatus',['inactive',$value->id])}}">InActive</a></li>

                                    </ul>

                                    @else

                                    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                                    {{ ucfirst($value->status)}}

                                    </button>

                                    <ul class="dropdown-menu" style="">

                                       <li class="dropdown-item"><a href="{{route('changeStatus',['active',$value->id])}}">Active</a></li>

                                    </ul>

                                    @endif

                                 </div>

                              </div>

                           </td>

                           <td>{{$value->created_at}}</td>

                           <td>

                              <a href="{{route('categories.edit',['id'=>$value->id])}}"><button class="btn btn-info">Edit</button></a>

                              <a onclick="return confirm('Are you sure?')" href="{{route('categories.delete',['id'=>$value->id])}}"><button class="btn btn-danger">Delete</button></a>

                           </td>

                        </tr>

                        @endforeach

                     </tbody>

                  </table>

               </div>

            </div>

            <!-- /.card -->

         </div>

      </div>

   </div>

</div>



@endsection