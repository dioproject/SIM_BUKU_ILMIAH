@extends('layouts.app-author')
@section('title', 'Histori')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-history"></i> Histori</h1>
            </div>
            <div class="section-body">
                <x-flash-message />

                <x-admin.card title="Histori Aktivitas" icon="clock">
                    <x-admin.table :headers="['No.', 'Histori', 'Tanggal']">
                        @foreach ($history as $key => $his)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $his->detail }}</td>
                                <td>{{ $his->created_at }}</td>
                            </tr>
                        @endforeach
                    </x-admin.table>

                    <x-admin.pagination :paginator="$history" />
                </x-admin.card>
            </div>
        </section>
    </div>
@endsection
