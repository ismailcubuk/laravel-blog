@extends('emails.layouts.base')

@section('email_title', 'Reply to Your Message')
@section('email_preheader', 'Your contact message has received a reply.')

@section('email_content')
    <h2 style="margin:0 0 16px;font-size:24px;color:#111827;">We replied to your message</h2>

    <p style="margin:0 0 16px;color:#374151;line-height:1.6;">
        Hello {{ $contactMessage->name }},
    </p>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;margin-bottom:16px;">
        <tr>
            <td style="padding:10px 12px;background:#f9fafb;width:140px;font-weight:700;">Subject</td>
            <td style="padding:10px 12px;">{{ $contactMessage->subject ?: 'No subject' }}</td>
        </tr>
        <tr>
            <td style="padding:10px 12px;background:#f9fafb;font-weight:700;border-top:1px solid #e5e7eb;vertical-align:top;">Your Message</td>
            <td style="padding:10px 12px;border-top:1px solid #e5e7eb;white-space:pre-wrap;">{{ $contactMessage->message }}</td>
        </tr>
    </table>

    <div style="border:1px solid #dbeafe;background:#eff6ff;border-radius:8px;padding:14px 16px;">
        <div style="font-weight:700;color:#1f2937;margin-bottom:8px;">Admin Reply</div>
        <div style="color:#374151;line-height:1.7;white-space:pre-wrap;">{{ $contactMessage->reply_message }}</div>
    </div>
@endsection
