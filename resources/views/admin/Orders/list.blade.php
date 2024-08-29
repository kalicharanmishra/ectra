@section('content')
<div class="content-wrapper">
   <div class="content-header">
      @extends('admin.master')
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h3 class="card-title">Payment List</h3>
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
                  <table class="table table-hover text-nowrap">
                     <thead>
                        <tr>
                           <th>ID</th>
                           <th>Customer</th>
                           <th>Vemdor</th>
                           <th>Price</th>
                           <th>Total Amount</th>
                           <th>Commission</th>
                           <th>Cearted_At</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($Orders as $value)
                        @php $get_per = ($value->price*$SiteSetting->value/100); @endphp
                        <tr>
                           <td>{{$value->id}}</td>
                           <td>{{ @($value->customer_details->username) ?: ""}}</td>
                           <td>{{@($value->vendor_details->username) ?: ""}}</td>
                           <td>{{$value->price}}</td>
                           <td>{{$value->total_amount}}</td>
                           <td>{{$get_per}}</td>
                           <td>{{$value->created_at}}</td>
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