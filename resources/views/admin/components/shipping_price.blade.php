<div class="col-xl-6 col-sm-4">
    <div class="mb-3 mt-3 mt-sm-0">
        <label class="form-label" for="shipping_price">@lang('attributes.shipping_price')</label>
        <input type="number" name="shipping_price" parsley-trigger="change" placeholder="@lang('attributes.shipping_price')"
            class="form-control @error('shipping_price') is-invalid @enderror"
            value="{{ old('shipping_price', isset($result) ? $result->shipping_price : '') }}">
        @error('shipping_price')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
