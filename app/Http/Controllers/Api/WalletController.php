<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Currency;
use App\Models\Network;
use App\Models\WalletTransaction;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class WalletController extends ApiController
{
    public function balance()
    {
        $currencies = Currency::select('id', 'code', 'symbol', 'image', 'is_active')->get();
        $response = [];
        foreach ($currencies as $currency) {
            $amount = Wallet::where('user_id', Auth::user()->id)->where('amount_currency', $currency->code)->select('amount')->first();
            $amount = $amount->amount ?? 0.00;
            $response[] = [
                'code' => $currency->code,
                'amount' => (float)number_format((float)$amount, 2, '.', ''),
                'symbol' => !empty($currency->symbol) ? $currency->symbol : null,
                'image' => !empty($currency->image) ? $currency->image : null,
                'is_active' => $currency->is_active,
                // 'network_name' => !empty($currency->network_name) ? $currency->network_name : null,
                'network_name' => "N/A",
                'min_amount' => 0,
                'max_amount' => 0,
                'fee_digit'  => 0
            ];
        }
        return response()->json([
            'status' => true,
            'error' => false,
            'message' => "OK",
            'data' => $response,
        ]);
    }

    public function withdraw(Request $request)
    {
        $rule = [
            'currency' => 'required',
            'address_upi' => 'required',
            'network_name' => 'required|exists:networks,network_name',
            'amount' => 'required',
            'network_fee' => 'required'
        ];
        if ($this->validateData($request->all(), $rule)) {

            // Check if currency code is valid
            $currency = Currency::where('code', strtoupper($request->currency))->first();
            if (!isset($currency->id)) {
                return response()->json([
                    'status' => false,
                    'error' => true,
                    'message' => "Currency code is not valid",
                    'data' => []
                ]);
            }

            // check if currency is active
            if (isset($currency->id) && $currency->is_active == 0) {
                return response()->json([
                    'status' => false,
                    'error' => true,
                    'message' => "Withdrawal for this currency is suspended. Try again later.",
                    'data' => []
                ]);
            }

            // check if amount withdraw greater than balance
            $wallet_balance = Wallet::where('user_id', Auth::user()->id)
                ->where('amount_currency', $request->currency)
                ->select('amount')
                ->first();

            $wallet_balance_amount = 0.00;
            if (!isset($wallet_balance->amount)) {
                $wallet_balance_amount = 0.00;
            } else {
                $wallet_balance_amount = $wallet_balance->amount;
            }

            // check if previous request if pending
            // $wallet_transaction = WalletTransaction::where('user_id', Auth::user()->id)
            //     ->whereIn('transaction_status', ['Pending', 'Processing'])
            //     ->first();
            // if (isset($wallet_transaction->id)) {
            //     return response()->json([
            //         'status' => false,
            //         'error' => true,
            //         'message' => "We cannot process your request currently. Either your previous request is pending or we processing pending request.",
            //         'data' => []
            //     ]);
            // }

            if ($request->amount > $wallet_balance_amount) {
                return response()->json([
                    'status' => false,
                    'error' => true,
                    'message' => "Insufficient balance",
                    'data' => []
                ]);
            }

            if ($request->amount < 1) {
                return response()->json([
                    'status' => false,
                    'error' => true,
                    'message' => "Insufficient amount",
                    'data' => []
                ]);
            }
            // $commission_fee = Setting::where('name', 'commission_fee')->first()->value;
            // $commission_amount = $request->amount * ($commission_fee / 100);

            $final_amount = $request->amount - $request->network_fee;
            $WalletTransactionObj = new WalletTransaction;
            $WalletTransactionObj->user_id = Auth::user()->id;
            $WalletTransactionObj->currency = $request->currency;
            $WalletTransactionObj->payment_address_user = $request->address_upi;
            $WalletTransactionObj->payment_network_user = $request->network_name;
            $WalletTransactionObj->commission_fee_amount = $request->network_fee;
            $WalletTransactionObj->amount = $final_amount;
            $WalletTransactionObj->save();

            return response()->json([
                'status' => true,
                'message' => "Your withdraw request has been submitted successfully.",
                'error' => false,
                'data' => []
            ]);
        }
        return $this->jsonView();
    }
    public function withdrawHistory()
    {
        $wallet_transactions = WalletTransaction::where('user_id', Auth::user()->id)
            ->where('transaction_type', 'withdraw')
            ->orderByDesc('id')
            ->select('id', 'currency', 'payment_address_user', 'commission_fee_amount', 'amount', 'transaction_status', 'transaction_id', 'created_at')
            ->get();
        return response()->json([
            'status' => true,
            'message' => "Withdraw History.",
            'error' => false,
            'data' => $wallet_transactions ?? []
        ]);
    }
}
