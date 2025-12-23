<?php

namespace App\Enums;

enum ReferralType: string
{
    case Topup = 'topup';
    case SubscriptionPlan = 'subscription_plan';

    case ProductOrder = 'product_order';
}
