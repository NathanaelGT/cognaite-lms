<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case Paid = 'Dibayar';
    case Pending = 'Menunggu Pembayaran';
    case Canceled = 'Dibatalkan';
}
