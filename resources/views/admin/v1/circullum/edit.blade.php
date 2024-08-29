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
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add New circullum</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0">
                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <form method="POST" action="{{ route('admin.v1.circullum.edit-submit',['id'=>$categories->id]) }}" enctype="multipart/form-data">
                                        @csrf
                                                <div class="form-group">
                                                    <label for="topic">Topic</label>
                                                    <input type="text" name="topic" id="topic" class="form-control" value="{{ $categories->topic }}">
                                                    @if ($errors->has('topic'))
                                                    <div class="error text-danger">{{ $errors->first('topic') }}
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea name="description" id="description" class="form-control" >{{ $categories->topic }}</textarea>
                                                    @if ($errors->has('description'))
                                                    <div class="error text-danger">{{ $errors->first('description') }}
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="url">Url</label>
                                                    <input type="text" name="url" id="url" class="form-control" value="{{ $categories->class_url }}">
                                                    @if ($errors->has('url'))
                                                    <div class="error text-danger">{{ $errors->first('url') }}
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="complete">Complete</label>
                                                    <select name="complete" class="form-control">
                                                        <option @if( $categories->is_complete =="yes") selected @endif value="yes">Yes</option>
                                                        <option @if( $categories->is_complete =="no") selected @endif value="no">No</option>
                                                    </select>
                                                    @if ($errors->has('complete'))
                                                    <div class="error text-danger">{{ $errors->first('complete') }}
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="cover_time">Cover Time</label>
                                                    <input type="time" name="cover_time" id="cover_time" class="form-control" value="{{ $categories->cover_time }}">
                                                    @if ($errors->has('cover_time'))
                                                    <div class="error text-danger">{{ $errors->first('cover_time') }}
                                                    </div>
                                                    @endif
                                                </div>
                                                <hr>
                                        

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

<script>
    document.getElementById("Addteam").onclick = function() {
  var container = document.getElementById("wholediv");
  var section = document.getElementById("wholefun");
  container.appendChild(section.cloneNode(true));

}
    </script>
@endsection