<?php

namespace App\Controller;

use App\Form\CreateTransactionType;
use App\PaymentTransactions\CreateTransactionCommand;
use App\PaymentTransactions\PaymentTransactionCreateHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseStatusCodeSame;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\StaticAnalysis\HappyPath\AssertIsInt\consume;


class CreateTransactionController extends AppController
{
    protected PaymentTransactionCreateHandler $handler;

    public function __construct(PaymentTransactionCreateHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/transaction", name="create_transaction", methods={"POST"})
     */
    public function index(Request $request)
    {
        $data = $this->requestToArray($request);

        $createTransactionRequest = new CreateTransactionCommand();

        $form = $this->createForm(CreateTransactionType::class, $createTransactionRequest);
        $form->submit($data);

        if ($request->isMethod('POST') && $form->isValid()) {
            try {
                $this->handler->handle($createTransactionRequest);
                return $this->json([
                    'message' => 'Successful transaction'
                ], 200);
            } catch (\Throwable $e) {
                return $this->json([
                    'message' => $e->getMessage()
                ], 400);
            }
        }

        return $this->json([
            'message' => 'Invalid argument'
        ], 400);
    }
}
