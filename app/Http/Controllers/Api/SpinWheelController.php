<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\UserSpinReward;
use App\Models\UserWheelChance;
use App\Models\SpinReward;
use App\Models\Activity;
use App\Models\Follower;
use App\Models\Level;
use App\Models\User;
use App\Models\UserActivityCounter;
use App\Models\UserMeta;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class SpinWheelController extends ApiController
{
    public function listData()
    {
        $recent_rewards_rsp = [];
        $recent_rewards = UserSpinReward::with('spin_reward')->limit(2)->orderByDesc('id')->get();
        foreach ($recent_rewards as $reward) {
            $recent_rewards_rsp[] = [
                'username'          => User::where('id', $reward->user_id)->first()->name ?? '',
                'amount'            => SpinReward::where('id', $reward->spin_reward_id)->first()->amount ?? '',
                'currency'          => SpinReward::where('id', $reward->spin_reward_id)->first()->currency ?? '',
                'currency_symbol'   => SpinReward::where('id', $reward->spin_reward_id)->first()->currency_symbol ?? ''
            ];
        }

        $userLastReward = UserSpinReward::with('spin_reward')->where('user_id', Auth::user()->id)->orderByDesc('id')->first();

        // return response()->json($userLastReward);

        if (isset($userLastReward->spin_reward)) {
            $last_reward = (string)$userLastReward->spin_reward->amount . ' ' . $userLastReward->spin_reward->currency;
        } else {
            $last_reward = (string)0;
        }

        $response = [
            'recent_rewards' => $recent_rewards_rsp,
            'available_chance' => (string) $this->get_user_available_chance(Auth::user()->id) ?? '0',
            'used_chance' => (string)$this->get_user_used_chance(Auth::user()->id) ?? '0',
            'last_reward' => $last_reward,
            'wheel_rewards' => SpinReward::get()
        ];
        $this->status = true;
        $this->message = "OK";
        $this->data = $response;
        return $this->jsonView();
    }
    public function earnedSpin()
    {
        $user_levels = UserMeta::where('user_id', Auth::user()->id)->where('meta_key', 'user_levels')->first();
        $user_levels_de = json_decode($user_levels->meta_value);

        $response = [];
        $activities = Activity::get();
        foreach ($activities as $activity) {
            $progress = 0;
            if ($activity->name == "creators") {
                $curren_level_arr = explode(',', $user_levels_de->creators->current_level);
                $next_level_arr = explode(',', $user_levels_de->creators->next_level);
                $curren_level = $curren_level_arr[count($curren_level_arr) - 1];
                $next_level = $next_level_arr[count($next_level_arr) - 1];
                $next_level_details = Level::find($next_level);
                $current_level_name = Level::find($curren_level)->name ?? '0';
                $next_level_name = Level::find($next_level)->name ?? '1';
                if (!isset($next_level_details->likes) || $next_level_details->likes == 0) {
                    $conditions = "Get {$next_level_details->followers} followers and video post at least (Current Month from 1st date to last)";
                    $final_target = $next_level_details->followers;
                    $current_followers = $this->get_followers_current_month(Auth::user()->id);
                    if ($final_target <= 0) {
                        $progress = 0;
                    } else {
                        $progress = (int)round(($current_followers / $final_target) * 10);
                    }
                } else {
                    $conditions = "Get {$next_level_details->likes} total likes (Current Month from 1st date to last)";
                    $final_target = $next_level_details->likes;
                    $current_likes = $this->get_current_likes(Auth::user()->id);
                    if ($final_target <= 0) {
                        $progress = 0;
                    } else {
                        $progress = (int)round(($current_likes / $final_target) * 10);
                    }
                }
                $earned_spins = (string)$user_levels_de->creators->earned_spin ?? 0;
                $total_spins_data = DB::table('levels')
                    ->select(DB::raw('SUM(spin_reward) as spin'))
                    ->where('activity_id', 1)
                    ->first();
                $total_spins = $total_spins_data->spin;
            } else if ($activity->name == "viewers") {
                $curren_level_arr = explode(',', $user_levels_de->viewers->current_level);
                $next_level_arr = explode(',', $user_levels_de->viewers->next_level);
                $curren_level = $curren_level_arr[count($curren_level_arr) - 1];
                $next_level = $next_level_arr[count($next_level_arr) - 1];
                $next_level_details = Level::find($next_level);
                if (empty($next_level_details)) {
                    $next_level_details = Level::where('activity_id', 2)->orderByDesc('id')->first();
                }
                $current_level_name = Level::find($curren_level)->name ?? '0';
                $next_level_name = Level::find($next_level)->name ?? '1';
                $conditions = "Get {$next_level_details->views} total views (Current Month from 1st date to last)";
                $final_target = $next_level_details->views;
                $current_views = $this->get_current_views(Auth::user()->id);
                if ($final_target <= 0) {
                    $progress = 0;
                } else {
                    $progress = (int)round(($current_views / $final_target) * 10);
                }
                $earned_spins = (string)$user_levels_de->viewers->earned_spin ?? 0;
                $total_spins_data = DB::table('levels')
                    ->select(DB::raw('SUM(spin_reward) as spin'))
                    ->where('activity_id', 2)
                    ->first();
                $total_spins = $total_spins_data->spin;
            } else if ($activity->name == "referrals") {
                $curren_level_arr = explode(',', $user_levels_de->referrals->current_level);
                $next_level_arr = explode(',', $user_levels_de->referrals->next_level);
                $curren_level = $curren_level_arr[count($curren_level_arr) - 1];
                $next_level = $next_level_arr[count($next_level_arr) - 1];
                $next_level_details = Level::find($next_level);
                $current_level_name = Level::find($curren_level)->name ?? '0';
                $next_level_name = Level::find($next_level)->name ?? '1';
                if (empty($next_level_details)) {
                    $next_level_details = Level::where('activity_id', 3)->orderByDesc('id')->first();
                }
                $conditions = "Get {$next_level_details->invites} total referral (Current Month from 1st date to last)";
                $earned_spins = (string)$user_levels_de->referrals->earned_spin ?? 0;
                $final_target = $next_level_details->invites;
                $current_invites = $this->get_current_invites(Auth::user()->id);
                if ($final_target <= 0) {
                    $progress = 0;
                } else {
                    $progress = (int)round(($current_invites / $final_target) * 10);
                }

                $total_spins_data = DB::table('levels')
                    ->select(DB::raw('SUM(spin_reward) as spin'))
                    ->where('activity_id', 3)
                    ->first();
                $total_spins = $total_spins_data->spin;
            }

            $creators_levels_a = Level::where('activity_id', $activity->id)->count();
            $response['activities'][] = [
                'name' => $activity->name,
                'current_level' => $current_level_name,
                'next_level' => $next_level_name,
                'conditions' => $conditions,
                'earned_spins' => empty($earned_spins) ? '0' : $earned_spins,
                'total_spin' => $total_spins,
                'max_level' => (string)$creators_levels_a ?? '0',
                'progress' => $progress > 10 ? 10 : $progress
            ];
        }
        $this->status = true;
        $this->message = "OK";
        $this->data = $response;
        return $this->jsonView();
    }

    public function rewardWon(Request $request)
    {
        $rule = [
            'reward_id' => 'required|exists:spin_rewards,id',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {

            // check if spin is available
            $available_spin = $this->get_user_available_chance(Auth::user()->id);
            if ($available_spin <= 0) {
                $this->status = false;
                $this->error = true;
                $this->message = "No spin change available for you.";
                return $this->jsonView();
            }

            // total counter left for specific reward
            $total_reward_counter_left = DB::table('spin_rewards')
                ->select(DB::raw('SUM(probability_counter) as total'))
                ->where('id', $request->reward_id)
                ->first();

            // no turn left
            if ($total_reward_counter_left->total <= 0) {
                $this->status = false;
                $this->error = true;
                $this->message = "This reward expired.";
                return $this->jsonView();
            }

            $userSpinRewardObj = new UserSpinReward();
            $userSpinRewardObj->user_id = Auth::user()->id;
            $userSpinRewardObj->spin_reward_id = $request->reward_id;
            $userSpinRewardObj->save();

            // total couter left
            $total_counter_left = DB::table('spin_rewards')
                ->select(DB::raw('SUM(probability_counter) as total'))
                ->first();

            if ($total_counter_left->total <= 0) {
                // reset counter
                $rewards = SpinReward::get();
                foreach ($rewards as $reward) {
                    $SpinRewardObj = SpinReward::find($reward->id);
                    $SpinRewardObj->probability_counter = $reward->probability;
                    $SpinRewardObj->save();
                }
            }

            // descrease counter
            $SpinRewardObjDe = SpinReward::find($request->reward_id);
            if ($SpinRewardObjDe->probability_counter > 0) {
                $SpinRewardObjDe->probability_counter = $SpinRewardObjDe->probability_counter - 1;
            } else {
                $SpinRewardObjDe->probability_counter = 0;
            }
            $SpinRewardObjDe->save();

            // update user earned spin
            $user_levels = UserMeta::where('user_id', Auth::user()->id)
                ->where('meta_key', 'user_levels')
                ->first();
            $user_levels_de = json_decode($user_levels->meta_value);
            foreach ($user_levels_de as $key => $user_level) {
                if ($user_level->used_spin <= $user_level->earned_spin) {
                    // update
                    $user_levels_de->$key->used_spin = (int) $user_levels_de->$key->used_spin + 1;
                    $UserMetaObj = UserMeta::where('user_id', Auth::user()->id)
                        ->where('meta_key', 'user_levels')
                        ->first();
                    $UserMetaObj->meta_value = json_encode($user_levels_de);
                    $UserMetaObj->save();
                    break;
                }
            }

            /**
             * Update wallet when someone won reward
             */
            $reward_detail = SpinReward::find($request->reward_id);
            if (isset($reward_detail->id)) {
                $currency = $reward_detail->currency;
                $amount = $reward_detail->amount;

                // check if wallet created or not
                $user_wallet = Wallet::where('user_id', Auth::user()->id)->where('amount_currency', $currency)->first();
                if (!isset($user_wallet->id)) {
                    // create currency wallet and add money
                    $WalletObj = new Wallet;
                    $WalletObj->user_id = Auth::user()->id;
                    $WalletObj->amount = $amount;
                    $WalletObj->amount_currency = $currency;
                    $WalletObj->save();
                } else {
                    // Now update wallet
                    $user_wallet->amount = $user_wallet->amount + $amount;
                    $user_wallet->save();
                }
            }

            // send back response
            $this->status = true;
            $this->message = "Congratus you won {$reward_detail->amount} {$currency}.";
            $this->data = [
                'available_chance' => (string)$this->get_user_available_chance(Auth::user()->id),
                'used_chance' => (string)$this->get_user_used_chance(Auth::user()->id)

            ];
        }
        return $this->jsonView();
    }

    public function CounterData()
    {

        $total_counter_left = DB::table('spin_rewards')
            ->select(DB::raw('SUM(probability_counter) as total'))
            ->first();

        if ($total_counter_left->total <= 0) {
            // reset counter
            $rewards = SpinReward::get();
            foreach ($rewards as $reward) {
                $SpinRewardObj = SpinReward::find($reward->id);
                $SpinRewardObj->probability_counter = $reward->probability;
                $SpinRewardObj->save();
            }
        }

        $rewards = SpinReward::select('id', 'probability_counter')
            ->where('probability_counter', '>', 0)
            ->get();
        $this->status = true;
        $this->error = false;
        $this->message = "OK";
        $this->data = $rewards;
        return $this->jsonView();
    }

    private function get_followers_current_month($user_id)
    {
        $followers = Follower::where('publisher_user_id', $user_id)->whereMonth('created_at', Carbon::now()->month)->get();
        if (!empty($followers)) {
            return count($followers);
        }
        return 0;
    }

    private function get_current_likes($user_id)
    {
        $UserActivityCounterObj = UserActivityCounter::where('user_id', $user_id)->whereMonth('created_at', Carbon::now()->month)->first();
        if (isset($UserActivityCounterObj->id)) {
            return $UserActivityCounterObj->like_counter;
        }
        return 0;
    }

    private function get_current_views($user_id)
    {
        $UserActivityCounterObj = UserActivityCounter::where('user_id', $user_id)->whereMonth('created_at', Carbon::now()->month)->first();
        if (isset($UserActivityCounterObj->id)) {
            return $UserActivityCounterObj->view_counter;
        }
        return 0;
    }

    private function get_current_invites($user_id)
    {
        $UserActivityCounterObj = UserActivityCounter::where('user_id', $user_id)->whereMonth('created_at', Carbon::now()->month)->first();
        if (isset($UserActivityCounterObj->id)) {
            return $UserActivityCounterObj->invite_counter;
        }
        return 0;
    }
}
