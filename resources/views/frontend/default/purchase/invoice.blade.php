<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "DM Sans", sans-serif;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            line-height: 1.6;
            padding: 20px;
            font-size: 14px;
        }

        a {
            text-decoration: none;
        }

        a,
        p {
            color: #4b4b4b;
        }

        .invoice-container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: self-start;
            background-color: #FFF2EE;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 30px 30px 40px 30px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .logo img {
            height: 30px;
        }

        .payable-info p {
            margin-bottom: 12px;
            color: #303030;
            font-size: 14px;
            font-weight: 600;
            line-height: 14px;
        }

        .payable-info p:last-child {
            margin-bottom: 0;
            font-weight: 500;
        }

        .invoice-details-box {
            padding: 20px;
            color: #202228;
        }

        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 50px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .invoice-details h3 {
            margin-bottom: 8px;
            color: #303030;
            font-size: 20px;
            font-weight: 700;
            line-height: normal;
        }

        .invoice-table-box {
            position: relative;
            margin-bottom: 35px;
            border: 1px solid rgba(48, 48, 48, 0.16);
            border-radius: 4px;
            overflow: hidden;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .invoice-table thead {
            background: #F1F1F1;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 10px 16px;
            text-align: left;
        }

        .invoice-table tbody {
            border-bottom: 1px solid rgba(48, 48, 48, 0.16);
        }

        .footer-top {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 30px;
            gap: 16px;
        }

        .footer-bottom {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 16px;
        }

        .bank-info p {
            color: #ffffff;
            text-align: left;
            font-weight: 500;
        }

        .payment-details strong {
            margin-bottom: 5px;
            display: block;
        }

        .button-container {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 50px;
            flex-wrap: wrap;
        }

        .print-button,
        .download-button {
            background: linear-gradient(270deg, #5AC0F4 0%, #4B4BFE 100%);
            color: white;
            border: none;
            padding: 0px 18px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            height: 44px;
            display: inline-flex;
            align-items: center;
        }

        .print-button {
            display: flex;
            height: 44px;
            padding: 12px 20px;
            justify-content: center;
            align-items: center;
            gap: 6px;
            border-radius: 12px;
            background: #FF6229;
            box-shadow: 0px 1px 4px 0px rgba(25, 33, 61, 0.08);
            color: #FFF;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            line-height: normal;
        }

        .print-button svg {
            width: 20px;
        }

        .back-button {
            display: flex;
            height: 44px;
            padding: 12px 20px;
            justify-content: center;
            align-items: center;
            gap: 3px;
            border-radius: 12px;
            border: 1px solid rgba(48, 48, 48, 0.16);
            color: #303030;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            line-height: normal;
        }

        /* Adjustments for Small Screens */
        @media (max-width: 480px) {
            .invoice-table-box {
                overflow-x: scroll;
                padding-left: 0;
            }
        }

        /* Print Styles */
        @media print {
            body {
                background: #ffffff !important;
                color: #ffffff !important;
            }

            .invoice-container {
                -webkit-print-color-adjust: exact;
            }

            .print-button,
            .download-button,
            .back-button {
                display: none !important;
            }
        }

        .app-badge.badge-success {
            background: #31B269;
            color: #fff;
        }

        .app-badge.badge-danger {
            background: #ed4030;
            color: #fff;
        }

        .app-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 7px 15px;
            min-width: 87px;
            border-radius: 30px;
            line-height: 1;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <header class="invoice-header">
            <div class="logo">
                <a href="#">
                    <img src="{{ asset(setting('site_logo_dark', 'global')) }}" alt="Invoice Logo">
                </a>
            </div>
            <div class="payable-info">
                <p>Order Number: #{{ $order->order_number }}</p>
                <p>Issued: {{ $order->order_date }}</p>
            </div>
        </header>
        <div class="invoice-details-box">
            <div class="invoice-details">
                <div class="billed-to">
                    <h3>{{ $order->is_topup ? setting('site_title', 'global') : $order->seller?->full_name }}</h3>
                    <p>{{ $order->is_topup ? setting('site_email', 'global') : $order->seller?->email }}</p>
                    <p>{{ $order->is_topup ? setting('site_phone', 'global') : $order->seller?->phone }}</p>
                    <span
                        class="app-badge badge-{{ $order->payment_status == \App\Enums\TxnStatus::Success->value ? 'success' : 'danger' }}"
                        style="margin-top: 10px;">
                        {{ ucwords($order->payment_status) }}
                    </span>
                </div>
                <div class="from">
                    <h3>Total Amount: <br>
                        {{ amountWithCurrency($order->transaction->pay_amount, $order->transaction->pay_currency) }}
                    </h3>
                    <p>Amount:
                        {{ amountWithCurrency($order->total_price, setting('site_currency', 'global')) }}</p>
                    <p>Charge:
                        {{ amountWithCurrency($order->transaction->charge, setting('site_currency', 'global')) }}</p>
                </div>
            </div>
            <div class="invoice-table-box">
                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Coupon Discount</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a target="_blank"
                                    href="{{ route('listing.details', $order->listing->slug ?? '#') }}">{{ $order->is_topup ? 'Topup' : $order->listing?->product_name }}</a>
                            </td>
                            <td>
                                @if ($order->is_topup)
                                    {{ amountWithCurrency($order->total_price, setting('site_currency', 'global')) }}
                                @else
                                    {{ amountWithCurrency($order->org_unit_price, setting('site_currency', 'global')) }}
                                    <br>
                                    @if ($order->org_unit_price > $order->unit_price)
                                        <small><i><b>{{ 'Discount: -' . amountWithCurrency($order->org_unit_price - $order->unit_price, setting('site_currency', 'global')) }}</b></i></small>
                                    @endif
                                @endif
                            </td>
                            <td>{{ $order->is_topup ? 1 : $order->quantity }}</td>
                            <td>{{ amountWithCurrency($order->discount_amount, setting('site_currency', 'global')) }}
                            </td>
                            <td><strong>{{ amountWithCurrency($order->total_price, setting('site_currency', 'global')) }}</strong>
                            </td>
                            </td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td colspan="4" style="color: #000000;"><strong>Subtotal</strong></td>
                            <td>{{ amountWithCurrency($order->total_price, setting('site_currency', 'global')) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="color: #000000;"><strong>Charge</strong></td>
                            <td>{{ amountWithCurrency($order->transaction->charge, setting('site_currency', 'global')) }}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"><strong>Payable Total</strong></td>
                            <td>
                                <strong
                                    style="color: #000000;">{{ amountWithCurrency($order->transaction->pay_amount, $order->transaction->pay_currency) }}</strong>
                            </td>

                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="footer">
                <div class="footer-bottom">
                    <p>Thanks for the purchase.</p>
                </div>
            </div>
            <div class="button-container">
                <a href="{{ buyerSellerRoute('purchase.index') }}" class="back-button">Back</a>
                <button class="print-button" onclick="window.print()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                        fill="none">
                        <g clip-path="url(#clip0_483_1142)">
                            <path
                                d="M4.00016 12.0002H2.66683C2.31321 12.0002 1.97407 11.8597 1.72402 11.6096C1.47397 11.3596 1.3335 11.0205 1.3335 10.6668V7.3335C1.3335 6.97987 1.47397 6.64074 1.72402 6.39069C1.97407 6.14064 2.31321 6.00016 2.66683 6.00016H13.3335C13.6871 6.00016 14.0263 6.14064 14.2763 6.39069C14.5264 6.64074 14.6668 6.97987 14.6668 7.3335V10.6668C14.6668 11.0205 14.5264 11.3596 14.2763 11.6096C14.0263 11.8597 13.6871 12.0002 13.3335 12.0002H12.0002M4.00016 6.00016V2.00016C4.00016 1.82335 4.0704 1.65378 4.19542 1.52876C4.32045 1.40373 4.49002 1.3335 4.66683 1.3335H11.3335C11.5103 1.3335 11.6799 1.40373 11.8049 1.52876C11.9299 1.65378 12.0002 1.82335 12.0002 2.00016V6.00016"
                                stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                            <path
                                d="M11.3333 9.3335H4.66667C4.29848 9.3335 4 9.63197 4 10.0002V14.0002C4 14.3684 4.29848 14.6668 4.66667 14.6668H11.3333C11.7015 14.6668 12 14.3684 12 14.0002V10.0002C12 9.63197 11.7015 9.3335 11.3333 9.3335Z"
                                stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round">
                            </path>
                        </g>
                        <defs>
                            <clipPath id="clip0_483_1142">
                                <rect width="16" height="16" fill="white"></rect>
                            </clipPath>
                        </defs>
                    </svg>
                    Print Invoice
                </button>
            </div>
        </div>
    </div>
</body>

</html>
