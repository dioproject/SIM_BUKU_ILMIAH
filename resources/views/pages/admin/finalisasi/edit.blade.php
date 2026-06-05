@extends('layouts.app-admin')

@section('title', 'Edit Finalisasi ' . $finalisasi->buku->judul)

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><i class="fas fa-edit"></i> Edit Finalisasi {{ $finalisasi->buku->judul }}</h1>
            </div>

            <div class="section-body">
                <x-flash-message />
                <div class="row">
                    <div class="col-12">
                        <x-admin.card>
                            <div class="card-header">
                                <h4><i class="fas fa-check-double"></i> Form Finalisasi</h4>
                            </div>
                            <div class="card-body">
                                <form id="form-validation" action="{{ route('admin.update.finalisasi', $finalisasi->id) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <x-admin.form-field label="ISBN" name="isbn">
                                        <input type="text" tabindex="1" class="form-control" id="isbn"
                                            name="isbn" value="{{ $finalisasi->isbn }} {{ old('isbn') }}" placeholder="Masukkan ISBN">
                                    </x-admin.form-field>
                                    <x-admin.form-field label="Sampul" name="cover">
                                        <input type="file" tabindex="2" class="form-control" id="cover"
                                            name="cover" value="{{ $finalisasi->cover }} {{ old('cover') }}" accept=".jpg,.jpeg,.png" placeholder="Pilih file sampul">
                                    </x-admin.form-field>
                                    <x-admin.form-field label="File Final" name="final_file">
                                        <input type="file" tabindex="3" class="form-control" id="final_file"
                                            name="final_file" value="{{ $finalisasi->final_file }} {{ old('final_file') }}" accept=".pdf" placeholder="Pilih file PDF final">
                                    </x-admin.form-field>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2"></label>
                                        <div class="col-sm-12 col-md-9">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                                Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
