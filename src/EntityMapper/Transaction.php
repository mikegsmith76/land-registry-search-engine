<?php

namespace App\EntityMapper;

use App\Entity\Transaction as TransactionEntity;

class Transaction
{
    const COL_REFERENCE = 0;
    const COL_PRICE = 1;
    const COL_DATE = 2;
    const COL_OLD_NEW = 5;
    const COL_TENURE = 6;
    const COL_TYPE = 14;

    public function map(TransactionEntity $transaction, array $data) : TransactionEntity
    {
        $isNew = "y" === strtolower($data[self::COL_OLD_NEW]);
        $date = new \DateTime($data[self::COL_DATE]);

        $transaction->setId(trim($data[self::COL_REFERENCE]));
        $transaction->setPrice(trim($data[self::COL_PRICE]));
        $transaction->setDate($date);
        $transaction->setNew($isNew);
        $transaction->setTenure(trim($data[self::COL_TENURE]));
        $transaction->setType(trim($data[self::COL_TYPE]));

        return $transaction;
    }
}