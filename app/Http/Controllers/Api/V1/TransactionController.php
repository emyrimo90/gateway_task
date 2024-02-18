<?php

namespace App\Http\Controllers\Api\V1;

use App\Facades\Payment;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use App\Traits\BaseApiResponseTrait;
use App\Http\Resources\TransactionResource;
use App\Http\Requests\Api\V1\TransactionRequest;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\Contracts\TransactionContract;
use App\Exceptions\GatewayConfigurationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TransactionController extends BaseApiController
{
    use BaseApiResponseTrait;

    /**
     * @param TransactionContract $repository
     */
    public function __construct(TransactionContract $repository)
    {
        parent::__construct($repository, TransactionResource::class);
    }

    /**
     * @param Transaction $transaction
     * @return mixed
     */
    public function show(Transaction $transaction): mixed
    {
        return $this->respondWithModel($transaction);
    }

    /**
     * @param TransactionRequest $request
     * @return JsonResponse
     * @throws GatewayConfigurationException
     */
    public function processTransaction(TransactionRequest $request): JsonResponse
    {
        $response = Payment::processRequest($request->validated());
        $response['data']['user_id'] = auth('api')->id();
        logger()?->channel('transactions.info')->info("Processed Transaction", ['result' => $response]);
        if ($response['status'] == 200) {
            $response['message'] = __("you_will_redirect_to_gateway_to_pay");
        }
        $this->repository->create($response['data']);
        return response()->json($response, $response['status']);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function successTransaction(Request $request): RedirectResponse
    {
        $response = Payment::successTransaction($request->all());
        logger()?->channel('transactions.info')->info("Success Transaction", ['result' => $response]);
        $transaction = app(TransactionContract::class)->findBy('trace_id', $response['data']['id']);
        $transaction->update([
            'status' => $response['data']['status'],
            'comment' => $response['status'] == 200 ? "Transaction Complete" : $response['message'] ?? 'Something went wrong.'
        ]);
        return redirect()->away(url("/transactions/{$transaction->id}"));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function cancelTransaction(Request $request): RedirectResponse
    {
        $token = $request->token;
        if ($token) {
            $transaction = app(TransactionContract::class)->findBy('trace_id', $token);
            logger()?->channel('transactions.info')->info("Cancel Transaction", ['result' => $request->all()]);
            $transaction->update([
                'status' => Transaction::STATUS_CANCELED,
                'comment' => $response['message'] ?? 'You have canceled the transaction.'
            ]);
            return redirect()->away(url("/transactions/{$transaction->id}"));
        }
        return redirect()->away(url("/transactions"));
    }


}
