<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        table {
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 6px;
            white-space: nowrap;
        }

        th {
            background: #e5e7eb;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td colspan="13"><strong>Purchase Report</strong></td>
        </tr>
        <tr>
            <td colspan="13">Period: {{ $startDate }} to {{ $endDate }}</td>
        </tr>
    </table>

    <br>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Purchase Date</th>
                <th>Purchase Number</th>
                <th>Status</th>
                <th>Payment Method</th>
                <th>Product</th>
                <th>Supplier</th>
                <th>Category</th>
                <th>Qty</th>
                <th>Buy Price</th>
                <th>Item Subtotal</th>
                <th>Purchase Total</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($purchases as $purchase)
                @forelse ($purchase->items as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d') }}</td>
                        <td>{{ $purchase->purchase_number }}</td>
                        <td>{{ $purchase->status }}</td>
                        <td>{{ $purchase->payment_method }}</td>
                        <td>{{ $item->product?->name ?? '-' }}</td>
                        <td>{{ $item->product?->supplier?->name ?? '-' }}</td>
                        <td>{{ $item->product?->category?->name ?? '-' }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->subtotal }}</td>
                        <td>{{ $purchase->total }}</td>
                        <td>{{ $purchase->created_at?->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d') }}</td>
                        <td>{{ $purchase->purchase_number }}</td>
                        <td>{{ $purchase->status }}</td>
                        <td>{{ $purchase->payment_method }}</td>
                        <td colspan="6">No item</td>
                        <td>{{ $purchase->total }}</td>
                        <td>{{ $purchase->created_at?->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforelse
            @endforeach
        </tbody>
    </table>
</body>

</html>
