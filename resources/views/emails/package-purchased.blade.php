<x-emails.layout title="Package purchase successful">
    <div style="color:#d4af37;font-size:12px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;">Payment successful</div>
    <h1 style="margin:8px 0 14px;color:#1b5e20;font-size:28px;line-height:1.25;">Your package is active!</h1>
    <p style="margin:0 0 20px;color:#526054;font-size:15px;line-height:1.7;">Hello {{ $user->name }}, your package purchase was completed successfully. Thank you for choosing ARM Ayurveda.</p>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin:20px 0;background:#f7fbf3;border:1px solid #e1ebde;border-radius:12px;overflow:hidden;">
        <tr><td style="padding:12px 16px;color:#718073;border-bottom:1px solid #e1ebde;">Package</td><td align="right" style="padding:12px 16px;color:#1b5e20;font-weight:700;border-bottom:1px solid #e1ebde;">{{ $purchase->package_name }}</td></tr>
        <tr><td style="padding:12px 16px;color:#718073;border-bottom:1px solid #e1ebde;">Amount paid</td><td align="right" style="padding:12px 16px;font-weight:700;border-bottom:1px solid #e1ebde;">₹{{ number_format((float) $purchase->package_price, 2) }}</td></tr>
        <tr><td style="padding:12px 16px;color:#718073;border-bottom:1px solid #e1ebde;">Purchase date</td><td align="right" style="padding:12px 16px;border-bottom:1px solid #e1ebde;">{{ $purchase->purchase_date?->format('d M Y, h:i A') }}</td></tr>
        <tr><td style="padding:12px 16px;color:#718073;border-bottom:1px solid #e1ebde;">Member ID</td><td align="right" style="padding:12px 16px;border-bottom:1px solid #e1ebde;">{{ $user->member_id }}</td></tr>
        <tr><td style="padding:12px 16px;color:#718073;">Status</td><td align="right" style="padding:12px 16px;color:#2e7d32;font-weight:700;">{{ $purchase->status }}</td></tr>
    </table>
    <div style="text-align:center;margin-top:25px;"><a href="{{ route('package.purchase.invoice', $purchase) }}" style="display:inline-block;padding:13px 25px;background:#2e7d32;border-radius:999px;color:#fff;text-decoration:none;font-weight:700;">View Your Invoice</a></div>
    <p style="margin:26px 0 0;color:#7a857b;font-size:12px;line-height:1.6;">Your payment was made from your ARM Ayurveda main wallet.</p>
</x-emails.layout>
