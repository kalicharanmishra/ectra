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
                                    <h4 class="card-title">Permission for Sub Admin</h4>
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
                                            action="{{ route('admin.v1.subadmin.access-submit', ['id' => $permission->sub_admin_id]) }}">
                                            @csrf
                                            <div class="col">

                                                {{-- Dashboard Access --}}
                                                <div class="mb-2">
                                                    <h2 class="card-title">Dashboard Access</h2>
                                                    <div class="col-12 px-3 d-flex justify-content-between">
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="dashboard_user" id="dashboard_user"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->dashboard_user) checked @endif>
                                                            <label for="dashboard_user">View Registered User</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="dashboard_video"
                                                                id="dashboard_video" value="1" class="form-check-input"
                                                                @if ($permission->dashboard_video) checked @endif>
                                                            <label for="dashboard_video">View Posted Videos</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="dashboard_reward"
                                                                id="dashboard_reward" value="1"
                                                                class="form-check-input"
                                                                @if ($permission->dashboard_reward) checked @endif>
                                                            <label for="dashboard_reward">View Rewards Graph</label>
                                                        </div>


                                                    </div>
                                                </div>
                                                {{-- User Access --}}
                                                <div class="mb-2">
                                                    <h2 class="card-title">User Access</h2>
                                                    <div class="col-12 px-3 d-flex justify-content-between">
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="appuser_view" id="view_user"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->appuser_view) checked @endif>
                                                            <label for="view_user">View User</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="appuser_block" id="block_user"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->appuser_block) checked @endif>
                                                            <label for="block_user">Block User</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="appuser_varify" id="varify_user"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->appuser_varify) checked @endif>
                                                            <label for="varify_user">Varify User</label>
                                                        </div>


                                                    </div>
                                                    {{-- <div class="col-12 px-3 pt-2 d-flex justify-content-between">
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="appuser_delete" id="delete_user"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->appuser_delete) checked @endif>
                                                            <label for="delete_user">Delete User</label>
                                                        </div>


                                                    </div> --}}

                                                </div>

                                                {{-- Subadmin Access --}}
                                                <div class="mb-2">
                                                    <h2 class="card-title">Sub Admin Access</h2>
                                                    <div class="col-12 px-3 d-flex justify-content-between">
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="subadmin_view" id="subadmin_view"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->subadmin_view) checked @endif>
                                                            <label for="subadmin_view">View Subadmin</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="subadmin_add" id="subadmin_add"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->subadmin_add) checked @endif>
                                                            <label for="subadmin_add">Add Subadmin</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="subadmin_edit" id="subadmin_edit"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->subadmin_edit) checked @endif>
                                                            <label for="subadmin_edit">Edit Subadmin</label>
                                                        </div>


                                                    </div>
                                                    <div class="col-12 px-3 pt-2 d-flex justify-content-between">

                                                        <div class="form-check col">
                                                            <input type="checkbox" name="subadmin_block" id="subadmin_block"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->subadmin_block) checked @endif>
                                                            <label for="subadmin_block">Block Subadmin</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="subadmin_delete"
                                                                id="subadmin_delete" value="1"
                                                                class="form-check-input"
                                                                @if ($permission->subadmin_delete) checked @endif>
                                                            <label for="subadmin_delete">Delete Subadmin</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="subadmin_access"
                                                                id="subadmin_access" value="1"
                                                                class="form-check-input"
                                                                @if ($permission->subadmin_access) checked @endif>
                                                            <label for="subadmin_access">Access Subadmin</label>
                                                        </div>

                                                    </div>

                                                </div>


                                                {{-- Video Access --}}
                                                <div class="mb-2">
                                                    <h2 class="card-title">Video Access</h2>
                                                    <div class="col-12 px-3 d-flex justify-content-between">
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="video_view" id="video_view"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->video_view) checked @endif />
                                                            <label for="video_view">View Video</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="video_delete" id="video_delete"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->video_delete) checked @endif>
                                                            <label for="video_delete">Delete Video</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="video_block" id="video_block"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->video_block) checked @endif>
                                                            <label for="video_block">Block Video</label>
                                                        </div>

                                                    </div>
                                                </div>

                                                {{-- Comment Access --}}
                                                <div class="mb-2">
                                                    <h2 class="card-title">Comment Access</h2>
                                                    <div class="col-12 px-3 d-flex justify-content-between">
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="comments_view"
                                                                id="comments_view" value="1"
                                                                @if ($permission->comments_view) checked @endif
                                                                class="form-check-input">
                                                            <label for="comments_view">View Comment</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="comments_delete"
                                                                id="comments_delete" value="1"
                                                                class="form-check-input"
                                                                @if ($permission->comments_delete) checked @endif>
                                                            <label for="comments_delete">Delete Comment</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="comments_block"
                                                                id="comments_block" value="1"
                                                                class="form-check-input"
                                                                @if ($permission->comments_block) checked @endif>
                                                            <label for="comments_block">Block Comment</label>
                                                        </div>

                                                    </div>
                                                </div>

                                                {{-- Hashtag Access --}}
                                                <div class="mb-2">
                                                    <h2 class="card-title">Hashtag Access</h2>
                                                    <div class="col-12 px-3 d-flex justify-content-between">
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="hashtag_view" id="hashtag_view"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->hashtag_view) checked @endif />
                                                            <label for="hashtag_view">View Hash Tags</label>
                                                        </div>
                                                    </div>

                                                </div>

                                                {{-- Sound Access --}}
                                                <div class="mb-2">
                                                    <h2 class="card-title">Sound Access</h2>
                                                    <div class="col-12 px-3 d-flex justify-content-between">
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="sound_view" id="sound_view"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->sound_view) checked @endif />
                                                            <label for="sound_view">View Sound</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="sound_delete" id="sound_delete"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->sound_delete) checked @endif>
                                                            <label for="sound_delete">Delete Sound</label>
                                                        </div>
                                                        <div class="form-check col">
                                                        </div>

                                                    </div>
                                                </div>

                                                {{-- Activity Access --}}
                                                <div class="mb-2">
                                                    <h2 class="card-title">Activity Access</h2>
                                                    <div class="col-12 px-3 d-flex justify-content-between">
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="activity_view"
                                                                id="activity_view" value="1"
                                                                class="form-check-input"
                                                                @if ($permission->activity_view) checked @endif>
                                                            <label for="activity_view">View Activity</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="activitylevels_view"
                                                                id="activitylevels_view" value="1"
                                                                class="form-check-input"
                                                                @if ($permission->activitylevels_view) checked @endif>
                                                            <label for="activitylevels_view">View Activity Level</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="activitylevels_add"
                                                                id="activitylevels_add" value="1"
                                                                class="form-check-input"
                                                                @if ($permission->activitylevels_add) checked @endif>
                                                            <label for="activitylevels_add">Add Activity Level</label>
                                                        </div>

                                                    </div>
                                                    <div class="col-12 px-3 pt-2 d-flex justify-content-between">

                                                        <div class="form-check col">
                                                            <input type="checkbox" name="activitylevels_edit"
                                                                id="activitylevels_edit" value="1"
                                                                class="form-check-input"
                                                                @if ($permission->activitylevels_edit) checked @endif>
                                                            <label for="activitylevels_edit">Edit Activity Level</label>
                                                        </div>

                                                    </div>

                                                </div>

                                                {{-- Reward Access --}}
                                                <div class="mb-2">
                                                    <h2 class="card-title">Reward Access</h2>
                                                    <div class="col-12 px-3 d-flex justify-content-between">
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="reward_view" id="reward_view"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->reward_view) checked @endif>
                                                            <label for="reward_view">View Reward</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="reward_add" id="reward_add"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->reward_add) checked @endif>
                                                            <label for="reward_add">Add Reward</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="reward_edit" id="reward_edit"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->reward_edit) checked @endif>
                                                            <label for="reward_edit">Edit Reward</label>
                                                        </div>

                                                    </div>
                                                </div>

                                                {{-- Banner Access --}}
                                                <div class="mb-2">
                                                    <h2 class="card-title">Banner Access</h2>
                                                    <div class="col-12 px-3 d-flex justify-content-between">
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="banner_view" id="banner_view"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->banner_view) checked @endif>
                                                            <label for="banner_view">View Banner</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="banner_add" id="banner_add"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->banner_add) checked @endif>
                                                            <label for="banner_add">Add Banner</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="banner_delete"
                                                                id="banner_delete" value="1"
                                                                class="form-check-input"
                                                                @if ($permission->banner_delete) checked @endif>
                                                            <label for="banner_delete">Edit Banner</label>
                                                        </div>

                                                    </div>
                                                </div>

                                                {{-- Currency Access --}}
                                                <div class="mb-2">
                                                    <h2 class="card-title">Currency Access</h2>
                                                    <div class="col-12 px-3 d-flex justify-content-between">
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="currency_view"
                                                                id="currency_view" value="1"
                                                                class="form-check-input"
                                                                @if ($permission->currency_view) checked @endif>
                                                            <label for="currency_view">View Currency</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="currency_add" id="currency_add"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->currency_add) checked @endif>
                                                            <label for="currency_add">Add Currency</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="currency_delete"
                                                                id="currency_delete" value="1"
                                                                class="form-check-input"
                                                                @if ($permission->currency_delete) checked @endif>
                                                            <label for="currency_delete">Delete Currency</label>
                                                        </div>

                                                    </div>
                                                    <div class="col-12 px-3 pt-2 d-flex justify-content-between">
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="network_view" id="network_view"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->network_view) checked @endif>
                                                            <label for="network_view">View Network</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="network_add" id="network_add"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->network_add) checked @endif>
                                                            <label for="network_add">Add Network</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="network_edit" id="network_edit"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->network_edit) checked @endif>
                                                            <label for="network_edit">Edit Network</label>
                                                        </div>

                                                    </div>
                                                </div>

                                                {{-- CMS Access --}}
                                                <div class="mb-2">
                                                    <h2 class="card-title">CMS Access</h2>
                                                    <div class="col-12 px-3 d-flex justify-content-between">
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="cms_view" id="cms_view"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->cms_view) checked @endif>
                                                            <label for="cms_view">View CMS</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="cms_edit" id="cms_edit"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->cms_edit) checked @endif>
                                                            <label for="cms_edit">Edit CMS</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="cms_delete" id="cms_delete"
                                                                value="1" class="form-check-input"
                                                                @if ($permission->cms_delete) checked @endif>
                                                            <label for="cms_delete">Delete CMS</label>
                                                        </div>
                                                    </div>

                                                </div>

                                                {{-- Site Setting Access --}}
                                                <div class="mb-2">
                                                    <h2 class="card-title">Site Setting Access</h2>
                                                    <div class="col-12 px-3 d-flex justify-content-between">
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="sitesetting_view"
                                                                id="sitesetting_view" value="1"
                                                                class="form-check-input"
                                                                @if ($permission->sitesetting_view) checked @endif>
                                                            <label for="sitesetting_view">View Site Setting</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="sitesetting_edit"
                                                                id="sitesetting_edit" value="1"
                                                                class="form-check-input"
                                                                @if ($permission->sitesetting_edit) checked @endif>
                                                            <label for="sitesetting_edit">Edit Site Setting</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="changepassword"
                                                                id="changepassword" value="1"
                                                                class="form-check-input"
                                                                @if ($permission->changepassword) checked @endif>
                                                            <label for="changepassword">Change Password</label>
                                                        </div>

                                                    </div>
                                                    <div class="col-12 px-3 pt-2 d-flex justify-content-between">
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="set_notification"
                                                                id="set_notification" value="1"
                                                                class="form-check-input"
                                                                @if ($permission->set_notification) checked @endif>
                                                            <label for="set_notification">Set Notification</label>
                                                        </div>


                                                    </div>
                                                </div>

                                                {{-- With drawal Access --}}
                                                <div class="mb-2">
                                                    <h2 class="card-title">Wallet Access</h2>
                                                    <div class="col-12 px-3 d-flex justify-content-between">
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="withdrawal_view"
                                                                id="withdrawal_view" value="1"
                                                                class="form-check-input"
                                                                @if ($permission->withdrawal_view) checked @endif>
                                                            <label for="withdrawal_view">View History</label>
                                                        </div>
                                                        <div class="form-check col">
                                                            <input type="checkbox" name="withdrawal_edit"
                                                                id="withdrawal_edit" value="1"
                                                                class="form-check-input"
                                                                @if ($permission->withdrawal_edit) checked @endif>
                                                            <label for="withdrawal_edit">Edit Wallet</label>
                                                        </div>
                                                        <div class="form-check col">
                                                        </div>
                                                    </div>
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
