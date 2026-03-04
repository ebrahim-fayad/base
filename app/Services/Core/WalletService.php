<?php

namespace App\Services\Core;

use App\Enums\WalletTransactionEnum;
use App\Models\AllUsers\User;
use App\Services\Payment\MyFatoorahService;
use App\Traits\ResponseTrait;
use Hashids;
use Illuminate\Support\Facades\DB;

class WalletService
{

    use ResponseTrait;

    /**
     * Charge the user's wallet online.
     *
     * @param array $request The request data.
     * @param User $user The user object.
     * @return mixed           The response data.
     */
    public function chargeWalletOnline($request, $user)
    {
        $wallet = $user->wallet;
        if (!isset($wallet)) {
            $wallet = $user->wallet()->create();
        }
        if (isset($request['methodId'])) {
            $data = [
                'redirect_url' => $request['redirect_url'],
                'purpose'      => 'wallet',
                'wallet_id'    => Hashids::encode($wallet->id),
            ];
            $url = (new MyFatoorahService())->executePayment($request, $data)['Data']['PaymentURL'];
            return ['key' => 'success', 'msg' => __('apis.payment_success'), 'data' => ['paymentURL' => $url], 'code' => 200];
        }
        return ['key' => 'fail', 'msg' => __('apis.payment_failed'), 'data' => [], 'code' => 500];
    }


    public function charge($wallet, $request, $user = null): array
    {
        $user ?: $user = auth()->user();
        $balance = is_array($request) ? $request['amount'] : $request;
        if (!isset($wallet)) {
            $wallet = $user->wallet()->create();
        }

        $wallet->increment('balance', $balance);
        $wallet->increment('available_balance', $balance);

        $wallet->transactions()->create([
            'type'           => WalletTransactionEnum::CHARGE,
            'amount'         => $balance,
            'transaction_id' => isset($request['transaction_id']) ? $request['transaction_id'] : null
        ]);
        return [
            'key'  => 'success',
            'msg'  => __('apis.wallet_charged'),
            'data' => []
        ];
    }

    public function debt($wallet, $balance): array
    {
        DB::beginTransaction();
        try {
            if ($wallet->available_balance < $balance) {
                return ['key' => 'fail', 'msg' => __('apis.not_enough_balance'), 'code' => 400, 'data' => []];
            }
            $wallet->decrement('balance', $balance);
            $wallet->decrement('available_balance', $balance);
            $wallet->increment('debt_balance', $balance);

            $wallet->transactions()->create([
                'type'   => WalletTransactionEnum::DEBT,
                'amount' => $balance
            ]);
            DB::commit();
            return ['key' => 'success', 'msg' => __('apis.PaidSuccessfully'), 'code' => 200, 'data' => []];
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
//            return ['key' => 'fail', 'msg' => $e->getMessage(), 'code' => 500];
        }
    }
    public function refund($user, $amount): array
    {
        $wallet = $user->wallet;
        if (!isset($wallet)) {
            $wallet = $user->wallet()->create();
        }
        $wallet->increment('balance', $amount);
        $wallet->increment('available_balance', $amount);
        return ['key' => 'success', 'msg' => __('apis.success'), 'code' => 200, 'data' => []];
    }

}
