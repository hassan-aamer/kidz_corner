<div class="col-xl-6 col-sm-4">
    <div class="mb-3 mt-3 mt-sm-0">
        <label class="form-label" for="quantity">@lang('attributes.quantity')</label>
        <input type="number" name="quantity" parsley-trigger="change" placeholder="@lang('attributes.quantity')"
            class="form-control @error('quantity') is-invalid @enderror"
            value="{{ old('quantity', isset($result) ? $result->quantity : '') }}">
        @error('quantity')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
