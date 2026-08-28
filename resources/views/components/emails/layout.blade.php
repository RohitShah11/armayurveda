<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>{{ $title }}</title></head>
<body style="margin:0;padding:0;background:#f1f8e9;font-family:Arial,Helvetica,sans-serif;color:#263328;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f1f8e9;padding:28px 12px;"><tr><td align="center">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:620px;background:#fff;border:1px solid #dce9d8;border-radius:18px;overflow:hidden;box-shadow:0 12px 35px rgba(27,94,32,.10);">
<tr><td align="center" style="padding:28px 24px 22px;background:#1b5e20;"><img src="{{ asset('images/arm-ayurveda-logo.png') }}" width="105" alt="ARM Ayurveda" style="display:block;width:105px;height:auto;padding:7px;background:#fff;border-radius:14px;"><div style="margin-top:14px;color:#d4af37;font-size:12px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;">Ayurveda • Wellness • Opportunity</div></td></tr>
<tr><td style="padding:34px 34px 30px;">{{ $slot }}</td></tr>
<tr><td align="center" style="padding:20px 24px;background:#f7fbf3;border-top:1px solid #e1ebde;color:#6b776c;font-size:12px;line-height:1.6;">© {{ now()->year }} ARM Ayurveda. This is an automated account notification.</td></tr>
</table></td></tr></table></body></html>
