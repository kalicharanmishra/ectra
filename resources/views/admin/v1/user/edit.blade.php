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
                  <h4 class='breadcrumbs'>My profile / Edit student</h4>
               </div>
               <div class="col-lg-12 col-md-12">
                  <div class="card">
                     <div class="col-lg-12 col-md-12">&nbsp;</div>
                     <div class="col-lg-12 col-md-12">
                        <h4 ><U>Personal profile</U></h4>
                     </div>
                     <div class="card-header">
                        <h4 class="card-title">Edit student {{$user->name}}</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                           <ul class="list-inline mb-0">
                              <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                           </ul>
                        </div>
                     </div>
                     <div class="card-content collapse show">
                        <div class="card-body card-dashboard">
                           
                           <form method="POST"
                              action="{{route('admin.v1.student.edit-submit',['id'=>$user->id])}}" enctype="multipart/form-data">
                              @csrf
                              {{-- <div class="form-group">
                                 <label for="profile_name">Profile name</label>
                                 
                                 <input type="text" name="profile_name" id="profile_name"
                                 
                                     class="form-control" value="{{ $user->teacher_profile['profile_name'] }}">
                                 
                                 @if ($errors->has('profile_name'))
                                 
                                     <div class="error text-danger">{{ $errors->first('profile_name') }}
                                 
                                     </div>
                                 
                                 @endif
                                 
                                 </div> --}}
                              <div class="form-group">
                                 <label for="username">Name</label>
                                 <input type="name" name="name" id="name"
                                    class="form-control" value="{{ $user->name }}">
                                 @if ($errors->has('name'))
                                 <div class="error text-danger">{{ $errors->first('name') }}
                                 </div>
                                 @endif
                              </div>
                              <div class="form-group">
                                 <label for="dob">Date OF Birth</label>
                                 <input type="date" name="dob" id="dob" class="form-control" value="{{ old('dob')?old('dob'):$user->dob }}">
                                 @if ($errors->has('dob'))
                                 <div class="error text-danger">{{ $errors->first('dob') }}
                                 </div>
                                 @endif
                              </div>
                              <div class="form-group">
                                 <label for="tutor-email">Email</label>
                                 <input type="email" name="email" id="tutor-email"
                                    class="form-control" value="{{ $user->email }}">
                                 @if ($errors->has('email'))
                                 <div class="error text-danger">{{ $errors->first('email') }}
                                 </div>
                                 @endif
                              </div>
                              <div class="form-group">
                                 <label for="phone">Phone</label>
                                 <input type="phone" name="phone" id="phone"
                                    class="form-control" value="{{ $user->phone }}">
                                 @if ($errors->has('phone'))
                                 <div class="error text-danger">{{ $errors->first('phone') }}
                                 </div>
                                 @endif
                              </div>
                              <div class="form-group">
                                 <label for="phone">Gender</label>
                                 <select name="gender" id="gender" class="form-control">
                                 <option value="Male" @if($user->gender == "Male") selected @endif>Male</option>
                                 <option value="Female" @if($user->gender == "Female") selected @endif>Female</option>
                                 </select>
                                 @if ($errors->has('gender'))
                                 <div class="error text-danger">{{ $errors->first('gender') }}
                                 </div>
                                 @endif
                              </div>
                              {{--<div class="form-group">
                                 <label for="city">City</label>
                                 <input type="text" name="city" id="city" maxlength="255" value="{{ $user->teacher_profile['city'] }}" class="form-control">
                                 @if ($errors->has('city'))
                                 <div class="error text-danger">{{ $errors->first('city') }}
                                 </div>
                                 @endif
                              </div>
                              <div class="form-group">
                                 <label for="country">Country</label>
                                 <input type="text"  name="country" id="country" maxlength="255" value="{{ $user->teacher_profile['country'] }}" class="form-control">
                                 @if ($errors->has('country'))
                                 <div class="error text-danger">{{ $errors->first('country') }}
                                 </div>
                                 @endif
                              </div>--}}
                              <div class="form-group">
                                 <label for="location">location</label>
                                 <input type="text" name="location" id="location"
                                    class="form-control" value="{{ $user->location }}">
                                 @if ($errors->has('location'))
                                 <div class="error text-danger">{{ $errors->first('location') }}
                                 </div>
                                 @endif
                              </div>
                        
                  
                  <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
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