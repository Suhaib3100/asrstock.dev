<!DOCTYPE html>
<html lang="en">
<head>
    <title>Invoice</title>
</head>
<body>

<div style="background-color: #ffffff;  margin-left: auto; margin-right: auto; box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);">
    <table style="border-collapse: collapse; width: 100%; font-family: 'Arial', sans-serif">
        <tbody>
        <tr>
            <td style="padding: 16px;">
                <!--====== Clear fix ===========-->
                <div style="display: block; clear: both;"></div>

                <div style="display: block">
                    <div style="margin: 0 0 1.5rem 0; display: inline-block;">
                        <h4 style="margin: 0 0 1rem 0; color: #666666">Purchase Invoice</h4>
                        <p style="margin: 4px 0; color: #666666; font-size: 14px;">{{getOption('app_name')}}</p>
                        <p style="margin: 4px 0; color: #666666; font-size: 14px;">{{getOption('app_email')}}</p>
                        <p style="margin: 4px 0; color: #666666; font-size: 14px;">{{getOption('app_contact_number')}}</p>
                    </div>

                    <div style="margin: 0 0 1.5rem 0; display: inline-block; float: right">
                        <h2 style="margin: 8px 0; color: #666666; font-size: 24px;">#{{$order->order_number}}</h2>
                        <p style="margin: 4px 0; color: #666666; font-size: 14px;">Purchase Date // {{ date('M d, Y', strtotime($order->created_at)) }}</p>
                    </div>
                </div>
                <!--====== Clear fix ===========-->
                <div style="display: block; clear: both;"></div>

                <!--================= Table ====================-->
                <table style="border-collapse: collapse;  width: 100%; font-size: 14px; margin-top: 25px; box-sizing: border-box">
                    <thead>
                    <tr style="background-color: #D5D7DC">
                        <th style="font-weight: normal; text-align: left; padding: 12px 16px">Name</th>
                        <th style="font-weight: normal; text-align: left; padding: 12px 16px">Type</th>
                        <th style="font-weight: normal; text-align: left; padding: 12px 16px">Purchase Date</th>
                        <th style="font-weight: normal; text-align: left; padding: 12px 16px">Payment Method</th>
                        <th style="font-weight: normal; text-align: center; padding: 12px 16px">Amount</th>
                    </tr>
                    </thead>
                    <tbody style="color: #444444">
                    <tr style="border-bottom: 1px solid #dddddd">
                        <td style="text-align: left; padding: 12px 16px">
                            {{ @$order->product->title }}
                            {{ @$order->plan->name }}

                        </td>
                        <td style="text-align: left; padding: 12px 16px">
                         @if($order->type == ORDER_TYPE_PLAN)
                             Plan
                        @elseif($order->type == ORDER_TYPE_PRODUCT)
                             Product
                        @elseif($order->type == ORDER_TYPE_DONATE)
                            Donate
                         @endif

                        </td>

                        <td style="text-align: left; padding: 12px 16px">{{ date('M d, Y', strtotime($order->created_at)) }}</td>
                        <td style="text-align: left; padding: 12px 16px">{{ucwords(@$order->gateway->gateway_name)}}</td>
                        <td style="text-align: center; padding: 12px 16px">
                            {{ getAmountPlace($order->total) }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td style="padding: 24px 16px;">

                <p style="margin-bottom: 12px; margin-top: 0; text-align: center; color: #666666">We thank you for your business and continued use of {{getOption('app_name')}}</p>
                <h2 style="text-align: center; color: #666666; font-weight: 600; margin-top: 0; margin-bottom: 0">Thank you from {{getOption('app_name')}} family</h2>
            </td>
        </tr>
        </tfoot>
    </table>
</div>

</body>
</html>
