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
                                    <h4 class="card-title">Update Level: {{ $level->name }} to activity:
                                        {{ $activity->name }}</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                        </ul>
                                    </div>
                                    @if (Auth()->user()->role == 2 || $permission->activitylevels_view)
                                        <h6 class="mt-2">
                                            <a
                                                href="{{ route('admin.v1.spinWheel.activitylevels', ['activity_id' => $activity->id]) }}">Go
                                                to levels</a>
                                        </h6>
                                    @endif
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <form method="POST"
                                            action="{{ route('admin.v1.spinWheel.updateLevelSubmit', ['activity_id' => $activity->id, 'level_id' => $level->id]) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <!-- Level Name -->
                                            <div class="form-group">
                                                <label for="level_name">Level name</label>
                                                <input type="text" name="level_name" id="level_name" class="form-control"
                                                    value="{{ $level->name }}">
                                                @if ($errors->has('level_name'))
                                                    <div class="error text-danger">{{ $errors->first('level_name') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <!-- Spin Reward -->
                                            <div class="form-group">
                                                <label for="spin_reward">Spin reward</label>
                                                <input type="text" name="spin_reward" id="spin_reward"
                                                    class="form-control" value="{{ $level->spin_reward }}">
                                                @if ($errors->has('spin_reward'))
                                                    <div class="error text-danger">{{ $errors->first('spin_reward') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <!-- Likes -->
                                            <div class="form-group">
                                                <label for="likes">Likes</label>
                                                <input type="text" name="likes" id="likes" class="form-control"
                                                    value="{{ $level->likes }}">
                                                @if ($errors->has('likes'))
                                                    <div class="error text-danger">{{ $errors->first('likes') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <!-- views -->
                                            <div class="form-group">
                                                <label for="views">Views</label>
                                                <input type="text" name="views" id="views" class="form-control"
                                                    value="{{ $level->views }}">
                                                @if ($errors->has('views'))
                                                    <div class="error text-danger">{{ $errors->first('views') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <!-- Invites -->
                                            <div class="form-group">
                                                <label for="invites">Invites</label>
                                                <input type="text" name="invites" id="invites" class="form-control"
                                                    value="{{ $level->invites }}">
                                                @if ($errors->has('invites'))
                                                    <div class="error text-danger">{{ $errors->first('invites') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <!-- followers -->
                                            <div class="form-group">
                                                <label for="followers">Followers</label>
                                                <input type="text" name="followers" id="followers" class="form-control"
                                                    value="{{ $level->followers }}">
                                                @if ($errors->has('followers'))
                                                    <div class="error text-danger">{{ $errors->first('followers') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <!-- signup -->
                                            <div class="form-group">
                                                <label for="signup">Signup</label>
                                                <select name="signup" id="signup" class="form-control">
                                                    <option value="No" {{ $level->signup == 'No' ? 'selected' : '' }}>No
                                                    </option>
                                                    <option value="Yes" {{ $level->signup == 'Yes' ? 'selected' : '' }}>
                                                        Yes</option>
                                                </select>
                                                @if ($errors->has('signup'))
                                                    <div class="error text-danger">{{ $errors->first('signup') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <!-- video post -->
                                            <div class="form-group">
                                                <label for="video_post">First Video post</label>
                                                <select name="video_post" id="video_post" class="form-control">
                                                    <option value="No" {{ $level->signup == 'No' ? 'selected' : '' }}>No
                                                    </option>
                                                    <option value="Yes" {{ $level->signup == 'Yes' ? 'selected' : '' }}>
                                                        Yes</option>
                                                </select>
                                                @if ($errors->has('video_post'))
                                                    <div class="error text-danger">{{ $errors->first('video_post') }}
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
