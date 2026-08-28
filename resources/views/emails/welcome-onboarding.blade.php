<x-emails.layout title="Welcome to ARM Ayurveda">
    <div style="color:#d4af37;font-size:12px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;">Registration successful</div>
    <h1 style="margin:8px 0 14px;color:#1b5e20;font-size:28px;line-height:1.25;">Welcome to the ARM Ayurveda family!</h1>
    <p style="margin:0 0 14px;color:#526054;font-size:15px;line-height:1.7;">Dear {{ $user->name }},</p>
    <p style="margin:0 0 14px;color:#526054;font-size:15px;line-height:1.7;">Greetings from ARM Ayurveda Pvt. Ltd.!</p>
    <p style="margin:0 0 18px;color:#526054;font-size:15px;line-height:1.7;">Congratulations and a very warm welcome to the ARM Ayurveda family. We are pleased to inform you that your membership registration has been completed successfully.</p>
    <div style="margin:22px 0;padding:18px 20px;background:#f7fbf3;border-left:4px solid #d4af37;border-radius:10px;">
        <div style="margin-bottom:12px;color:#1b5e20;font-size:15px;font-weight:700;">Your Registration Details</div>
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="font-size:14px;line-height:1.7;">
            <tr><td style="padding:4px 0;color:#718073;">Member Name</td><td align="right" style="padding:4px 0;color:#263328;font-weight:700;">{{ $user->name }}</td></tr>
            <tr><td style="padding:4px 0;color:#718073;">Member ID</td><td align="right" style="padding:4px 0;color:#1b5e20;font-weight:700;">{{ $user->member_id }}</td></tr>
            <tr><td style="padding:4px 0;color:#718073;">Registered Mobile</td><td align="right" style="padding:4px 0;color:#263328;">{{ $user->mobile }}</td></tr>
            <tr><td style="padding:4px 0;color:#718073;">Joining Date</td><td align="right" style="padding:4px 0;color:#263328;">{{ $user->created_at?->format('d M Y') }}</td></tr>
        </table>
    </div>
    <p style="margin:0 0 16px;color:#526054;font-size:15px;line-height:1.7;">You can now log in to your account and access your profile, products, business information, team details, income reports, wallet and other available services.</p>
    <p style="margin:0 0 24px;color:#526054;font-size:15px;line-height:1.7;">We sincerely thank you for choosing ARM Ayurveda Pvt. Ltd. We look forward to being a part of your journey and wish you good health, growth and success ahead.</p>
    <div style="text-align:center;"><a href="{{ route('dashboard') }}" style="display:inline-block;padding:13px 25px;background:#2e7d32;border-radius:999px;color:#fff;text-decoration:none;font-weight:700;">Open Your Dashboard</a></div>
    <p style="margin:26px 0 8px;color:#1b5e20;font-size:16px;font-weight:700;">Welcome aboard! 🌿</p>
    <p style="margin:0;color:#526054;font-size:14px;line-height:1.7;">Warm Regards,<br><strong>Team ARM Ayurveda</strong><br>ARM Ayurveda Pvt. Ltd.<br>📞 +91 92420 68805<br>✉️ armayurveda@gmail.com</p>
</x-emails.layout>
