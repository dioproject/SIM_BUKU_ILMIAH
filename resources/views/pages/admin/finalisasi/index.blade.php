@extends('layouts.app-admin')

@section('title', 'Finalisasi Buku')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-check-double"></i> Finalisasi Buku</h1>
            </div>
            <div class="section-body">
                <x-flash-message />
                <div class="row">
                    <div class="col-12">
                        <x-admin.card>
                            <div class="card-header">
                                <h4><i class="fas fa-list"></i> Daftar Finalisasi</h4>
                            </div>
                            <div class="card-body">
                                <x-admin.table :headers="['No.', 'Judul Buku', 'ISBN', 'Tanggal Finalisasi', 'Aksi']">
                                    @forelse ($finalisasis as $key => $finalisasi)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $finalisasi->buku->judul }}</td>
                                            <td>{{ $finalisasi->isbn }}</td>
                                            <td>{{ \Carbon\Carbon::parse($finalisasi->created_at)->translatedFormat('F Y') }}</td>
                                            <td>
                                                <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip"
                                                    title="Edit"
                                                    href="{{ route('admin.edit.finalisasi', $finalisasi->id) }}"><i
                                                        class="fas fa-pencil-alt"></i>
                                                </a>
                                                <a class="btn btn-secondary btn-action mr-1" data-toggle="tooltip"
                                                    title="Download"
                                                    href="{{ Storage::url('upload/merge/' . $finalisasi->merge) }}" download="{{ $finalisasi->merge }}"><i
                                                        class="fas fa-download"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">
                                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                                Belum ada finalisasi
                                            </td>
                                        </tr>
                                    @endforelse
                                </x-admin.table>
                            </div>
                            <x-admin.pagination :paginator="$finalisasis" />
                        </x-admin.card>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/page/modules-sweetalert.js') }}"></script>
@endpush
