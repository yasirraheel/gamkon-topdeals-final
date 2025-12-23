<?php

namespace App\Enums;

enum TxnStatus: string
{
    case Success = 'success';
    case Pending = 'pending';
    case Cancelled = 'cancelled';
    case Failed = 'failed';

    case Refunded = 'refunded';
}
