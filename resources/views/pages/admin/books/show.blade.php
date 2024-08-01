@extends('layouts.app-admin')

@section('title', $buku->judul . ' Detail')

@push('style')
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $buku->judul }} Detail</h1>
            </div>
            @php
                $totalBab = (int) $buku->total_bab;
                $currentBabCount = $babs->count();
            @endphp
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                @if ($currentBabCount < $totalBab)
                                    <form action="{{ route('admin.store.chapter', $buku->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        @for ($i = $currentBabCount + 1; $i <= $totalBab; $i++)
                                            <div class="form-group row mb-4">
                                                <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Bab
                                                    {{ $i }}
                                                    :</label>
                                                <div class="col-sm-12 col-md-10">
                                                    <input type="text" tabindex="1" class="form-control" id="bab"
                                                        name="bab[]" value="{{ old('bab.' . ($i - 1)) }}">
                                                </div>
                                            </div>
                                        @endfor

                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2"></label>
                                            <div class="col-sm-12 col-md-9">
                                                <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>
                                                    Tambah</button>
                                            </div>
                                        </div>
                                    </form>
                                @endif

                                @if ($currentBabCount == $totalBab)
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Bab</th>
                                                    <th>Author</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($babs as $key => $bab)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $bab->nama }}</td>
                                                        <td>{{ $bab->author->username ?? '' }}</td>
                                                        <td>{{ $bab->status->option }}</td>
                                                        <td>
                                                            <a class="btn btn-success btn-action" data-toggle="tooltip"
                                                                title="Detail"
                                                                href="{{ route('admin.show.chapter', $bab->id) }}"><i
                                                                    class="fas fa-list"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
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
