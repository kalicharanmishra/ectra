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
                                    <h4 class="card-title">Comment list</h4>
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
                                                        <!-- <th>Video</th> -->
                                                        <th>Comment</th>
                                                        <th>Comment By</th>
                                                        <th>Created At</th>
                                                        @if (Auth::user()->can('comments_block'))
                                                            <th>Action</th>
                                                        @endif
                                                        @if (Auth::user()->can('comments_delete'))
                                                            <th>Delete</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($comments as $comment)
                                                        <tr role="row" class="odd">
                                                            <td class="sorting_1">{{ $comment->id }}</td>
                                                            <!-- <td>
                                                                <a target="_blank"
                                                                    href="https://thrillvideo.s3.amazonaws.com/test/{{ App\Models\Video::find($comment->video_id)->video }}">
                                                                    {{ App\Models\Video::find($comment->video_id)->video }}
                                                                </a>
                                                            </td> -->
                                                            <td>{{ $comment->comment }}</td>
                                                            <td>{{ $comment->comment_by }}</td>
                                                            <td>{{ $comment->created_at }}</td>
                                                            @if (Auth::user()->can('comments_block'))
                                                            <td>
                                                                <a href="{{ route('admin.v1.course.blockcomment', ['id' => $comment->id, 'action' => (string) $comment->is_approved == '1' ? 'block' : 'unblock']) }}"
                                                                    class="btn {{ (string) $comment->is_approved == '1' ? 'btn-success' : 'btn-danger' }} btn-sm Block">
                                                                    @if ((string) $comment->is_approved == '1')
                                                                        Block
                                                                    @else
                                                                        Unblock
                                                                    @endif
                                                                </a>
                                                            </td>
                                                            @endif
                                                            @if (Auth::user()->can('comments_delete'))
                                                            <td>
                                                                <a onclick="return confirm('Are you sure want to delete this comment {{ $comment->name }}.?')"
                                                                    href={{ route('admin.v1.course.deletecomment', ['id' => $comment->id]) }}
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
