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
                            <h4 class='breadcrumbs'>Settings / Permission / Edit Permission</h4>
                 </div>

                        <div class="col-lg-12 col-md-12">

                            <div class="card">

                                <div class="card-header">

                                   

                                    <h4 class="card-title">Edit Permission {{ $role_permissions->name }}</h4>

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

                                            action="{{ route('admin.v1.settings.permission.editSubmit', ['id' => $role_permissions->id]) }}"

                                            enctype="multipart/form-data">

                                            @csrf

                                            <div class="form-group">

                                                <label for="role-name">Role Name</label>

                                                <input type="text" id="role-name" name="name" class="form-control"

                                                    value="{{ $role_permissions->name }}">

                                                    @if ($errors->has('name'))

                                                    <div class="error text-danger">{{ $errors->first('name') }}

                                                    </div>

                                                @endif

                                            </div>

                                            <div class="form-group">

                                                <label for="role-name">Permission</label>

                                                @foreach(App\Models\Permission::select('name', 'id')->get() as $item)

                                                <div class="form-check">

  

                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{$item->name}}" @if(count($role_permissions->permissions) > 0 && in_array($item->name, $role_permissions->permissions->pluck('name')->all())) checked @endif id="defaultCheck2" >

                                                 <label class="form-check-label" for="defaultCheck2">{{$item->name}}</label>

                                                </div>

                                                @endforeach

                                                @if ($errors->has('permissions'))

                                                    <div class="error text-danger">{{ $errors->first('permissions') }}

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

