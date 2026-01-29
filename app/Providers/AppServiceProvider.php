<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
    }

    /**
     * Configure rate limiting for the application.
     * Different limits for different actions to prevent abuse.
     */
    protected function configureRateLimiting(): void
    {
        // ═══════════════════════════════════════════════════════════════
        // 🔍 SEARCH RATE LIMITER
        // Prevents search spam and DoS attacks
        // ═══════════════════════════════════════════════════════════════
        RateLimiter::for('search', function (Request $request) {
            return Limit::perMinute(30)
                ->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return response()->view('errors.rate-limit', [
                        'message' => 'Too many search requests. Please wait a moment.',
                        'retryAfter' => $headers['Retry-After'] ?? 60,
                    ], 429, $headers);
                });
        });

        // ═══════════════════════════════════════════════════════════════
        // 🛒 CART RATE LIMITER
        // Prevents cart manipulation abuse
        // ═══════════════════════════════════════════════════════════════
        RateLimiter::for('cart', function (Request $request) {
            return Limit::perMinute(60)
                ->by($request->session()->getId() ?: $request->ip())
                ->response(function (Request $request, array $headers) {
                    return back()->with('error', 'Too many cart actions. Please slow down.');
                });
        });

        // ═══════════════════════════════════════════════════════════════
        // 📦 ORDER RATE LIMITER
        // Prevents fake order creation (very strict)
        // ═══════════════════════════════════════════════════════════════
        RateLimiter::for('order', function (Request $request) {
            return Limit::perMinute(5)
                ->by($request->session()->getId() ?: $request->ip())
                ->response(function (Request $request, array $headers) {
                    return back()->with('error', 'Too many order attempts. Please wait a minute.');
                });
        });

        // ═══════════════════════════════════════════════════════════════
        // 📧 SUBSCRIPTION RATE LIMITER
        // Prevents newsletter spam (very strict)
        // ═══════════════════════════════════════════════════════════════
        RateLimiter::for('subscription', function (Request $request) {
            return Limit::perHour(3)
                ->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return back()->with('error', 'Too many subscription attempts. Please try again later.');
                });
        });

        // ═══════════════════════════════════════════════════════════════
        // 📞 CONTACT RATE LIMITER
        // Prevents contact form spam
        // ═══════════════════════════════════════════════════════════════
        RateLimiter::for('contact', function (Request $request) {
            return Limit::perHour(5)
                ->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return back()->with('error', 'Too many messages. Please try again later.');
                });
        });

        // ═══════════════════════════════════════════════════════════════
        // 🌐 GLOBAL WEB RATE LIMITER
        // General protection for all web routes
        // ═══════════════════════════════════════════════════════════════
        RateLimiter::for('web', function (Request $request) {
            return Limit::perMinute(120)
                ->by($request->ip());
        });

        // ═══════════════════════════════════════════════════════════════
        // 🔐 LOGIN RATE LIMITER
        // Prevents brute force attacks on admin login
        // ═══════════════════════════════════════════════════════════════
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)
                ->by($request->ip())
                ->response(function (Request $request, array $headers) {
                    return back()->with('error', 'Too many login attempts. Please try again in a minute.');
                });
        });
    }
}
