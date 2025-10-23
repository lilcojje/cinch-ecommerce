<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Order Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
  <h2>Hi {{ $name }},</h2>
  <p>Thank you for your order! Here’s your order summary:</p>

  <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
    <thead>
      <tr>
        <th style="border-bottom: 1px solid #ddd; padding: 8px;">Product</th>
        <th style="border-bottom: 1px solid #ddd; padding: 8px;">Quantity</th>
        <th style="border-bottom: 1px solid #ddd; padding: 8px;">Unit Price</th>
        <th style="border-bottom: 1px solid #ddd; padding: 8px;">Subtotal</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($items as $item)
        <tr>
          <td style="border-bottom: 1px solid #eee; padding: 8px;">{{ $item['name'] ?? 'Product' }}</td>
          <td style="border-bottom: 1px solid #eee; padding: 8px; text-align: center;">{{ $item['quantity'] }}</td>
          <td style="border-bottom: 1px solid #eee; padding: 8px;">${{ number_format($item['unit_price'], 2) }}</td>
          <td style="border-bottom: 1px solid #eee; padding: 8px;">${{ number_format($item['subtotal'], 2) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <h3 style="margin-top: 20px;">Total Amount: ${{ number_format($total_amount, 2) }}</h3>

  <p>We appreciate your purchase and hope you enjoy your products!</p>
  <p>— The Team</p>
</body>
</html>
