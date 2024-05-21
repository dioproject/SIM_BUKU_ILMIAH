@extends('layouts.app-admin')

@section('title', 'Edit User')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit User</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item">Data</div>
                    <div class="breadcrumb-item active"><a href="{{ route('admin.user.index') }}">Users</a></div>
                    <div class="breadcrumb-item active">Edit User</div>
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
                                <form id="form-validation" action="{{ route('admin.user.update', $user->id) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>First Name</label>
                                            <input type="text" class="form-control" tabindex="1" id="first-name"
                                                name="first-name" value="{{ $user->first_name }} {{ old('first_name') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" tabindex="2" id="long-name"
                                                name="long-name" value="{{ $user->last_name }} {{ old('last_name') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Email</label>
                                            <input type="email" class="form-control" tabindex="3" id="email"
                                                name="email" value="{{ $user->email }} {{ old('email') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Password</label>
                                            <input type="text" class="form-control" tabindex="4" id="password"
                                                name="password" value="{{ $user->password }} {{ old('password') }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Religion</label>
                                            <select class="form-control selectric" tabindex="5" name="religion"
                                                value="{{ $user->religion }} {{ old('religion') }}">
                                                <option value="ISLAM" {{ $user->religion === 'ISLAM' ? 'selected' : '' }}>
                                                    ISLAM</option>
                                                <option value="HINDU" {{ $user->religion === 'HINDU' ? 'selected' : '' }}>
                                                    HINDU</option>
                                                <option value="BUDHA" {{ $user->religion === 'BUDHA' ? 'selected' : '' }}>
                                                    BUDHA</option>
                                                <option value="KONGHUCU"
                                                    {{ $user->religion === 'KONGHUCU' ? 'selected' : '' }}>KONGHUCU
                                                </option>
                                                <option value="KRISTEN"
                                                    {{ $user->religion === 'KRISTEN' ? 'selected' : '' }}>KRISTEN</option>
                                                <option value="KATOLIK"
                                                    {{ $user->religion === 'KATOLIK' ? 'selected' : '' }}>KATOLIK</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Gender</label>
                                            <select class="form-control selectric" tabindex="6" id="gender"
                                                name="gender" value="{{ $user->gender }}">
                                                <option value="MALE" {{ $user->gender === 'MALE' ? 'selected' : '' }}>
                                                    MALE
                                                </option>
                                                <option value="FEMALE" {{ $user->gender === 'FEMALE' ? 'selected' : '' }}>
                                                    FEMALE</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Place of Birth</label>
                                            <input type="text" class="form-control" tabindex="7" id="place-of-birth"
                                                name="place-of-birth" tabindex="7" value="{{ $user->place_of_birth }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Date of Birth</label>
                                            <input type="date" class="form-control" tabindex="8" id="date-of-birth"
                                                name="date-of-birth" value="{{ $user->date_of_birth }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>User Role</label>
                                            <select class="form-control selectric" tabindex="9" name="user_role"
                                                value="{{ $user->user_role }}">
                                                <option value="ADMIN"
                                                    {{ $user->user_role === 'ADMIN' ? 'selected' : '' }}>ADMIN</option>
                                                <option value="EDITOR"
                                                    {{ $user->user_role === 'EDITOR' ? 'selected' : '' }}>EDITOR</option>
                                                <option value="AUTHOR"
                                                    {{ $user->user_role === 'AUTHOR' ? 'selected' : '' }}>AUTHOR</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <button type="submit" class="btn btn-primary"><i class="far fa-save"></i>
                                                Edit</button>
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
