<?php

use App\Models\Cart;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

/**
 * Get site settings with caching for performance.
 * Cache is stored for 24 hours and can be cleared via clearSettingsCache().
 */
if (!function_exists('setting')) {
    function setting(?string $key = null, $default = null)
    {
        $settings = Cache::remember('site_settings', 60 * 60 * 24, function () {
            return \App\Models\Setting::first();
        });

        if (!$settings) {
            return $default;
        }

        if (is_null($key)) {
            return $settings;
        }

        if (in_array($key, $settings->translatable ?? []) && method_exists($settings, 'getTranslation')) {
            return $settings->getTranslation($key, app()->getLocale()) ?? $default;
        }

        return $settings->{$key} ?? $default;
    }
}

/**
 * Clear settings cache - call this after updating settings.
 */
if (!function_exists('clearSettingsCache')) {
    function clearSettingsCache(): void
    {
        Cache::forget('site_settings');
    }
}

if (!function_exists('shortenText')) {
    function shortenText($text, $length = 50)
    {
        return Str::limit($text, $length);
    }
}

if (!function_exists('syncRelations')) {
    function syncRelations($model, array $data, array $relations): void
    {
        foreach ($relations as $field => $relation) {
            if (!empty($data[$field])) {
                $model->$relation()->sync($data[$field]);
            }
        }
    }
}

function dateFormatted($date, $format = 'M d, Y', $showTimes = false)
{
    if ($showTimes) {
        $format = $format . ' @ h:i a';
    }
    return date($format, strtotime($date));
}

/**
 * Get cart item count with caching for performance.
 * Cache is stored for 30 minutes per session.
 */
if (!function_exists('cartItemCount')) {
    function cartItemCount()
    {
        $sessionId = session()->getId();
        $cacheKey = "cart_count_{$sessionId}";
        
        return Cache::remember($cacheKey, 60 * 30, function () use ($sessionId) {
            $cart = Cart::where('session_id', $sessionId)->first();
            return $cart ? $cart->items()->sum('quantity') : 0;
        });
    }
}

/**
 * Clear cart count cache - call this after cart modifications.
 */
if (!function_exists('clearCartCache')) {
    function clearCartCache(?string $sessionId = null): void
    {
        $sessionId = $sessionId ?? session()->getId();
        Cache::forget("cart_count_{$sessionId}");
    }
}

if (!function_exists('formatDate')) {
    function formatDate($date, $format = 'Y-m-d H:i')
    {
        return \Carbon\Carbon::parse($date)->format($format);
    }
}
