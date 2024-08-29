@section('content')
<div class="content-wrapper">
   <div class="content-header">
      @extends('admin.master')
   </div>
   @if(session('status'))
   <h6 class="alert alert-success">{{session('status')}}</h6>
   @endif
   <section class="content">
      <div class="card card-default">
         <div class="card-header">
            <h3 class="card-title">Add Category</h3>
            <div class="card-tools">
               <button type="button" class="btn btn-tool" data-card-widget="collapse">
               <i class="fas fa-minus"></i>
               </button>
            </div>
         </div>
         <div class="card-body">
            <form method="POST" action="{{route('categories.store')}}">
               @csrf
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Title Name">
                        @if($errors->has('title'))
                        <div class="error text-danger">{{ $errors->first('title') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <button class="btn btn-primary">Save</button>
                        <a href="{{route('categories.index')}}"><button type="button" class="btn btn-danger">Cancel</button></a>
                     </div>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </section>
</div>
@endsection
