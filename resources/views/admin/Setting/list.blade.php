@section('content')
<div class="content-wrapper">
   <div class="content-header">
      @extends('admin.master')
   </div>
   <section class="content">
      <div class="card card-default">
         <div class="card-header">
            <h3 class="card-title">Site Setting Management</h3>
            <div class="card-tools">
               <button type="button" class="btn btn-tool" data-card-widget="collapse">
               <i class="fas fa-minus"></i>
               </button>
               <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
               <i class="fas fa-times"></i>
               </button> -->
            </div>
         </div>
         <div class="card-body">
            <form  action="{{route('setting.update')}}" method="POST">
               @csrf
               <div class="row">
                  @foreach($setting as $val)
                     <div class="col-md-4">
                        <div class="form-group">
                           <!-- <label>Title</label> -->
                           <input type="text" class="form-control"  value="{{$val->title}}" readonly="true">
                        </div>
                     </div>
                     <div class="col-md-8">
                        <div class="form-group">
                           <!-- <label>Value</label> -->
                           <input type="text" name="{{$val->slug}}" class="form-control"  value="{{$val->value}}" >
                        </div>
                     </div>
                  

                  @endforeach
                  <div class="col-md-6">
                     <div class="form-group">
                        <button class="btn btn-primary">Save</button>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </section>
</div>
@endsection
