<?php

namespace App\Http\Controllers\Admin\V1;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use App\Models\Wallet;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WithdrawalsController extends Controller
{
    public function list($user_id = null)
    {
        $withdrawals = WalletTransaction::where('transaction_type', 'withdraw')->get();
        if (isset($user_id) && !empty($user_id)) {
            $withdrawals = WalletTransaction::where('transaction_type', 'withdraw')->where('user_id', $user_id)->get();
        }

        $permission = Permission::where('sub_admin_id', Auth()->user()->id)->first();
        if (Auth()->user()->role == 3) {
            if (!$permission->withdrawal_view) {
                return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');
            }
        }
        return view('admin.v1.withdrawals.list', compact('withdrawals', 'permission'));
    }
    public function edit($id)
    {
        $permission = Permission::where('sub_admin_id', Auth()->user()->id)->first();

        if (Auth()->user()->role == 3) {

            if (!$permission->withdrawal_edit) {
                return redirect(route('admin.v1.withdraw.list'))->with('message', 'You don\'t have this section permission');
            }
        }

        $withdrawal = WalletTransaction::find($id);
        return view('admin.v1.withdrawals.edit', compact('withdrawal', 'permission'));
    }
    public function editSubmit(Request $request, $id)
    {

        $transaction_status = (isset($request->transaction_status)) ? $request->transaction_status : '';
        $transaction_id = (isset($request->transaction_id)) ? $request->transaction_id : '';
        $WalletTransactionObj = WalletTransaction::find($id);
        if($WalletTransactionObj->transaction_status == "Completed"){
            return redirect()->route('admin.v1.withdraw.list');    
        }
        $WalletTransactionObj->transaction_status = $transaction_status;
        $WalletTransactionObj->transaction_id = $transaction_id;
        $WalletTransactionObj->save();

        // Update user wallet :
        if ($WalletTransactionObj->transaction_status == 'Completed') {
            $transaction_currency = $WalletTransactionObj->currency;
            $wallet_amount = Wallet::where('user_id', $WalletTransactionObj->user_id)->where('amount_currency', $transaction_currency)->latest()->first();                                    
            if (isset($wallet_amount->id)) {                
                $balance = $wallet_amount->amount;
                $wallet_amount->amount = $balance - $WalletTransactionObj->amount;                                
                $wallet_amount->save();
            }
        }
        return redirect()->route('admin.v1.withdraw.list');
    }
}
