<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page { margin: 0; }
        body { font-family: 'DejaVu Sans', sans-serif; color: #14532d; margin: 0; padding: 0; background: #ffffff; }
        .master-container { padding: 40px; }
        .header { background: #052e16; color: white; padding: 60px 40px; }
        .header table { width: 100%; border: none; }
        .brand h1 { margin: 0; font-size: 32px; letter-spacing: -1px; text-transform: uppercase; font-weight: 900; }
        .brand p { margin: 5px 0 0; font-size: 10px; font-weight: bold; letter-spacing: 2px; color: #94a3b8; text-transform: uppercase; }
        .meta { text-align: right; }
        .meta h2 { margin: 0; font-size: 24px; font-weight: 900; color: #f1f5f9; }
        .meta p { margin: 5px 0 0; font-size: 10px; color: #94a3b8; font-weight: bold; }
        
        .grid { width: 100%; margin: 40px 0; border-collapse: collapse; }
        .col { width: 50%; vertical-align: top; }
        .label { font-size: 9px; font-weight: 900; color: #64748b; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; }
        .value { font-size: 14px; font-weight: bold; color: #14532d; }
        
        .table-main { width: 100%; border-collapse: collapse; margin: 40px 0; }
        .table-main th { background: #f8fafc; text-align: left; padding: 15px; font-size: 10px; font-weight: 900; color: #64748b; text-transform: uppercase; border-bottom: 2px solid #e2e8f0; }
        .table-main td { padding: 20px 15px; border-bottom: 1px solid #f1f5f9; font-size: 13px; }
        .item-name { font-weight: bold; color: #052e16; display: block; margin-bottom: 4px; }
        .item-desc { font-size: 11px; color: #64748b; font-style: ; }
        
        .total-container { float: right; width: 300px; margin-top: 20px; }
        .total-row { padding: 15px; border-bottom: 1px solid #f1f5f9; }
        .total-row.grand { background: #052e16; color: white; border-radius: 8px; margin-top: 10px; }
        .total-label { font-size: 10px; font-weight: 900; text-transform: uppercase; }
        .total-value { text-align: right; font-weight: bold; font-size: 16px; }
        
        .footer { position: fixed; bottom: 40px; left: 40px; right: 40px; text-align: center; font-size: 10px; color: #94a3b8; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; border-top: 1px solid #f1f5f9; padding-top: 20px; }
        .verified-badge { background: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 20px; font-size: 8px; font-weight: 900; display: inline-block; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <table>
            <tr>
                <td class="brand">
                    <h1>GOHAR MART</h1>
                    <p>Premium Herbal & Organic Store</p>
                </td>
                <td class="meta">
                    <h2>OFFICIAL INVOICE</h2>
                    <p>REF: #INV-{{ str_pad($booking->id, 8, '0', STR_PAD_LEFT) }}</p>
                    <p>ISSUED: {{ $booking->created_at->format('M d, Y') }}</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="master-container">
        <table class="grid">
            <tr>
                <td class="col">
                    <div class="label">Customer Information</div>
                    <div class="value">{{ $booking->customer_name ?? ($booking->user->name ?? 'Valued Customer') }}</div>
                    <div class="value" style="font-weight: normal; font-size: 12px; margin-top: 3px;">Email: {{ $booking->customer_email ?? ($booking->user->email ?? 'N/A') }}</div>
                    <div class="value" style="font-weight: normal; font-size: 12px;">Phone: {{ $booking->customer_phone ?? 'N/A' }}</div>
                    @if(!empty($booking->event_location))
                    <div class="value" style="font-weight: normal; font-size: 12px; margin-top: 3px; color: #047857;">Address: {{ $booking->event_location }}</div>
                    @endif
                </td>
                <td class="col" style="text-align: right;">
                    <div class="label">Vendor / Partner</div>
                    <div class="value">{{ $booking->vendor->name ?? 'Gohar Mart Official' }}</div>
                    <div class="verified-badge">VERIFIED STORE PARTNER</div>
                </td>
            </tr>
        </table>

        <div class="label" style="margin-top: 40px;">Order Ledger</div>
        <table class="table-main">
            <thead>
                <tr>
                    <th>Service Execution</th>
                    <th>Ref ID</th>
                    <th style="text-align: right;">Allocation</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <span class="item-name">{{ $booking->service->name }}</span>
                        <span class="item-desc">Execution Date: {{ $booking->booking_date->format('M d, Y') }} | Location: {{ $booking->event_location }}</span>
                    </td>
                    <td>SVR-{{ $booking->service_id }}</td>
                    <td style="text-align: right; font-weight: 900;">PKR {{ number_format($booking->total_price ?? $booking->service->price) }}</td>
                </tr>
                @if(!empty($booking->booking_data['selected_addons']))
                    @foreach($booking->booking_data['selected_addons'] as $addon)
                        <tr>
                            <td><span class="item-desc">Signature Enhancement: {{ $addon }}</span></td>
                            <td>ADD-ON</td>
                            <td style="text-align: right; font-weight: bold;">Included</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <div class="total-container">
            <table style="width: 100%;">
                <tr class="total-row">
                    <td class="total-label">Subtotal Acquisition</td>
                    <td class="total-value">PKR {{ number_format($booking->total_price ?? $booking->service->price) }}</td>
                </tr>
                <tr class="total-row">
                    <td class="total-label">Platform Fee</td>
                    <td class="total-value">Waived</td>
                </tr>
                <tr class="total-row grand">
                    <td class="total-label" style="color: #94a3b8;">Total Investment</td>
                    <td class="total-value" style="font-size: 20px;">PKR {{ number_format($booking->total_price ?? $booking->service->price) }}</td>
                </tr>
            </table>
        </div>

        <div style="clear: both; margin-top: 80px; padding: 20px; background: #f8fafc; border-radius: 12px;">
            <div class="label" style="margin-bottom: 10px;">Security Disclaimer</div>
            <p style="font-size: 10px; color: #64748b; margin: 0; line-height: 1.6;"> This document serves as a digital proof of acquisition within the Eventia Elite Global Marketplace. The transaction initiated for the service " {{ $booking->service->name }} " is protected by our secure escrow system. For any disputes or verification of beneficiary status, please contact our elite support concierge at support@eventia.com referencing the Invoice ID.</p>
        </div>

        <div class="footer">
            Digital Signature: SECURE_HASH_{{ md5($booking->id . $booking->created_at) }} | AUTH_CERT_0392
        </div>
    </div>
</body>
</html>

