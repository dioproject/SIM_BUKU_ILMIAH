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
                            <x-admin.table :headers="['No.', 'Judul Buku', 'Eksemplar', 'Penerbitan', 'Biaya Produksi', 'Harga Jual', 'Aksi']">
                                @forelse ($produksis as $key => $produksi)
                                    <tr>
                                        <td>{{ $produksis->firstItem() + $key }}</td>
                                        <td>{{ $produksi->final->buku->judul ?? '-' }}</td>
                                        <td>{{ $produksi->eksemplar }}</td>
                                        <td>{{ \Carbon\Carbon::parse($produksi->created_at)->translatedFormat('F Y') }}
                                        </td>
                                        <td>Rp. {{ number_format($produksi->biaya_produksi, 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format($produksi->harga_jual, 0, ',', '.') }}</td>
                                        <td>
                                            <a class="btn btn-info btn-action mr-1" data-toggle="tooltip"
                                                title="Detail"
                                                href="{{ route('admin.show.produksi', $produksi->id) }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a class="btn btn-warning btn-action mr-1" data-toggle="tooltip"
                                                title="Edit"
                                                href="{{ route('admin.edit.produksi', $produksi->id) }}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button class="btn btn-danger btn-action" data-toggle="tooltip"
                                                title="Hapus"
                                                onclick="confirmDelete({{ $produksi->id }}, '{{ $produksi->final->buku->judul ?? 'produksi ini' }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $produksi->id }}"
                                                action="{{ route('admin.destroy.produksi', $produksi->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
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
    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus Produksi',
                text: 'Apakah Anda yakin ingin menghapus produksi "' + name + '"?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash"></i> Hapus',
                cancelButtonText: '<i class="fas fa-times"></i> Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endpush
