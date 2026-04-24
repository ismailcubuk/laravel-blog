@extends('layouts.main')

@section('title', $page->title)

@section('content')

  @push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/extracted/pages-about.css') }}">
@endpush

  <div class="heading-page header-text">
    <section class="page-heading">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="text-content">
              <h4>{{ $page->title }}</h4>
              <h2>{{ $page->title }}</h2>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <section class="about-us">
    <div class="container">

      {{-- HERO IMAGE + DESCRIPTION --}}
      <div class="row">
        <div class="col-lg-12">

          @if($page->hero_image)
            <img src="{{ asset($page->hero_image) }}" alt="{{ $page->title }}" class="img-fluid mb-4">
          @endif

          @if($page->description)
            @php
              $safeDescription = preg_replace('/\s+on[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', (string) $page->description);
              $safeDescription = preg_replace('/javascript\s*:/i', '', (string) $safeDescription);
            @endphp
            <div class="about-section-content">{!! strip_tags((string) $safeDescription, "<p><br><strong><em><ul><ol><li><a><h2><h3><h4><h5><h6><blockquote>") !!}</div>
          @endif

        </div>
      </div>

      {{-- DYNAMIC SECTIONS --}}
      @foreach($sections as $section)

        @php
          $type = $section->first()->section_type;

          $col = [
            'full-width' => 12,
            'two-columns' => 6,
            'three-columns' => 4,
            'four-columns' => 3
          ][$type] ?? 12;
        @endphp

        <div class="row mt-4">

          @foreach($section as $column)

            <div class="col-lg-{{ $col }} col-md-{{ $col }} mb-3">

              @if($column->title)
                <h4>{{ $column->title }}</h4>
              @endif

              @if($column->content)
                @php
                  $safeContent = preg_replace('/\s+on[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', (string) $column->content);
                  $safeContent = preg_replace('/javascript\s*:/i', '', (string) $safeContent);
                @endphp
                <div class="about-section-content">{!! strip_tags((string) $safeContent, "<p><br><strong><em><ul><ol><li><a><h2><h3><h4><h5><h6><blockquote>") !!}</div>
              @endif

            </div>

          @endforeach

        </div>

      @endforeach

    </div>
  </section>

@endsection


