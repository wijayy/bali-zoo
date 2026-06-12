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
            <td colspan="30"><strong>Transaction Report</strong></td>
        </tr>
        <tr>
            <td colspan="30">Period: {{ $startDate }} to {{ $endDate }}</td>
        </tr>
    </table>

    <br>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Transaction Date</th>
                <th>Transaction Number</th>
                <th>Customer Name</th>
                <th>Customer Email</th>
                <th>Transaction Status</th>
                <th>Payment Status</th>
                <th>Payment Method</th>
                <th>Receiver Name</th>
                <th>Receiver Phone</th>
                <th>Address</th>
                <th>Village</th>
                <th>District</th>
                <th>City</th>
                <th>Province</th>
                <th>Postal Code</th>
                <th>Shipping Status</th>
                <th>AWB</th>
                <th>Resi</th>
                <th>Product</th>
                <th>Category</th>
                <th>Supplier</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Item Subtotal</th>
                <th>Transaction Subtotal</th>
                <th>Shipping Cost</th>
                <th>Discount</th>
                <th>Total</th>
                <th>Coupon Code</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($transactions as $transaction)
                @forelse ($transaction->items as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>{{ $transaction->transaction_number }}</td>
                        <td>{{ $transaction->user?->name ?? '-' }}</td>
                        <td>{{ $transaction->user?->email ?? '-' }}</td>
                        <td>{{ $transaction->status }}</td>
                        <td>{{ $transaction->payment?->status ?? '-' }}</td>
                        <td>{{ $transaction->payment?->metode_pembayaran ?? '-' }}</td>
                        <td>{{ $transaction->pengiriman?->name ?? '-' }}</td>
                        <td>{{ $transaction->pengiriman?->phone ?? '-' }}</td>
                        <td>{{ $transaction->pengiriman?->address ?? '-' }}</td>
                        <td>{{ $transaction->pengiriman?->village ?? '-' }}</td>
                        <td>{{ $transaction->pengiriman?->district ?? '-' }}</td>
                        <td>{{ $transaction->pengiriman?->city ?? '-' }}</td>
                        <td>{{ $transaction->pengiriman?->province ?? '-' }}</td>
                        <td>{{ $transaction->pengiriman?->postal_code ?? '-' }}</td>
                        <td>{{ $transaction->pengiriman?->status ?? '-' }}</td>
                        <td>{{ $transaction->pengiriman?->awb ?? '-' }}</td>
                        <td>{{ $transaction->pengiriman?->resi ?? '-' }}</td>
                        <td>{{ $item->product?->name ?? '-' }}</td>
                        <td>{{ $item->product?->category?->name ?? '-' }}</td>
                        <td>{{ $item->product?->supplier?->name ?? '-' }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->subtotal }}</td>
                        <td>{{ $transaction->subtotal }}</td>
                        <td>{{ $transaction->shipping_cost }}</td>
                        <td>{{ $transaction->discount }}</td>
                        <td>{{ $transaction->total }}</td>
                        <td>{{ $transaction->couponUsage?->coupon?->code ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                        <td>{{ $transaction->transaction_number }}</td>
                        <td>{{ $transaction->user?->name ?? '-' }}</td>
                        <td>{{ $transaction->user?->email ?? '-' }}</td>
                        <td>{{ $transaction->status }}</td>
                        <td>{{ $transaction->payment?->status ?? '-' }}</td>
                        <td>{{ $transaction->payment?->metode_pembayaran ?? '-' }}</td>
                        <td colspan="17">No item</td>
                        <td>{{ $transaction->subtotal }}</td>
                        <td>{{ $transaction->shipping_cost }}</td>
                        <td>{{ $transaction->discount }}</td>
                        <td>{{ $transaction->total }}</td>
                        <td>{{ $transaction->couponUsage?->coupon?->code ?? '-' }}</td>
                    </tr>
                @endforelse
            @endforeach
        </tbody>
    </table>
</body>

</html>
