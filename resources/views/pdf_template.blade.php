<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .header img {
            max-width: 120px;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .company-info {
            text-align: left;
            flex: 1;
        }

        .customer-info {
            text-align: right;
            flex: 1;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .invoice-table th {
            background-color: #f2f2f2;
        }

        .total-section {
            margin-top: 20px;
            text-align: right;
        }

        .signature {
            margin-top: 40px;
            text-align: right;
        }

        .signature p {
            display: inline-block;
            border-top: 1px solid #000;
            padding-top: 5px;
            width: 200px;
        }
    </style>
</head>

<body>

    <div class="invoice-box">
        <div class="header">
            <div>
                <img src="{{ public_path('admin_assets/images/LOGO_WITH_R_MARK.png') }}" class="logo"
                    alt="Company Logo">
            </div>
            <div class="company-info">
                <h2>ABC Pvt. Ltd.</h2>
                <p>123, Business Street, City, Country</p>
                <p>Email: info@company.com | Phone: +123 456 7890</p>
            </div>

            <div class="customer-info">
                <h3>Invoice</h3>
                <p><strong>Customer Name:</strong> {{ $name }}</p>
                <p><strong>Address:</strong> {{ $address }}</p>
                <p><strong>Phone:</strong> {{ $phone }}</p>
                <p><strong>Date:</strong> {{ now()->format('d-m-Y') }}</p>
            </div>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Product A</td>
                    <td>2</td>
                    <td>$50</td>
                    <td>$100</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Product B</td>
                    <td>1</td>
                    <td>$80</td>
                    <td>$80</td>
                </tr>
            </tbody>
        </table>

        <div class="total-section">
            <p><strong>Subtotal:</strong> $180</p>
            <p><strong>Tax (10%):</strong> $18</p>
            <p><strong>Total:</strong> $198</p>
        </div>

        <div class="signature">
            <p>Authorized Signature</p>
        </div>
    </div>

</body>

</html>