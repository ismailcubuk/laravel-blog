@extends('emails.layouts.base')

@section('email_title', 'New Contact Message')
@section('email_preheader', 'A new message was submitted from your contact form.')

@section('email_content')
    <h2 style="margin:0 0 16px;font-size:24px;color:#111827;">New Contact Form Message</h2>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;">
        <tr>
            <td style="padding:10px 12px;background:#f9fafb;width:140px;font-weight:700;">Name</td>
            <td style="padding:10px 12px;">{{ $payload['name'] }}</td>
        </tr>
        <tr>
            <td style="padding:10px 12px;background:#f9fafb;font-weight:700;border-top:1px solid #e5e7eb;">Email</td>
            <td style="padding:10px 12px;border-top:1px solid #e5e7eb;">{{ $payload['email'] }}</td>
        </tr>
        <tr>
            <td style="padding:10px 12px;background:#f9fafb;font-weight:700;border-top:1px solid #e5e7eb;">Subject</td>
            <td style="padding:10px 12px;border-top:1px solid #e5e7eb;">{{ $payload['subject'] ?: 'No subject' }}</td>
        </tr>
        <tr>
            <td style="padding:10px 12px;background:#f9fafb;font-weight:700;border-top:1px solid #e5e7eb;vertical-align:top;">Message</td>
            <td style="padding:10px 12px;border-top:1px solid #e5e7eb;white-space:pre-wrap;">{{ $payload['message'] }}</td>
        </tr>
    </table>
@endsection
