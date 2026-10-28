<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Confirmed - Gohar Mart</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #022c22; color: #333333; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        .header { background: linear-gradient(135deg, #022c22, #14532d); color: #ffffff; padding: 30px 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; letter-spacing: 2px; color: #86efac; }
        .header p { margin: 8px 0 0 0; font-size: 13px; color: #d1fae5; }
        .content { padding: 30px 25px; }
        .badge-confirmed { display: inline-block; background-color: #dcfce7; color: #166534; padding: 6px 14px; border-radius: 20px; font-weight: bold; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; }
        .order-card { background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 20px; }
        .order-title { font-size: 16px; font-weight: bold; color: #022c22; margin: 0 0 10px 0; }
        .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dashed #e2e8f0; font-size: 13px; }
        .detail-row:last-child { border-bottom: none; }
        .label { color: #64748b; font-weight: 600; }
        .value { color: #0f172a; font-weight: bold; }
        .total-box { background: #14532d; color: #ffffff; padding: 15px 20px; border-radius: 10px; text-align: right; margin-top: 15px; }
        .total-box h3 { margin: 0; font-size: 20px; color: #fef08a; }
        .footer { background-color: #f1f5f9; padding: 20px; text-align: center; font-size: 11px; color: #64748b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🌿 GOHAR MART</h1>
            <p>100% Pure Organic & Natural Remedies</p>
        </div>
        <div class="content">
            <div style="text-align: center;">
                <span class="badge-confirmed">✓ Order Confirmed</span>
            </div>
            
            <p style="font-size: 15px; line-height: 1.6; color: #334155;">
                Dear <strong>{{ $booking->customer_name ?? $booking->user->name ?? 'Valued Customer' }}</strong>,
            </p>
            <p style="font-size: 14px; line-height: 1.6; color: #475569;">
                Great news! Your order has been officially <strong>confirmed</strong> by Gohar Mart admin team and is now being processed for delivery.
            </p>

            <div class="order-card">
                <div class="order-title">📦 Order Summary (#BK-{{ $booking->id }})</div>
                
                <div class="detail-row">
                    <span class="label">Product Name:</span>
                    <span class="value">{{ $booking->service->name ?? 'Herbal Product' }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Quantity:</span>
                    <span class="value">{{ $booking->guest_count ?? 1 }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Customer Phone:</span>
                    <span class="value">{{ $booking->customer_phone ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Customer Email:</span>
                    <span class="value">{{ $booking->customer_email ?? $booking->user->email ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Delivery Address:</span>
                    <span class="value">{{ $booking->event_address ?? $booking->event_location ?? 'N/A' }}</span>
                </div>

                <div class="total-box">
                    <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #a7f3d0;">Total Amount Paid / COD</div>
                    <h3>PKR {{ number_format($booking->total_price ?? $booking->service->price ?? 0) }}</h3>
                </div>
            </div>

            <p style="font-size: 13px; color: #64748b; text-align: center; margin-top: 25px;">
                Thank you for choosing Gohar Mart for your organic health & botanical wellness needs!
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Gohar Mart. All rights reserved. <br/>
            Need help? Contact support@goharmart.pk
        </div>
    </div>
</body>
</html>
