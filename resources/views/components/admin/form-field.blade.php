@props(['label' => '', 'name' => '', 'required' => false, 'error' => null])

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-4 col-lg-2">
        {{ $label }}
        @if ($required)
            <span class="text-danger">*</span>
        @endif
        :
    </label>
    <div class="col-sm-12 col-md-10">
        {{ $slot }}
        @if ($error)
            <div class="invalid-feedback">{{ $error }}</div>
        @endif
    </div>
</div>
