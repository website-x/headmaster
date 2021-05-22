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

        .heading {
            background: #01aef0;
            color: white;
        }

        .heading th {
            padding: 7px;
        }

        .details {
            border-color: #01aef0;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #05adf0;
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

        .skyblue-text {
            color: #47bee3 !important;
        }

        .sb-highlighted {
            background: #05adf0;
            color: white;
        }
    </style>
</head>

<body>
<div class="invoice-box">
    <table>
        <tr>
            <td>
                <span class="skyblue-text">ATMIA INTERNATIONAL SERVICES CO. LTD</span>
                <p>
                    Pete's Building, Damascus Road, Nasipit Road,
                    Talamban, Cebu, Philippines - 600.
                </p>
            </td>
            <td>
                <img src="{{ asset('/images/logo.png') }}" style="width:100%; max-width:350px;">
                <p style="font-size: 10px !important;">A Team in the field of education since 25 years</p>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td>
                <span class="skyblue-text">Name:</span>
                <span>{{ $fees->client->full_name }}</span>
            </td>
            <td>
                <span class="skyblue-text">Receipt No:</span>
                <span>{{ $fees->id}}</span>
            </td>
        </tr>
        <tr>
            <td style="width: 250px">
                <span class="skyblue-text">Address:</span>
                <p>
                    {{ $fees->client->full_address }}
                    <br />
                    {{ $fees->client->phone }}
                </p>
            </td>
            <td>
                <span class="skyblue-text">Date:</span>
                <span>{{ $fees->created_at->format('d M Y') }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="skyblue-text">Hostel:</span>
                <span></span>
            </td>
            <td>
                <span class="skyblue-text">Time:</span>
                <span>{{ $fees->created_at->format('h:i a') }}</span>
            </td>
        </tr>
    </table>
    <br />
    <br />
    <br />
    <table cellpadding="0" cellspacing="0" class="details" border="1">
        <thead>
        <tr class="heading">
            <th>Sr No.</th>
            <th>Description</th>
            <th>Discount</th>
            <th>Penalty</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        <tr class="item">
            <td>1.</td>
            <td style="text-align: center">
                {{ $fees->description }} <br/>
                <small>{{ $fees->method }}</small>
                @if($fees->method_remarks != null)
                    <small>({{ $fees->method_remarks }})</small>
                @endif
            </td>
            <td><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>0</td>
            <td><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>0</td>
            <td>
                <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ $fees->amount }}
            </td>
        </tr>

        <tr>
            <td colspan="2" class="sb-highlighted">
                Total Amount in Word
            </td>
            <td></td>
            <td class="sb-highlighted"><span>Subtotal</span></td>
            <td>
                <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ $fees->amount }}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <span style="text-transform: uppercase">
                    {{ $fees->fees_amount_in_words }}
                </span>
            </td>
            <td class="sb-highlighted"><span>Discount</span></td>
            <td><span>&#8377;</span>0</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td class="sb-highlighted"><span>Penalty</span></td>
            <td><span>&#8377;</span>0</td>
        </tr>

        <tr class="total">
            <td colspan="3">
                <small>Collected By
                    <br>
                    {{ $fees->collectedBy->name }} ({{ $fees->office->name }})</small>
            </td>
            <td class="sb-highlighted"><span>Total</span></td>
            <td>
                <span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>{{ $fees->amount }}
            </td>
        </tr>
        </tbody>
    </table>
    <br />
    <br />

    <table>
        <tr>
            <td>
                <p class="skyblue-text">Thank you for accepting digital receipt received by</p>
                <ul>
                    <li>This is an electronic generated digital receipt</li>
                    <li>This is generated for the reference of payment only</li>
                    <li>If cannot be further official without official seal of the company</li>
                    <li>All disputes are subject to Philippines jurisdiction only</li>
                </ul>
            </td>
            <td>
                <p class="skyblue-text">Received By</p>
            </td>
        </tr>
    </table>

</div>
</body>
</html>
