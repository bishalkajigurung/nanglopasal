<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Account Approval</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .credentials {
            background-color: #f9f9f9;
            padding: 15px;
            border-left: 4px solid #28a745;
            margin: 20px 0;
        }
        .warning {
            color: #dc3545;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Congratulations, {{ $seller->name }}! 🎉</h1>
        <p>Your seller account has been approved. You can now log in and start selling your products on our platform.</p>

        <h3>Your Account Details:</h3>
        <div class="credentials">
            <p><strong>Shop Name:</strong> {{ $seller->shop_name }}</p>
            <p><strong>Email:</strong> {{ $seller->email }}</p>
            <p><strong>Password:</strong> {{ $password }}</p>
            <p><strong>Contact:</strong> {{ $seller->contact }}</p>
            @if($seller->expire_date)
                <p><strong>Subscription Expires:</strong> {{ \Carbon\Carbon::parse($seller->expire_date)->format('F j, Y') }}</p>
            @endif
        </div>

        <p>You can log in here: <a href="{{ url('/seller/login') }}">{{ url('/seller/login') }}</a></p>
        <p><strong>For security reasons, please change your password after your first login.</strong></p>

        <div class="warning">
            ⚠️ This email contains sensitive information. If you did not request this, please contact support immediately.
        </div>

        <p>Thank you for joining us!<br>Best regards,<br>{{ config('app.name') }} Team</p>
    </div>
</body>
</html>
