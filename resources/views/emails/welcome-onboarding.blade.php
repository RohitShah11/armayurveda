<x-mail::message>
# Welcome to ARM Ayurveda, {{ $user->name }}!

Your registration was successful. We are delighted to have you as part of the ARM Ayurveda community.

Your Member ID is **{{ $user->member_id }}**. Keep it handy—you can use your email address, mobile number, or Member ID wherever requested by our team.

<x-mail::button :url="route('dashboard')">
Open Your Dashboard
</x-mail::button>

From your dashboard, you can complete your profile, explore products, and follow your ARM Ayurveda journey.

If you did not create this account, please contact our support team.

Regards,<br>
ARM Ayurveda
</x-mail::message>
