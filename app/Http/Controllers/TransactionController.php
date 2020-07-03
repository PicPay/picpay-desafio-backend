<?php

namespace App\Http\Controllers;

use App\Services\AuthorizatorService;
use App\Services\NotificationService;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionController extends Controller
{

    private $authorizatorService;
    private $notificationService;

    public function __construct()
    {
        $this->authorizatorService = AuthorizatorService::getInstance();
        $this->notificationService = NotificationService::getInstance();
    }

    public function execute(Request $request)
    {
        try {
            $this->applyValidations($request);

            $transactionData = $request->only(['value', 'payer', 'payee']);
            $authorized = $this->authorizatorService->authorize($transactionData);

            if (!$authorized) {
                throw new \Exception('Access denied!');
            }

            $transactionId = Transaction::execute($transactionData);

            $notified = $this->notificationService->notifyTransactionSuccess($transactionData);

            if (!$notified) {
                throw new \Exception('Problem to notify payment!');
            }

            return response()->json([
                'message' => 'Transaction created with success!',
                'code' => Response::HTTP_CREATED,
                'transactionId' => $transactionId
            ], Response::HTTP_CREATED);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    private function applyValidations(Request $request)
    {
        $this->validate($request, [
            'value' => 'required|numeric',
            'payer' => 'required|numeric',
            'payee' => 'required|numeric'
        ]);

        $this->validateNotFoundUser($request);
        $this->validateSameUsers($request);
        $this->validarItsStorePayer($request);
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    private function validateNotFoundUser(Request $request): void
    {
        $usersIds = $request->only(['payer', 'payee']);
        $notFoundUsers = User::verifyNotFoundUsers($usersIds);
        if (!empty($notFoundUsers)) {
            $notFoundUsers = implode(" and ", $notFoundUsers);
            throw new \Exception("$notFoundUsers not found!");
        }
    }

    private function validateSameUsers(Request $request): void
    {
        $users = $request->only(['payer', 'payee']);

        if ($users['payer'] == $users['payee']) {
            throw new \Exception("Payer and payee user are the same, this isn't allowed!");
        }
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    private function validarItsStorePayer(Request $request): void
    {
        $userPayerId = $request->get('payer');
        if (!User::canDoTransaction($userPayerId)) {
            throw new \Exception('Stores cannot conduct transactions!');
        }
    }
}
