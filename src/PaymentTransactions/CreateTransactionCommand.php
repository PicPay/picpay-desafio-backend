<?php


namespace App\PaymentTransactions;


class CreateTransactionCommand
{
    public float $value = 0;

    public int $payer = 0;

    public int $payee = 0;
}