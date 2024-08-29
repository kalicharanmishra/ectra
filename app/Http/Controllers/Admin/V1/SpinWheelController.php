<?php

namespace App\Http\Controllers\Admin\V1;

use App\Models\Level;
use App\Models\Activity;
use App\Models\Permission;
use App\Models\SpinReward;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Currency;

class SpinWheelController extends Controller
{
    public function activites()
    {
       
        $activities = Activity::get();
        return view('admin.v1.spinwheel.activites', compact('activities'));
    }

    public function rewards()
    {
        $permission = Permission::where('sub_admin_id', Auth()->user()->id)->first();

        if (Auth()->user()->role == 3) {

            if (!$permission->reward_view) {
                return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');
            }
        }

        $rewards = SpinReward::get();
        return view('admin.v1.spinwheel.rewards', compact('rewards', 'permission'));
    }

    public function getActivityLevels($activity_id)
    {
        $permission = Permission::where('sub_admin_id', Auth()->user()->id)->first();
        if (Auth()->user()->role == 3) {
            if (!$permission->activitylevels_view) {
                return redirect(route('admin.v1.spinWheel.activites'))->with('message', 'You don\'t have this section permission');
            }
        }

        $levels = Level::with('level_activity')->where('activity_id', $activity_id)->get();
        $activity = Activity::where('id', $activity_id)->first();
        return view('admin.v1.spinwheel.levels', compact('levels', 'activity', 'permission'));
    }

    public function addLevel($activity_id)
    {
        $permission = Permission::where('sub_admin_id', Auth()->user()->id)->first();
        if (Auth()->user()->role == 3) {
            if (!$permission->activitylevels_add) {
                return redirect(route('admin.v1.spinWheel.activitylevels'))->with('message', 'You don\'t have this section permission');
            }
        }
        $levels = Level::with('level_activity')->where('activity_id', $activity_id)->get();
        $activity = Activity::find($activity_id);
        return view('admin.v1.spinwheel.addlevel', compact('levels', 'activity', 'permission'));
    }

    public function addLevelSubmit(Request $request, $activity_id)
    {
        $this->validate($request, [
            'level_name'        =>  'required|alpha_num|min:1|max:255|unique:levels,name',
            'spin_reward'       =>  'required|numeric|max:100|gt:0',
            'likes'             =>  'nullable|numeric|max:99999999999999999999999999999999999999999999999|required_without_all:views, invites|gt:0',
            'views'             =>  'nullable|numeric|max:99999999999999999999999999999999999999999999999|required_without_all:likes, invites|gt:0',
            'invites'           =>  'nullable|numeric|max:99999999999999999999999999999999999999999999999|required_without_all: views,likes|gt:0',
            'followers'         =>  'nullable|numeric|max:99999999999999999999999999999999999999999999999',
            'signup'            =>  [
                'nullable',
                Rule::In(['Yes', 'No'])
            ],
            'video_post'        =>  [
                'nullable',
                Rule::In(['Yes', 'No'])
            ],
        ]);

        $levelObj = new Level;
        $levelObj->activity_id  =   $activity_id;
        $levelObj->name         =   $request->level_name;
        $levelObj->spin_reward  =   $request->spin_reward ?? 0;
        $levelObj->likes        =   $request->likes ?? 0;
        $levelObj->views        =   $request->views ?? 0;
        $levelObj->invites      =   $request->invites ?? 0;
        $levelObj->followers    =   $request->followers ?? 0;
        $levelObj->signup       =   $request->signup ?? 'No';
        $levelObj->line_order   =   $request->line_order ?? 0;
        $levelObj->video_post   =   $request->video_post ?? 'No';
        $levelObj->save();
        return redirect()->route('admin.v1.spinWheel.activitylevels', ['activity_id' => $activity_id]);
    }

