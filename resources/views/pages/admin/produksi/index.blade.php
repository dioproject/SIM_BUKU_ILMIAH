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
                        @php
                            $action = '<div class="d-flex align-items-center flex-wrap justify-content-between w-100">
                                <a href="' . route('admin.create.produksi') . '" class="btn btn-icon icon-left btn-primary mb-2">
                                    <i class="fas fa-plus"></i> Tambah Produksi
                                </a>
                                <form method="GET" action="' . route('admin.index.produksi') . '" class="mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search"
                                            value="' . e($search ?? '') . '" placeholder="Cari produksi...">
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>';
                        @endphp
                        <x-admin.card :action="$action">
                            <x-admin.table :headers="['No.', 'Judul Buku', 'Eksemplar', 'Penerbitan', 'Biaya Produksi', 'Harga Jual']">
                                @forelse ($produksis as $key => $produksi)
                                    <tr>
                                        <td>{{ $produksis->firstItem() + $key }}</td>
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
