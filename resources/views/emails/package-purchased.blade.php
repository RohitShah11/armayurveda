<x-emails.layout title="Package purchase successful">
    <div style="color:#d4af37;font-size:12px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;">Payment successful</div>
    <h1 style="margin:8px 0 14px;color:#1b5e20;font-size:28px;line-height:1.25;">Your package is active!</h1>
    <p style="margin:0 0 14px;color:#526054;font-size:15px;line-height:1.7;">Dear {{ $user->name }},</p>
    <p style="margin:0 0 14px;color:#526054;font-size:15px;line-height:1.7;">Greetings from ARM Ayurveda Pvt. Ltd.! 🌿</p>
    <p style="margin:0 0 20px;color:#526054;font-size:15px;line-height:1.7;">Congratulations! We are pleased to inform you that your package purchase has been completed successfully.</p>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin:20px 0;background:#f7fbf3;border:1px solid #e1ebde;border-radius:12px;overflow:hidden;">
        <tr><td colspan="2" style="padding:14px 16px;color:#1b5e20;font-weight:700;border-bottom:1px solid #e1ebde;">Package Purchase Details</td></tr>
        <tr><td style="padding:12px 16px;color:#718073;border-bottom:1px solid #e1ebde;">Member Name</td><td align="right" style="padding:12px 16px;font-weight:700;border-bottom:1px solid #e1ebde;">{{ $user->name }}</td></tr>
        <tr><td style="padding:12px 16px;color:#718073;border-bottom:1px solid #e1ebde;">Member ID</td><td align="right" style="padding:12px 16px;border-bottom:1px solid #e1ebde;">{{ $user->member_id }}</td></tr>
        <tr><td style="padding:12px 16px;color:#718073;border-bottom:1px solid #e1ebde;">Package</td><td align="right" style="padding:12px 16px;color:#1b5e20;font-weight:700;border-bottom:1px solid #e1ebde;">{{ $purchase->package_name }}</td></tr>
        <tr><td style="padding:12px 16px;color:#718073;border-bottom:1px solid #e1ebde;">Amount paid</td><td align="right" style="padding:12px 16px;font-weight:700;border-bottom:1px solid #e1ebde;">₹{{ number_format((float) $purchase->package_price, 2) }}</td></tr>
        <tr><td style="padding:12px 16px;color:#718073;border-bottom:1px solid #e1ebde;">Purchase date</td><td align="right" style="padding:12px 16px;border-bottom:1px solid #e1ebde;">{{ $purchase->purchase_date?->format('d M Y, h:i A') }}</td></tr>
        <tr><td style="padding:12px 16px;color:#718073;">Order/Transaction ID</td><td align="right" style="padding:12px 16px;color:#263328;font-weight:700;">ARM-PKG-{{ str_pad((string) $purchase->id, 6, '0', STR_PAD_LEFT) }}</td></tr>
    </table>
    <p style="margin:0 0 16px;color:#526054;font-size:15px;line-height:1.7;">Your package has been successfully activated in your account. You can log in to your member dashboard to view your package details, order information and other available benefits.</p>
    <p style="margin:0 0 16px;color:#526054;font-size:15px;line-height:1.7;">Thank you for choosing ARM Ayurveda Pvt. Ltd. We truly appreciate your trust and association with us and wish you good health, prosperity and continued success.</p>
    <p style="margin:0 0 24px;color:#526054;font-size:15px;line-height:1.7;">Congratulations once again, and thank you for being a valued member of the ARM Ayurveda family! 🌿</p>
    <div style="text-align:center;margin-top:25px;"><a href="{{ route('package.purchase.invoice', $purchase) }}" style="display:inline-block;padding:13px 25px;background:#2e7d32;border-radius:999px;color:#fff;text-decoration:none;font-weight:700;">View Your Invoice</a></div>
    <p style="margin:26px 0 0;color:#526054;font-size:14px;line-height:1.7;">Warm Regards,<br><strong>Team ARM Ayurveda</strong><br>ARM Ayurveda Pvt. Ltd.<br>📞 +91 92420 68805<br>✉️ armayurveda@gmail.com</p>
</x-emails.layout>
