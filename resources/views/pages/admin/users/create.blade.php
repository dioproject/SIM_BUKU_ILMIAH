@extends('layouts.app-admin')

@section('title', 'Create User')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create User</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Users</div>
                    <div class="breadcrumb-item active">Create</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form id="create-user-form" action="{{ route('admin.store.user') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row mb-4">
                                        <label
                                            class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Username</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="text" tabindex="1" class="form-control" id="username"
                                                name="username" value="{{ old('username') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Name</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="text" tabindex="2" class="form-control" id="name"
                                                name="name" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Email</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="email" tabindex="3" class="form-control" id="email"
                                                name="email" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label
                                            class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Password</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="text" tabindex="4" class="form-control" id="password"
                                                name="password" value="{{ old('password') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">Contact</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input type="number" tabindex="5" class="form-control" id="contact"
                                                name="contact" value="{{ old('contact') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">User
                                            Role</label>
                                        <div class="col-sm-12 col-md-10">
                                            <select class="form-control selectric" tabindex="6" id="user_role"
                                                name="user_role" value="{{ old('user_role') }}">
                                                <option value="ADMIN" {{ old('user_role') == 'ADMIN' ? 'selected' : '' }}>
                                                    ADMIN</option>
                                                <option value="REVIEWER" {{ old('user_role') == 'REVIEWER' ? 'selected' : '' }}>
                                                    REVIEWER</option>
                                                <option value="AUTHOR"
                                                    {{ old('user_role') == 'AUTHOR' ? 'selected' : '' }}>AUTHOR
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2"></label>
                                        <div class="col-sm-12 col-md-9">
                                            <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>
                                                Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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
