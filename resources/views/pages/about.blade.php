@extends('layouts.main')

@section('title', $page->title)

@section('content')

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
            <p>{!! $page->description !!}</p>
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
                <p>{!! $column->content !!}</p>
              @endif

            </div>

          @endforeach

        </div>

      @endforeach

      {{-- SOCIAL ICONS --}}
      <div class="row mt-5">
        <div class="col-lg-12">
          <ul class="social-icons">

            <li>
              <a href="#">
                <i class="fa fa-facebook"></i>
              </a>
            </li>

            <li>
              <a href="#">
                <i class="fa fa-twitter"></i>
              </a>
            </li>

            <li>
              <a href="#">
                <i class="fa fa-behance"></i>
              </a>
            </li>

            <li>
              <a href="#">
                <i class="fa fa-linkedin"></i>
              </a>
            </li>

          </ul>
        </div>
      </div>

    </div>
  </section>

@endsection