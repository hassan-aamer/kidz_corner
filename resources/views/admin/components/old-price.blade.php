<div class="col-xl-6 col-sm-4">
    <div class="mb-3 mt-3 mt-sm-0">
        <label class="form-label" for="old_price">@lang('attributes.old_price')</label>
        <input type="number" name="old_price" parsley-trigger="change" placeholder="@lang('attributes.old_price')"
            class="form-control @error('old_price') is-invalid @enderror"
            value="{{ old('old_price', isset($result) ? $result->old_price : '') }}">
        @error('old_price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
