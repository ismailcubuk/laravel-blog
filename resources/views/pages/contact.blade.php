@extends('layouts.main')

@section('title', 'İletişim')
@section('meta_description', 'Sorularınız, önerileriniz ve iş birlikleri için iletişim formunu kullanabilirsiniz.')

@section('content')
<div class="heading-page header-text">
    <section class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-content">
                        <h4>{{ $page->title ?? 'İletişim' }}</h4>
                        <h2>Bizimle iletişimde kalın</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<section class="contact-us">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="down-contact">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="sidebar-item contact-form">
                                <div class="sidebar-heading">
                                    <h2>Bize mesaj gönderin</h2>
                                </div>

                                <div class="content">
                                    @if(session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    @if($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('contact.submit') }}">
                                        @csrf
                                        <input type="text" name="website" value="" tabindex="-1" autocomplete="off" class="d-none" aria-hidden="true">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <input name="name" type="text" placeholder="Adınız" value="{{ old('name') }}" required>
                                            </div>

                                            <div class="col-md-6 col-sm-12">
                                                <input name="email" type="email" placeholder="E-posta adresiniz" value="{{ old('email') }}" required>
                                            </div>

                                            <div class="col-md-12 col-sm-12">
                                                <input name="subject" type="text" placeholder="Konu" value="{{ old('subject') }}">
                                            </div>

                                            <div class="col-lg-12">
                                                <textarea name="message" rows="6" placeholder="Mesajınız" required>{{ old('message') }}</textarea>
                                            </div>

                                            <div class="col-lg-12">
                                                <button type="submit" class="main-button">Mesaj Gönder</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="sidebar-item contact-information">
                                <div class="sidebar-heading">
                                    <h2>İletişim Bilgileri</h2>
                                </div>

                                <div class="content">
                                    <ul>
                                        <li>
                                            <h5>{{ !empty($page->contact_phone) ? $page->contact_phone : 'Telefon numaranız' }}</h5>
                                            <span>Telefon</span>
                                        </li>
                                        <li>
                                            <h5>{{ !empty($page->contact_email) ? $page->contact_email : 'E-posta adresiniz' }}</h5>
                                            <span>E-posta</span>
                                        </li>
                                        <li>
                                            <h5>{{ !empty($page->contact_address) ? $page->contact_address : 'Adres bilginiz' }}</h5>
                                            <span>Adres</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 mt-4">
                <div id="map">
                    @if($page->contact_map_src)
                        <iframe src="{{ $page->contact_map_src }}" width="100%" height="450" frameborder="0" style="border:0;" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen sandbox="allow-scripts allow-same-origin allow-popups"></iframe>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

