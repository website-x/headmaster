<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Received</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: left;
        }

        .banner {
            text-align: center;
            background: #f4f4f4;
            font-size: 21px;
            padding: 11px;
            font-weight: 700;
            letter-spacing: 8px;
            color: #5b5b5b;
        }
    </style>
</head>

<body>
<div class="invoice-box">
    <p class="banner">Payment Received</p>
    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="title">
                            <img src="{{ asset('/images/logo.png') }}" style="width:100%; max-width:300px;">
                        </td>

                        <td>
                            Invoice # {{ $fees->id }}<br>
                            Date: {{ $fees->created_at->format('d M Y') }}<br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td style="width: 250px">
                            {{ config('app.address_for_invoice') }}
                        </td>

                        <td style="width: 250px">
                            {{ $fees->client->full_name }}<br>
                            <small>(Parent:{{ $fees->client->father_full_name }})</small><br>
                            <small>{{ $fees->client->full_address }}</small><br>
                            {{ $fees->client->phone }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading">
            <td>
                Particulars
            </td>

            <td>
                Amount
            </td>
        </tr>

        <tr class="item">
            <td>
                {{ $fees->description }}<br>
                <small>{{ $fees->method }}</small>
                @if($fees->method_remarks != null)
                    <small>({{ $fees->method_remarks }})</small>
                @endif
            </td>

            <td>
                <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ $fees->amount }}
            </td>
        </tr>

        <tr class="total">
            <td>
                <small>Collected By
                    <br>
                {{ $fees->collectedBy->name }} ({{ $fees->office->name }})</small>
            </td>
            <td>
                Total: <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ $fees->amount }}
            </td>
        </tr>
    </table>
</div>
</body>
</html>
