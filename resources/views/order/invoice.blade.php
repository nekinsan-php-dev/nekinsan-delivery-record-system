<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flexible A4 Sheet with Shipment Invoices</title>
    <style>
        @page {
            size: A4;
            margin: 5mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10pt; /* Increased from 8pt */
            line-height: 1.3; /* Slightly increased for better readability */
        }

        .a4-sheet {
            width: 210mm;
            height: 297mm;
            padding: 5mm;
            box-sizing: border-box;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-content: flex-start;
            page-break-after: always; /* Ensures new sheet after each a4-sheet */
        }

        .invoice {
            width: 98mm;
            height: 140mm;
            border: 0.5pt solid #000;
            padding: 3mm; /* Slightly increased for better spacing */
            box-sizing: border-box;
            margin-bottom: 5mm;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .header {
            text-align: center;
            margin-bottom: 2mm;
        }

        .header h2,
        .header h3 {
            margin: 0;
            font-size: 12pt; /* Increased from 8pt */
        }

        .header p {
            margin: 0;
            font-size: 11pt; /* Increased for better visibility */
        }

        .company-info {
            text-align: center;
            margin-bottom: 2mm;
        }

        .company-info h3 {
            margin: 0;
            font-size: 11pt; /* Increased from 8pt */
        }

        .company-info p,
        .customer-info p {
            margin: 0;
            font-size: 10pt; /* Increased for consistency */
        }

        .customer-info {
            margin-bottom: 2mm;
        }

        .product-info {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2mm;
            font-size: 8pt; /* Increased from 6pt */
        }

        .product-info th,
        .product-info td {
            border: none;
            padding: 2mm; /* Increased from 0.5mm for better spacing */
            text-align: left;
        }

        .product-info th {
            font-weight: bold;
            font-size: 9pt; /* Slightly larger for headers */
        }

        .product-info tr {
            border-bottom: 0.5pt solid #000;
        }

        .product-info tr:last-child {
            border-bottom: none;
        }

        .footer {
            margin-top: 2mm;
            text-align: center;
            font-size: 9pt; /* Increased for better visibility */
        }

        table tr td {
            padding: 5px; /* Reduced padding to fit content */
            border: 1px solid black;
            font-size: 9pt; /* Increased for readability */
        }

        table tr th {
            padding: 5px; /* Reduced padding to fit content */
            border: 1px solid black;
            font-size: 9pt; /* Increased for readability */
            text-align: center;
        }

        .border-top-none {
            border-top: none;
        }

        .border-left-none {
            border-left: none;
        }

        .border-right-none {
            border-right: none;
        }

        .border-bottom-none {
            border-bottom: none;
        }

        /* Optional: Adjustments for better printing */
        @media print {
            body {
                font-size: 10pt;
            }

            .header h2,
            .header h3,
            .header p,
            .company-info h3,
            .company-info p,
            .customer-info p,
            .product-info th,
            .product-info td,
            .footer p {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <!-- Loop through orders in chunks of 4 to create separate A4 sheets -->
    @foreach ($orders->chunk(4) as $orderChunk)
        <div class="a4-sheet">
            @foreach ($orderChunk as $index => $order)
                <div class="invoice">
                    <div class="header">
                        <h2>Shipment Date: {{ now()->format('d/m/Y') }}</h2>
                        <h3>SPCOD</h3>
                        <p>BD/BNPL/SPCOD-01/2023-24</p>
                    </div>
                    <div class="company-info">
                        <h3>JIYO INDIA SALE AND MARKETING PVT. LTD.</h3>
                        <p>Sector - 65, Noida 201301 (Uttar Pradesh)</p>
                        <p>CUSTOMER ID/BILLER ID - 0000056178</p>
                        <p>NSPC - NOIDA</p>
                    </div>
                    <div class="customer-info">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td colspan="3">
                                    <p><strong>Customer Name:</strong> {{ $order->name ?? 'Customer Name' }}</p>
                                    
                                    @php
                                        $fullAddress = $order->address . ' - ' . $order->city . ', ' . $order->state . ' ' . $order->pincode;
                                        $fontSize = strlen($fullAddress) > 270 ? '9pt' : '8pt';
                                    @endphp
                                
                                    <p style="font-size: {{ $fontSize }};">
                                        <strong>Address:</strong> {{ $order->address ?? 'Address' }} - {{ $order->city }}, {{ $order->state }} {{ $order->pincode }}
                                    </p>
                                </td>
                                <td width="30%" style="border-left: none;">
                                    <p><strong>Order ID:</strong> {{ $order->id }}</p>
                                    <p><strong>Barcode:</strong> {{ $order->barcode ?? 'Not Assigned' }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="border-top-none">
                                    <p><strong>Customer Phone No:</strong> {{ $order->mobile }}</p>
                                </td>
                                <td class="border-top-none border-left-none">
                                    <p><strong>Net Wt:</strong> 30 grams</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="border-top-none">
                                    <p><strong>If Undelivered, please return to:</strong> B-55, Sector 65, Noida</p>
                                </td>
                                <td class="border-top-none border-left-none">
                                    <p><strong>COD Amount:</strong> Rs. {{ $order->amount }}/-</p>
                                </td>
                            </tr>
                            <tr>
                                <td  colspan="3" class="border-top-none" style="font-size: 14px !important; padding-top:15px; padding-bottom:15px;">
                                    Tracking No and Barcode
                                </td>
                                <td class="border-top-none border-left-none" >

                                </td>
                            </tr>
                            <tr>
                                <th class="border-bottom-none">Product Name</th>
                                <th class="border-bottom-none border-left-none">SKU</th>
                                <th class="border-bottom-none border-left-none">QTY</th>
                                <th class="border-bottom-none border-left-none">Amount</th>
                            </tr>
                            <tr>
                                <td>Nek Insan - {{ $order->product }}</td>
                                <td class="border-left-none">BR0001</td>
                                <td class="border-left-none">1</td>
                                <td class="border-left-none">Rs. {{ $order->amount }}/-</td>
                            </tr>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</body>

</html>
