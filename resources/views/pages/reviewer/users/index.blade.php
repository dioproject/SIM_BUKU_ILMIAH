@extends('layouts.app-reviewer')

@section('title', 'Pengguna')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><i class="fas fa-users"></i> Pengguna</h1>
        </div>
        <div class="section-body">
            <x-flash-message />

            <div class="row">
                <div class="col-12">
                    <x-admin.card>
                        <div class="card-header">
                            <h4></h4>
                            <div class="card-header-action">
                                <form action="{{ route('reviewer.index.user') }}" method="GET">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" placeholder="Cari..."
                                            value="{{ request()->query('search') }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <x-admin.table :headers="['No', 'Nama', 'Peran', 'Dibuat Pada']">
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td>{{ $users->firstItem() + $key }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->user_role }}</td>
                                        <td>{{ $user->created_at }}</td>
                                    </tr>
                                @endforeach
                            </x-admin.table>
                        </div>

                        <x-admin.pagination :paginator="$users" />
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
