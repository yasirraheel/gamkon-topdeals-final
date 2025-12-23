<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Success = 'payment_success';

    case WaitingForDelivery = 'waiting_for_delivery';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case Failed = 'failed';

    case Refunded = 'refunded';
}
