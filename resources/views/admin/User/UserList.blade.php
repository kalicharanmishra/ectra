      @section('content')
      <div class="content-wrapper">
    <div class="content-header">
          @extends('admin.master')
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Customer List</h3>

                <div class="card-tools">
<!--                   <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div> -->
                </div>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Username</th>
                      <th>Email</th>
                      <th>Avtars</th>
                      <th>Status</th>
                      <th>Created_at</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($list as $value)
                    <tr>
                      <td>{{$value->id}}</td>
                      <td>{{$value->username}}</td>
                      <td>{{$value->email}}</td>
                      <td><img width="50" src="{{asset('public/uploads/profile_images/'.$value->avtars)}}"/></td>
                      <td>
                        <div class="input-group input-group-lg mb-3">
                          <div class="input-group-prepend">
                            @if($value->status == 'active')
                              <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                {{ ucfirst($value->status)}}
                              </button>
                              <ul class="dropdown-menu" style="">
                                <li class="dropdown-item"><a href="{{route('change-Status',['inactive',$value->id])}}">InActive</a></li>
                              </ul>
                            @else
                              <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                {{ ucfirst($value->status)}}
                              </button>
                              <ul class="dropdown-menu" style="">
                                <li class="dropdown-item"><a href="{{route('change-Status',['active',$value->id])}}">Active</a></li>
                              </ul>
                            @endif
                            
                            
                          </div>
                        </div>
                      <td>{{$value->created_at}}</td>
                        
                        <td>           
                     <!-- <td><a href="{{route('admin.view',$value->id)}}"><button class="btn btn-dark">View</button></a> -->
                      <a onclick="return confirm('Are you sure?')" href="{{route('admin.delete',$value->id)}}"><button class="btn btn-danger">Delete</button></a></td>
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
     
