@extends('emails.layouts.base')

@section('email_title', 'Welcome')
@section('email_preheader', 'Your account has been verified successfully.')

@section('email_content')
    <h2 style="margin:0 0 12px;font-size:24px;color:#111827;">Welcome, {{ $name }}!</h2>
    <p style="margin:0 0 16px;">Your email address has been verified successfully.</p>
    <p style="margin:0;">Your account is now active and ready to use.</p>
@endsection
