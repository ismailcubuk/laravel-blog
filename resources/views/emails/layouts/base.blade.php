<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('email_title', 'Notification')</title>
</head>
@php
    $siteSettings = (isset($settings) && is_array($settings)) ? $settings : [];
    $siteName = $siteName ?? ($siteSettings['site_name'] ?? config('app.name', 'My Website'));
    $logoSrc = $brandLogoSrc ?? null;
    $iconSrc = $brandIconSrc ?? null;
    $monogram = strtoupper(substr((string) $siteName, 0, 1));
@endphp
<body style="margin:0;background:#f3f4f6;font-family:Arial,Helvetica,sans-serif;color:#111827;">
    <span style="display:none!important;visibility:hidden;opacity:0;height:0;width:0;overflow:hidden;">
        @yield('email_preheader', 'Notification from ' . $siteName)
    </span>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f3f4f6;padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="640" cellspacing="0" cellpadding="0" border="0" style="width:100%;max-width:640px;background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
                    <tr>
                        <td style="background:#0f172a;padding:16px 24px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td valign="middle" style="color:#e5e7eb;font-size:15px;font-weight:700;">
                                        @if($logoSrc)
                                            <img src="{{ $logoSrc }}" alt="{{ $siteName }}" style="height:34px;max-width:180px;display:block;object-fit:contain;">
                                        @else
                                            <span style="display:inline-block;padding:8px 10px;border-radius:8px;background:#1d4ed8;color:#ffffff;font-size:14px;font-weight:700;">{{ $siteName }}</span>
                                        @endif
                                    </td>
                                    <td align="right" valign="middle" style="color:#e5e7eb;font-size:14px;font-weight:700;">
                                        @if($iconSrc)
                                            <img src="{{ $iconSrc }}" alt="Icon" style="height:18px;width:18px;vertical-align:middle;margin-right:6px;object-fit:cover;border-radius:4px;background:#ffffff;">
                                        @else
                                            <span style="display:inline-block;height:18px;width:18px;line-height:18px;text-align:center;border-radius:4px;background:#2563eb;color:#ffffff;font-size:11px;font-weight:700;margin-right:6px;vertical-align:middle;">{{ $monogram }}</span>
                                        @endif
                                        <span style="vertical-align:middle;">{{ $siteName }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:28px 24px 24px 24px;line-height:1.65;font-size:15px;">
                            @yield('email_content')
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:16px 24px;background:#f9fafb;border-top:1px solid #e5e7eb;color:#6b7280;font-size:12px;line-height:1.6;">
                            This message was sent by {{ $siteName }}. Please do not reply directly to this email unless requested.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
