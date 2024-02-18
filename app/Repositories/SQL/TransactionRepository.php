<?php

namespace App\Repositories\SQL;

use App\Models\Transaction;
use App\Repositories\Contracts\TransactionContract;
use Carbon\Carbon;

class TransactionRepository extends BaseRepository implements TransactionContract
{
    /**
     * PaymentRepository constructor.
     * @param Transaction $model
     */
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }

    public function create($requests = []): mixed
    {
        return $this->model->create([
            'trace_id'=> $requests['id']??'',
            'status'=> $requests['status']??'',
            'payment_status'=> $requests['payment_status']??'',
            'currency'=>$requests['currency']??'USD',
            'amount'=> $requests['amount_total']??'',
            'paid_at'=> Carbon::parse($requests['created']??'')->format('Y-m-d H:i:s'),
            'user_id'=> $requests['user_id'],
            'gateway_setting_id'=> $requests['gateway_setting_id'],
        ]);
    }


}
