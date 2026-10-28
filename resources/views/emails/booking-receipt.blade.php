<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Confirmation | Gohar Mart</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; }
        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(23, 37, 84, 0.1); border: 1px solid #e2e8f0; }
        .header { background: #172554; padding: 40px; text-align: center; }
        .logo { font-size: 28px; font-weight: 900; color: #ffffff; letter-spacing: -1px; text-transform: uppercase; }
        .logo span { color: #dc2626; }
        .content { padding: 40px; color: #1e293b; }
        .h1 { font-size: 26px; font-weight: 900; color: #172554; margin-bottom: 15px; text-transform: uppercase; letter-spacing: -1px; }
        .p { font-size: 15px; line-height: 24px; color: #64748b; margin-bottom: 24px; font-weight: 500; }
        
        /* The Order Card */
        .order-card {
            background: #ffffff;
            border: 2px solid #f1f5f9;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            position: relative;
        }
        .card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px; border-bottom: 1px solid #f1f5f9; padding-bottom: 20px; }
        .card-title { font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #94a3b8; font-weight: 900; }
        .order-id { font-size: 14px; font-weight: 900; color: #172554; background: #f1f5f9; padding: 4px 10px; rounded: 8px; }
        
        .card-body { display: flex; gap: 20px; }
        .info-row { margin-bottom: 20px; }
        .label { font-size: 10px; text-transform: uppercase; color: #94a3b8; margin-bottom: 6px; display: block; font-weight: 900; letter-spacing: 1px; }
        .value { font-size: 15px; font-weight: 700; color: #172554; display: block; }
        .value-red { color: #dc2626; }
        
        .footer { text-align: center; padding: 30px; background: #f8fafc; font-size: 11px; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
        .btn { display: inline-block; background: #172554; color: white; padding: 16px 32px; border-radius: 12px; text-decoration: none; font-weight: 900; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; margin-top: 10px; box-shadow: 0 10px 15px -3px rgba(23, 37, 84, 0.2); }
        
        @media only screen and (max-width: 600px) {
            .container { margin: 0; border-radius: 0; }
            .content { padding: 25px; }
            .card-body { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">HASHAM <span>E-COM</span></div>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="h1">Order Confirmed!</div>
            <p class="p">Hi {{ $booking->customer_name }},</p>
            <p class="p">Your retail acquisition is verified. We are processing your items for fulfillment. Below are your transaction credentials.</p>
            
            <!-- Order Card -->
            <div class="order-card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Product Manifest</div>
                        <div style="font-size: 18px; font-weight: 900; margin-top: 8px; color: #172554;">{{ $booking->service->name }}</div>
                    </div>
                    <div class="order-id">#{{ $booking->id }}</div>
                </div>
                
                <div class="card-body">
                    <div style="flex: 1;">
                        <div class="info-row">
                            <span class="label">Transaction Date</span>
                            <span class="value">{{ \Carbon\Carbon::parse($booking->booking_date)->format('D, M d, Y') }}</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="label">Distribution Point</span>
                            <span class="value">{{ $booking->event_location }}</span>
                        </div>
                        
                        <div class="info-row" style="margin-bottom: 0;">
                            <span class="label">Total Liquidity</span>
                            <span class="value value-red">Rs. {{ number_format($booking->total_price) }}</span>
                        </div>
                    </div>
                    <div style="text-align: center;">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ $booking->id }}-{{ $booking->status }}" style="width: 100px; height: 100px; padding: 10px; border: 1px solid #f1f5f9; border-radius: 12px;" alt="QR Verification">
                        <div style="font-size: 9px; font-weight: 900; color: #94a3b8; margin-top: 10px; text-transform: uppercase;">Secure Hash</div>
                    </div>
                </div>
            </div>
            
            <p class="p" style="text-align: center;">
                <a href="{{ route('bookings.index') }}" class="btn">Track My Orders</a>
            </p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} Gohar Martmerce Solution.<br>
            Official Transmission | support@hashamecom.com
        </div>
    </div>
</body>
</html>