    public function updateLevel($activity_id, $level_id)
    {
        $permission = Permission::where('sub_admin_id', Auth()->user()->id)->first();
        if (Auth()->user()->role == 3) {
            if (!$permission->activitylevels_edit) {
                return redirect(route('admin.v1.spinWheel.activitylevels'))->with('message', 'You don\'t have this section permission');
            }
        }
        $activity = Activity::find($activity_id);
        $level = Level::find($level_id);
        return view('admin.v1.spinwheel.updatelevel', compact('activity', 'level', 'permission'));
    }
    public function updateLevelSubmit(Request $request, $activity_id, $level_id)
    {
        $this->validate($request, [
            'level_name'        =>  [
                'required',
                'alpha_num',
                'min:1',
                'max:255'
            ],
            'spin_reward'       =>  'required|numeric|max:100|gt:0',
            'likes'             =>  'nullable|numeric|max:99999999999999999999999999999999999999999999999|required_without_all:views, invites',
            'views'             =>  'nullable|numeric|max:99999999999999999999999999999999999999999999999|required_without_all:likes, invites',
            'invites'           =>  'nullable|numeric|max:99999999999999999999999999999999999999999999999|required_without_all:likes, views',
            'followers'         =>  'nullable|numeric|max:99999999999999999999',
            'signup'            =>  [
                'nullable',
                Rule::In(['Yes', 'No'])
            ],
            'video_post'        =>  [
                'nullable',
                Rule::In(['Yes', 'No'])
            ],
        ]);
        $input = $request->all();
        $input['name'] = $input['level_name'];
        unset($input['_token']);
        unset($input['level_name']);
        Level::where('id', $level_id)->update($input);
        return redirect()->route('admin.v1.spinWheel.activitylevels', ['activity_id' => $activity_id]);
    }

    public function addReward()
    {
        $permission = Permission::where('sub_admin_id', Auth()->user()->id)->first();
        if (Auth()->user()->role == 3) {
            if (!$permission->reward_add) {
                return redirect(route('admin.v1.spinWheel.rewards'))->with('message', 'You don\'t have this section permission');
            }
        }
        $currencies = Currency::get();
        return view('admin.v1.spinwheel.addreward', compact('permission', 'currencies'));
    }

    public function addRewardSubmit(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            'currency' => 'required',
            'probability_percentage' => 'required'
        ]);

        // validate overall probability_percentage should not exceed 100%
        $total_prob_per = DB::table('spin_rewards')
            ->select(DB::raw('SUM(probability) as total'))
            ->first();

        if (isset($total_prob_per->total) && ($total_prob_per->total + $request->probability_percentage) > 100) {
            $request->session()->flash('error', 'Overall probability for all spin rewards cannot exceed 100%');
            return redirect()->route('admin.v1.spinWheel.addReward');
        }

        $currency = Currency::where('code', strtoupper($request->currency))->first();

        $SpinRewardObj = new SpinReward;
        $SpinRewardObj->amount = $request->amount;
        $SpinRewardObj->currency = $request->currency;
        $SpinRewardObj->currency_symbol = $currency->symbol ?? NULL;
        if (empty($currency->symbol) && !empty($currency->image)) {
            $SpinRewardObj->is_image = 1;
            $SpinRewardObj->image_path = $currency->image;            
            $SpinRewardObj->save();
        }
        $SpinRewardObj->probability = $request->probability_percentage;
        $SpinRewardObj->save();

        $request->session()->flash('success', 'New spin reward has been added successfully.');
        return redirect()->route('admin.v1.spinWheel.rewards');
    }

    public function editReward($id)
    {
        $permission = Permission::where('sub_admin_id', Auth()->user()->id)->first();
        if (Auth()->user()->role == 3) {
            if (!$permission->reward_edit) {
                return redirect(route('admin.v1.spinWheel.rewards'))->with('message', 'You don\'t have this section permission');
            }
        }

        $currencies = Currency::select('id', 'code')->get();
        $SpinRewardObj = SpinReward::where('id', $id)->select('amount', 'probability', 'currency')->first();
        return view('admin.v1.spinwheel.editreward', compact('SpinRewardObj', 'id', 'permission', 'currencies'));
    }
    public function editRewardSubmit(Request $request, $id)
    {
        $SpinRewardObj = SpinReward::find($id);
        $this->validate($request, [
            'amount' => 'nullable',
            'probability' => 'nullable'
        ]);
        if (!empty($request->probability)) {
            $SpinRewardObj->probability = $request->probability;
            $SpinRewardObj->save();
        }
        if (!empty($request->amount)) {
            $SpinRewardObj->amount = $request->amount;
            $SpinRewardObj->save();
        }
        if (!empty($request->currency)) {
            $SpinRewardObj->currency = $request->currency;
            $SpinRewardObj->save();
        }
        return redirect()->route('admin.v1.spinWheel.rewards');
    }

    // public function block($id, $action)
    // {
    //     $action = ($action == 'block') ? 0 : 1;
    //     $videoObj = Video::find($id);
    //     $videoObj->is_enabled = $action;
    //     $videoObj->save();
    //     return redirect()->back();
    // }
}
