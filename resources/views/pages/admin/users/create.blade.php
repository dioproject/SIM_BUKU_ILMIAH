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
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>First Name</label>
                                            <input type="text" tabindex="1" class="form-control" id="first_name"
                                                name="first_name" value="{{ old('first_name') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Last Name</label>
                                            <input type="text" tabindex="2" class="form-control" id="last_name"
                                                name="last_name" value="{{ old('last_name') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Email</label>
                                            <input type="email" tabindex="3" class="form-control" id="email"
                                                name="email" value="{{ old('email') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Password</label>
                                            <input type="text" tabindex="4" class="form-control" id="password"
                                                name="password" value="{{ old('password') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Religion</label>
                                            <select class="form-control selectric" tabindex="5" id="religion"
                                                name="religion" value="{{ old('religion') }}">
                                                @foreach ($religion as $rel)
                                                    <option value="{{ $rel->id }}"
                                                        @if (old('religion') == $rel->id) selected @endif>
                                                        {{ $rel->option }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Gender</label>
                                            <select class="form-control selectric" tabindex="6" id="gender"
                                                name="gender" value="{{ old('gender') }}">
                                                @foreach ($gender as $gen)
                                                    <option value="{{ $gen->id }}"
                                                        @if (old('religion') == $gen->id) selected @endif>
                                                        {{ $gen->option }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Place of Birth</label>
                                            <input type="text" tabindex="7" class="form-control" id="place_of_birth"
                                                name="place_of_birth" value="{{ old('place_of_birth') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Date of Birth</label>
                                            <input type="date" tabindex="8" class="form-control" id="date_of_birth"
                                                name="date_of_birth" value="{{ old('date_of_birth') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Contact</label>
                                            <input type="text" tabindex="7" class="form-control" id="contact"
                                                name="contact" value="{{ old('contact') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>User Role</label>
                                            <select class="form-control selectric" tabindex="9" id="user_role"
                                                name="user_role" value="{{ old('user_role') }}">
                                                <option value="ADMIN" {{ old('user_role') == 'ADMIN' ? 'selected' : '' }}>
                                                    ADMIN</option>
                                                <option value="EDITOR"
                                                    {{ old('user_role') == 'EDITOR' ? 'selected' : '' }}>EDITOR</option>
                                                <option value="AUTHOR"
                                                    {{ old('user_role') == 'AUTHOR' ? 'selected' : '' }}>AUTHOR</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>
                                                Create</button>
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
