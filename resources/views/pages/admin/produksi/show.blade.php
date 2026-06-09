@extends('layouts.app-admin')

@section('title', 'Detail Produksi - ' . ($produksi->final->buku->judul ?? 'N/A'))

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-industry"></i> Detail Produksi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('admin.index.produksi') }}">Produksi</a></div>
                    <div class="breadcrumb-item active">Detail</div>
                </div>
            </div>

            <div class="section-body">
                <x-flash-message />

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4><i class="fas fa-info-circle"></i> Informasi Produksi</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('admin.edit.produksi', $produksi->id) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="{{ route('admin.index.produksi') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="200">Judul Buku</th>
                                                <td>{{ $produksi->final->buku->judul ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Eksemplar</th>
                                                <td>{{ number_format($produksi->eksemplar) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tahun Terbit</th>
                                                <td>{{ $produksi->tahun_terbit }}</td>
                                            </tr>
                                            <tr>
                                                <th>Biaya Produksi</th>
                                                <td>Rp. {{ number_format($produksi->biaya_produksi, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Harga Jual</th>
                                                <td>Rp. {{ number_format($produksi->harga_jual, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Dibuat Pada</th>
                                                <td>{{ \Carbon\Carbon::parse($produksi->created_at)->translatedFormat('d F Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Terakhir Diupdate</th>
                                                <td>{{ \Carbon\Carbon::parse($produksi->updated_at)->translatedFormat('d F Y H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <h5><i class="fas fa-book"></i> Informasi Finalisasi</h5>
                                                <hr>
                                                <p><strong>ISBN:</strong> {{ $produksi->final->isbn ?? '-' }}</p>
                                                <p><strong>Cover:</strong>
                                                    @if ($produksi->final->cover)
                                                        <img src="{{ asset('storage/upload/covers/' . $produksi->final->cover) }}" alt="Cover" class="img-fluid img-thumbnail" style="max-height: 150px;">
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </p>
                                                <p><strong>File Final:</strong>
                                                    @if ($produksi->final->final_file)
                                                        <a href="{{ asset('storage/upload/finals/' . $produksi->final->final_file) }}" target="_blank" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-download"></i> Download PDF
                                                        </a>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection