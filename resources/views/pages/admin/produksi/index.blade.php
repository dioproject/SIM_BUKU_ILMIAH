@extends('layouts.app-admin')

@section('title', 'Produksi Buku')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-industry"></i> Produksi Buku</h1>
            </div>
            <div class="section-body">
                <x-flash-message />
                <div class="row">
                    <div class="col-12">
                        <x-admin.card>
                            <div class="card-header">
                                <h4><i class="fas fa-list"></i> Daftar Produksi</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('admin.create.produksi') }}" class="btn btn-icon icon-left btn-primary">
                                        <i class="fas fa-plus"></i> Tambah Produksi
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <x-admin.table :headers="['No.', 'Judul Buku', 'Eksemplar', 'Penerbitan', 'Biaya Produksi', 'Harga Jual']">
                                    @forelse ($produksis as $key => $produksi)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $produksi->final->buku->judul ?? '-' }}</td>
                                            <td>{{ $produksi->eksemplar }}</td>
                                            <td>{{ \Carbon\Carbon::parse($produksi->created_at)->translatedFormat('F Y') }}
                                            </td>
                                            <td>Rp. {{ number_format($produksi->biaya_produksi, 0, ',', '.') }}</td>
                                            <td>Rp. {{ number_format($produksi->harga_jual, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                                Belum ada data produksi
                                            </td>
                                        </tr>
                                    @endforelse
                                </x-admin.table>
                            </div>
                            <x-admin.pagination :paginator="$produksis" />
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
