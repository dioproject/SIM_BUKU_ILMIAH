@extends('layouts.app-author')

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
                    <x-admin.card>
                        <div class="card-header">
                            <h4>Royalti Saya</h4>
                            <div class="card-header-action">
                                <form method="GET" action="{{ route('author.index.royalty') }}">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search"
                                            value="{{ $search ?? '' }}" placeholder="Cari buku...">
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(isset($royalty) && $royalty->count() > 0)
                                <x-admin.table :headers="['No', 'Judul Buku', 'Penulis', 'Royalti', 'Status']">
                                    @foreach ($royalty as $key => $royal)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <strong>{{ $royal->buku->judul ?? '-' }}</strong>
                                            </td>
                                            <td>
                                                @if($royal->author)
                                                    <span class="badge badge-light">
                                                        <i class="fas fa-user"></i> {{ $royal->author->username }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="money-display">
                                                Rp. {{ number_format($royal->amount ?? 0, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                @if(isset($royal->status))
                                                    <x-status-badge :status="$royal->status" />
                                                @else
                                                    <span class="badge badge-secondary">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </x-admin.table>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-coins fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada data royalti</h5>
                                    <p class="text-muted">Data royalti Anda akan muncul di sini setelah buku diterbitkan.</p>
                                </div>
                            @endif
                        </div>
                        
                        @if(isset($royalty))
                            <x-admin.pagination :paginator="$royalty" />
                        @endif
                    </x-admin.card>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
@endpush
