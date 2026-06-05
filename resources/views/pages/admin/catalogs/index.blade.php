@extends('layouts.app-admin')

@section('title', 'Katalog')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-book"></i> Katalog</h1>
            </div>
            <div class="section-body">
                <x-flash-message />
                <div class="row">
                    <div class="col-12">
                        @php
                            $action = '<div class="d-flex align-items-center flex-wrap justify-content-between w-100">
                                <a href="' . route('admin.create.catalog') . '" class="btn btn-icon icon-left btn-primary mb-2">
                                    <i class="fas fa-plus"></i> Tambah Katalog
                                </a>
                                <form method="GET" action="' . route('admin.index.catalog') . '" class="mb-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search"
                                            value="' . e($search ?? '') . '" placeholder="Cari katalog...">
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>';
                        @endphp

                        <x-admin.card :action="$action">
                            <x-admin.table :headers="['No.', 'Judul Buku', 'Pengarang', 'ISBN', 'Tahun', 'Kategori', 'Status']">
                                @forelse ($catalogs as $key => $catalog)
                                    @php
                                        $fallbackAuthors = '';
                                        if ($catalog->final && $catalog->final->buku && $catalog->final->buku->bab) {
                                            $fallbackAuthors = $catalog->final->buku->bab
                                                ->pluck('author.username')
                                                ->filter()
                                                ->unique()
                                                ->implode(', ');
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $catalogs->firstItem() + $key }}</td>
                                        <td>{{ $catalog->judul ?: ($catalog->final?->buku?->judul ?? '-') }}</td>
                                        <td>{{ $catalog->pengarang ?: ($fallbackAuthors ?: '-') }}</td>
                                        <td>{{ $catalog->isbn ?: ($catalog->final?->isbn ?? '-') }}</td>
                                        <td>{{ $catalog->tahun_terbit ?? '-' }}</td>
                                        <td>{{ $catalog->kategori ?? '-' }}</td>
                                        <td>
                                            @if ($catalog->status_publish)
                                                <span class="badge badge-success">Terbit</span>
                                            @else
                                                <span class="badge badge-secondary">Draft</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                            Belum ada katalog
                                        </td>
                                    </tr>
                                @endforelse
                            </x-admin.table>
                            <x-admin.pagination :paginator="$catalogs" />
                        </x-admin.card>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
