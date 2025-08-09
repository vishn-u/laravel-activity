<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Customer Transactions</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 10px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f4f4f4; }
    </style>
</head>
<body>
    <h3>Transactions for {{ $email }}</h3>

    @if(!empty($transactions))
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Receipt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $tx)
                    <tr>
                        <td>{{ $tx['id'] ?? '-' }}</td>
                        <td>{{ $tx['amount'] ?? '-' }}</td>
                        <td>{{ $tx['status'] ?? '-' }}</td>
                        <td>{{ $tx['date'] ?? '-' }}</td>
                        <td>
                            @if(!empty($tx['receipt']))
                                <a href="{{ $tx['receipt'] }}" target="_blank">View</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No transactions found.</p>
    @endif
</body>
</html>
