@extends('emails.layouts.base')

@section('email_title', 'Verify Your Email')
@section('email_preheader', 'Please verify your email address to activate your account.')

@section('email_content')
    <h2 style="margin:0 0 12px;font-size:24px;color:#111827;">Verify Your Email Address</h2>
    <p style="margin:0 0 16px;">Hello {{ $name }},</p>
    <p style="margin:0 0 20px;">Thank you for registering. Please confirm your email address to activate your account and continue.</p>

    <p style="margin:0 0 24px;">
        <a href="{{ $verifyUrl }}" style="display:inline-block;background:#2563eb;color:#ffffff;text-decoration:none;padding:10px 18px;border-radius:8px;font-weight:700;">Verify Email</a>
    </p>

    <p style="margin:0;color:#6b7280;">If you did not create this account, you can safely ignore this email.</p>
@endsection
