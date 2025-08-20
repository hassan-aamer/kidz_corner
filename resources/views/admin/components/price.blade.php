<div class="col-xl-6 col-sm-4">
    <div class="mb-3 mt-3 mt-sm-0">
        <label class="form-label" for="price">@lang('attributes.price')</label>
        <input type="number" name="price" parsley-trigger="change" placeholder="@lang('attributes.price')"
            class="form-control @error('price') is-invalid @enderror"
            value="{{ old('price', isset($result) ? $result->price : '') }}">
        @error('price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
