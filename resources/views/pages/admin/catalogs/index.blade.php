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
                        <x-admin.card>
                            <div class="card-header">
                                <h4><i class="fas fa-list"></i> Daftar Katalog</h4>
                                <div class="card-header-action">
                                    <form method="GET" action="{{ route('admin.index.catalog') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search"
                                                value="{{ $search ?? '' }}" placeholder="Cari...">
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-primary"><i
                                                        class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <x-admin.table :headers="['No.', 'Judul Buku', 'Penulis']">
                                    @forelse ($catalogs as $key => $catalog)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $catalog->final->buku->judul }}</td>
                                            <td>{{ $catalog->final->buku->bab->first()->author->username ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">
                                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                                Belum ada katalog
                                            </td>
                                        </tr>
                                    @endforelse
                                </x-admin.table>
                            </div>
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
