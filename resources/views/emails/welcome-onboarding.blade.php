<x-emails.layout title="Welcome to ARM Ayurveda">
    <div style="color:#d4af37;font-size:12px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;">Registration successful</div>
    <h1 style="margin:8px 0 14px;color:#1b5e20;font-size:28px;line-height:1.25;">Welcome, {{ $user->name }}!</h1>
    <p style="margin:0 0 18px;color:#526054;font-size:15px;line-height:1.7;">We are delighted to welcome you to the ARM Ayurveda community. Your account has been created successfully.</p>
    <div style="margin:22px 0;padding:18px 20px;background:#f7fbf3;border-left:4px solid #d4af37;border-radius:10px;">
        <div style="color:#718073;font-size:12px;text-transform:uppercase;letter-spacing:.8px;">Your Member ID</div>
        <div style="margin-top:5px;color:#1b5e20;font-size:22px;font-weight:700;">{{ $user->member_id }}</div>
    </div>
    <p style="margin:0 0 24px;color:#526054;font-size:15px;line-height:1.7;">Keep your Member ID handy. From your dashboard, you can complete your profile, explore products, and follow your ARM Ayurveda journey.</p>
    <div style="text-align:center;"><a href="{{ route('dashboard') }}" style="display:inline-block;padding:13px 25px;background:#2e7d32;border-radius:999px;color:#fff;text-decoration:none;font-weight:700;">Open Your Dashboard</a></div>
    <p style="margin:26px 0 0;color:#7a857b;font-size:12px;line-height:1.6;">If you did not create this account, please contact ARM Ayurveda support.</p>
</x-emails.layout>
