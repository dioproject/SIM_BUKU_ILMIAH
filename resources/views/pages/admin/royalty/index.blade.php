@extends('layouts.app-admin')

@section('title', 'Daftar Royalti')

@push('style')
    <style>
        .money-display {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #28a745;
        }
    </style>
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><i class="fas fa-coins"></i> Daftar Royalti</h1>
        </div>
        <div class="section-body">
            <x-flash-message />
            
            <div class="row">
                <div class="col-12">
                    @php
                        $action = '<div class="d-flex align-items-center flex-wrap justify-content-between w-100">
                            <a href="' . route('admin.create.royalty') . '" class="btn btn-icon icon-left btn-primary mb-2">
                                <i class="far fa-edit"></i> Tambah Royalti
                            </a>
                            <form method="GET" action="' . route('admin.index.royalty') . '" class="mb-2">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search"
                                        value="' . e($search ?? '') . '" placeholder="Cari royalti...">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>';
                    @endphp
                    <x-admin.card :action="$action">
                        @if($royalties->count() > 0)
                            <x-admin.table :headers="['No', 'Judul Buku', 'Penulis', 'Bab', 'Penerbitan', 'Persentase', 'Royalti/Bab', 'Total Royalti']">
                                @foreach ($royalties as $key => $royalti)
                                    <tr>
                                        <td>{{ $royalties->firstItem() + $key }}</td>
                                        <td>
                                            <strong>{{ $royalti->penerbitan->final->buku->judul ?? '-' }}</strong>
                                        </td>
                                        <td>
                                            @if($royalti->user)
                                                <span class="badge badge-light">
                                                    <i class="fas fa-user"></i> {{ $royalti->user->username }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($royalti->bab)
                                                <span class="badge badge-light">
                                                    <i class="fas fa-book"></i> {{ $royalti->bab->nama }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($royalti->created_at)->translatedFormat('F Y') }}
                                        </td>
                                        <td>
                                            <span class="badge badge-primary">{{ $royalti->persentase }} %</span>
                                        </td>
                                        <td class="money-display">
                                            Rp. {{ number_format($royalti->royalti_bab, 0, ',', '.') }}
                                        </td>
                                        <td class="money-display">
                                            <strong>Rp. {{ number_format($royalti->total_royalti, 0, ',', '.') }}</strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </x-admin.table>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-coins fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada data royalti</h5>
                                <p class="text-muted">Klik tombol "Tambah Royalti" untuk membuat perhitungan royalti baru.</p>
                                <a href="{{ route('admin.create.royalty') }}" class="btn btn-primary">
                                    <i class="far fa-edit"></i> Tambah Royalti
                                </a>
                            </div>
                        @endif
                        
                        <x-admin.pagination :paginator="$royalties" />
                    </x-admin.card>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
@endpush
