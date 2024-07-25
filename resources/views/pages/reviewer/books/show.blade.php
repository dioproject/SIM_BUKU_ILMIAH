@extends('layouts.app-reviewer')

@section('title', 'Book Detail')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/prismjs/themes/prism.min.css') }}">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $book->title }} Book Detail</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                @foreach ($chapters as $key => $chapter)
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $key + 1 }}. {{ $chapter->chapter }}</strong>
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
                                    <ul class="list-group my-2">
                                        @if ($chapter->file_chapter)
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <i class="fas fa-file"></i>
                                                        <strong>{{ $chapter->file_chapter }}</strong>
                                                    </div>
                                                    <div class="col-md-1 text-right">
                                                        <a class="btn btn-secondary"
                                                            href="{{ Storage::url('upload/books/') . $chapter->file_chapter }}"
                                                            download="{{ $chapter->file_chapter }}"><i
                                                                class="fas fa-download"></i></a></td>
                                                    </div>
                                                    <div class="d-flex justify-content-between col-md-12 py-1">
                                                        <small>Author : {{ $chapter->author->username }}</small>
                                                        <small>Uploaded :
                                                            {{ \Carbon\Carbon::parse($chapter->uploaded_at)->translatedFormat('l, d F Y') }}</small>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                        @if ($chapter->file_review)
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <i class="fas fa-file"></i>
                                                        <strong>{{ $chapter->file_review }}</strong>
                                                    </div>
                                                    <div class="col-md-1 text-right">
                                                        <a class="btn btn-secondary"
                                                            href="{{ Storage::url('upload/books/') . $chapter->file_review }}"
                                                            download="{{ $chapter->file_review }}"><i
                                                                class="fas fa-download"></i></a></td>
                                                    </div>
                                                    <div class="d-flex justify-content-between col-md-12 py-1">
                                                        <small>Reviewer : {{ $chapter->reviewer->username }}</small>
                                                        <small>Reviewed :
                                                            {{ \Carbon\Carbon::parse($chapter->updated_at)->translatedFormat('l, d F Y') }}</small>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                        @if ($chapter->notes)
                                            <li class="list-group-item">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <strong>Notes : </strong>
                                                        <small>{{ $chapter->notes }}</small>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                        @if (!is_null($chapter->file_review) && $chapter->reviewer_id !== null)
                                            <li class="list-group-item">
                                                <form action="{{ route('reviewer.notes.review', $chapter->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <input type="text" name="notes" placeholder="Notes"
                                                                class="form-control" required>
                                                        </div>
                                                        <div class="col-md-2 text-right">
                                                            <button type="submit" class="btn btn-primary"><i
                                                                    class="fas fa-save"></i> Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </li>
                                        @endif
                                        @if ($chapter->file_chapter)
                                            <li class="list-group-item">
                                                <form action="{{ route('reviewer.upload.review', $chapter->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <input type="file" name="file_review"
                                                                class="form-control-file" accept=".doc,.docx" required>
                                                        </div>
                                                        <div class="col-md-2 text-right">
                                                            <button type="submit" class="btn btn-primary"><i
                                                                    class="fas fa-upload"></i> Upload</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </li>
                                        @endif
                                    </ul>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
@endpush
