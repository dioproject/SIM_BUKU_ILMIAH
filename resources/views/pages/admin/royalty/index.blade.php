@extends('layouts.app-admin')

@section('title', 'Royalty')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Royalty</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    @foreach ($royalties as $royalty)
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                            <article class="article">
                                <div class="article-header">
                                    <div class="article-image"
                                        data-background="{{ Storage::url('upload/catalogs/' . $royalty->catalog->cover) }}">
                                    </div>
                                    <div class="article-title">
                                        <h2 class="text-white">{{ $royalty->catalog->book->title }}</h2>
                                    </div>
                                </div>
                                <div class="article-details">
                                    <p>Author: {{ $royalty->author->username }} <br>
                                        Amount: {{ $royalty->amount }} <br>
                                    </p>
                                    <div class="article-cta">
                                        <a href="#" class="btn btn-primary">Read More</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->

    <!-- Page Specific JS File -->
@endpush
