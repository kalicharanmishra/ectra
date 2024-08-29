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
                                    <h4 class="card-title">Videos list</h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
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
                                                        <th>ID</th>
                                                        <th>User</th>
                                                        <th>Video</th>
                                                        @if (Auth()->user()->role == 2 || $permission->sound_view)
                                                            <th>Sound</th>
                                                        @endif
                                                        <th>Filter</th>
                                                        <th>Language</th>
                                                        <th>Category</th>
                                                        <th>Hashtags</th>
                                                        <th>Visibility</th>
                                                        <th>comment allowed</th>
                                                        <th>Description</th>
                                                        <th>Created At</th>
                                                        <th>Views</th>
                                                        @if (Auth()->user()->role == 2 || $permission->video_block || $permission->comments_view)
                                                            <th>Action</th>
                                                        @endif
                                                        @if (Auth()->user()->role == 2 || $permission->video_delete)
                                                            <th>Delete</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($videos_details as $video)
                                                        <tr role="row" class="odd">
                                                            <td class="sorting_1">{{ $video->id }}</td>
                                                            <td>{{ $video->user_id }}</td>
                                                            <td>
                                                                <a target="_blank"
                                                                    href="https://thrillvideo.s3.amazonaws.com/test/{{ $video->video }}">
                                                                    {{ $video->video }}
                                                                </a>
                                                            </td>
                                                            @if (Auth()->user()->role == 2 || $permission->sound_view)
                                                                <td>
                                                                    <a target="_blank"
                                                                        href="{{ asset('uploads/sounds/' . $video->sound) }}">
                                                                        {{ $video->sound }}
                                                                    </a>
                                                                </td>
                                                            @endif
                                                            <td>{{ $video->filter ?? 'N/A' }}</td>
                                                            <td>
                                                                {{ App\Models\Language::where('id', $video->language)->first()->name ?? 'N/A' }}
                                                            </td>
                                                            <td>
                                                                {{ App\Models\Categories::where('id', $video->category)->first()->title ?? 'N/A' }}
                                                            </td>
                                                            <td>
                                                                @foreach ($video->videoHashTags as $tag)
                                                                    #{{ App\Models\HashTag::where('id', $tag->hashtag_id)->first()->name ?? 'N/A' }}
                                                                @endforeach
                                                            </td>
                                                            <td>{{ $video->visibility }}</td>
                                                            <td>{{ $video->is_comment_allowed == 1 ? 'Yes' : 'No' }}</td>
                                                            <td>{{ $video->description }}</td>
                                                            <td>{{ $video->created_at }}</td>
                                                            <td>0</td>
                                                            @if (Auth()->user()->role == 2 || $permission->video_block || $permission->comments_view)
                                                                <td>
                                                                    @if (Auth()->user()->role == 2 || $permission->video_block)
                                                                        <a href="{{ route('admin.v1.video.block', ['id' => $video->id, 'action' => (string) $video->is_enabled == '1' ? 'block' : 'unblock']) }}"
                                                                            class="btn {{ (string) $video->is_enabled == '1' ? 'btn-success' : 'btn-danger' }} btn-sm Block">
                                                                            @if ((string) $video->is_enabled == '1')
                                                                                Block
                                                                            @else
                                                                                Unblock
                                                                            @endif
                                                                        </a>
                                                                    @endif
                                                                    @if (Auth()->user()->role == 2 || $permission->comments_view)
                                                                        <br>
                                                                        <a href="{{ route('admin.v1.video.comments', ['id' => $video->id]) }}"
                                                                            class="btn btn-info btn-sm Block">
                                                                            Comments
                                                                        </a>
                                                                    @endif
                                                                </td>
                                                            @endif
                                                            @if (Auth()->user()->role == 2 || $permission->video_delete)
                                                                <td>
                                                                    <a onclick="return confirm('Are you sure want to delete this sound {{ $video->name }}.?')"
                                                                        href={{ route('admin.v1.video.delete', ['id' => $video->id]) }}
                                                                        class="btn btn-danger btn-sm Delete">
                                                                        Delete
                                                                    </a>
                                                                </td>
                                                            @endif
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
