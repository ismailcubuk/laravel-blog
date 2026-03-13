@extends('emails.layouts.base')

@section('email_title', 'Password Reset Request')
@section('email_preheader', 'Use this secure link to reset your password.')

@section('email_content')
    <h2 style="margin:0 0 12px;font-size:24px;color:#111827;">Password Reset Request</h2>
    <p style="margin:0 0 16px;">Hello {{ $name }},</p>
    <p style="margin:0 0 20px;">We received a request to reset your password. Click the button below to set a new password.</p>

    <p style="margin:0 0 24px;">
        <a href="{{ $resetUrl }}" style="display:inline-block;background:#dc2626;color:#ffffff;text-decoration:none;padding:10px 18px;border-radius:8px;font-weight:700;">Reset Password</a>
    </p>

    <p style="margin:0;color:#6b7280;">If you did not request this, you can safely ignore this email.</p>
@endsection
