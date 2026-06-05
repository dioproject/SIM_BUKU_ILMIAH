@extends('layouts.app-reviewer')

@section('title', 'Buat Ulasan')

@push('style')
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><i class="fas fa-comment"></i> Buat Ulasan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">Ulasan</div>
                <div class="breadcrumb-item">Buat</div>
            </div>
        </div>

        <div class="section-body">
            <x-flash-message />

            <div class="row">
                <div class="col-12">
                    <x-admin.card title="Form Ulasan" icon="comment">
                        <form action="{{ route('editor.store.review') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Judul Buku</label>
                                    <select class="form-control selectric" tabindex="1" id="book_id"
                                        name="book_id" value="{{ old('book_id') }}">
                                        @foreach ($books as $book)
                                            <option value="{{ $book->id }}"
                                                @if (old('book_id') == $book->id) selected @endif>
                                                {{ $book->judul }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Ulasan</label>
                                    <textarea class="form-control" tabindex="2" data-height="150" id="content" name="content">{{ old('content') }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>
                                        Simpan</button>
                                </div>
                            </div>
                        </form>
                    </x-admin.card>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
@endpush
