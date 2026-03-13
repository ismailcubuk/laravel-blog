@extends('emails.layouts.base')

@section('email_title', 'Confirm New Email')
@section('email_preheader', 'Please confirm your new email address to complete this profile update.')

@section('email_content')
    <h2 style="margin:0 0 14px;font-size:28px;line-height:1.25;color:#111827;">Email Change Request</h2>

    <p style="margin:0 0 16px;">Hi {{ $name }},</p>
    <p style="margin:0 0 20px;">We received a request to change your account email address. Confirm this new address to complete the update.</p>

    <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin:0 0 20px;">
        <tr>
            <td>
                <a href="{{ $verifyUrl }}" style="display:inline-block;background:#2563eb;color:#ffffff;text-decoration:none;padding:10px 18px;border-radius:8px;font-weight:700;">Confirm New Email</a>
            </td>
        </tr>
    </table>

    <p style="margin:0;color:#6b7280;">If you did not request this change, you can safely ignore this email.</p>
@endsection
