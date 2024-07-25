@extends('layouts.app-reviewer')

@section('title', $chapter->chapter . ' Detail')

@push('style')
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $chapter->chapter }} Detail</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $chapter->chapter }}</strong>
                                    @if ($chapter->status->option == 'Revisi')
                                        <span class="badge badge-primary">{{ $chapter->status->option }}</span>
                                    @elseif($chapter->status->option == 'Approve')
                                        <span class="badge badge-success">{{ $chapter->status->option }}</span>
                                    @elseif($chapter->status->option == 'Reject')
                                        <span class="badge badge-danger">{{ $chapter->status->option }}</span>
                                    @elseif($chapter->status->option == 'Submit')
                                        <span class="badge badge-warning">{{ $chapter->status->option }}</span>
                                    @elseif($chapter->status->option == 'Pending')
                                        <span class="badge badge-secondary">{{ $chapter->status->option }}</span>
                                    @endif
                                </div>
                                <ul class="list-group py-2">
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <i class="fas fa-file"></i>
                                                <strong>{{ $chapter->book->template->file_name }}</strong>
                                            </div>
                                            <div class="col-md-4 text-right">
                                                <a class="btn btn-secondary"
                                                    href="{{ Storage::url('upload/books/') . $chapter->book->template }}"
                                                    download="{{ $chapter->book->template }}"><i
                                                        class="fas fa-download"></i>
                                                </a>
                                                @if ($chapter->status->option == 'Pending')
                                                    <a class="btn btn-success" title="Submit"
                                                        href="{{ route('reviewer.submit.chapter', $chapter->id) }}"><i
                                                            class="fas fa-check"></i></a>
                                                @endif
                                            </div>
                                            <div class="d-flex justify-content-between col-md-12 py-1">
                                                @if ($chapter->chapter_id !== null)
                                                    <small class="text-danger align-middle">Deadline :
                                                        {{ \Carbon\Carbon::parse($chapter->deadline)->translatedFormat('l, d F Y') }}
                                                    </small>
                                                @endif
                                                @if ($chapter->status->option == 'Submit')
                                                    <small>Verified : {{ $chapter->updated_at }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    @if ($chapter->chapter_id !== null)
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <i class="fas fa-file"></i>
                                                    <strong>{{ $chapter->fileChapter->file_name }}</strong>
                                                </div>
                                                <div class="col-md-1 text-right">
                                                    <a class="btn btn-secondary"
                                                        href="{{ Storage::url('upload/books/') . $chapter->fileChapter->file_name }}"
                                                        download="{{ $chapter->fileChapter->file_name }}"><i
                                                            class="fas fa-download"></i></a></td>
                                                </div>
                                                <div class="d-flex justify-content-between col-md-12 py-1">
                                                    <small>Author : {{ $chapter->fileChapter->user->username }}</small>
                                                    @if ($chapter->status->option !== 'Pending')
                                                        <small>Uploaded : {{ $chapter->fileChapter->created_at }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if ($chapter->review !== null)
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <i class="fas fa-file"></i>
                                                    <strong>{{ $chapter->fileReview->file_name }}</strong>
                                                </div>
                                                <div class="col-md-1 text-right">
                                                    <a class="btn btn-secondary"
                                                        href="{{ Storage::url('upload/books/') . $chapter->fileReview->file_name }}"
                                                        download="{{ $chapter->fileReview->file_name }}"><i
                                                            class="fas fa-download"></i></a>
                                                </div>
                                                <div class="d-flex justify-content-between col-md-12 py-1">
                                                    <small>Reviewer : {{ $chapter->fileReview->user->username }}</small>
                                                    @if ($chapter->status->option !== 'Pending')
                                                        <small>Reviewed : {{ $chapter->fileReview->created_at }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if ($chapter->status->option == 'Revisi')
                                        <li class="list-group-item">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <strong>Notes :</strong>
                                                    <br>
                                                    <p>{{ $chapter->notes }}</p>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush
