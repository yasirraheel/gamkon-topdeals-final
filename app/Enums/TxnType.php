<?php

namespace App\Enums;

enum TxnType: string
{
    case Deposit = 'deposit';
    case Subtract = 'subtract';
    case ManualDeposit = 'manual_deposit';
    case Referral = 'referral';
    case SignupBonus = 'signup_bonus';
    case Withdraw = 'withdraw';
    case WithdrawAuto = 'withdraw_auto';
    case Refund = 'refund';

    case PlanRefund = 'plan_refund';
    case PlanPurchased = 'plan_purchased';
    case ProductOrder = 'product_order';
    case ProductSold = 'product_sold';
    case Topup = 'topup';
    case ProductOrderViaTopup = 'product_order_via_topup';
    case SubscribedUserFirstOrder = 'subscribed_user_first_order';

    case SellerFee = 'seller_fee';
    case PortfolioBonus = 'portfolio_bonus';

    case OrderRefunded = 'order_refunded';
}
