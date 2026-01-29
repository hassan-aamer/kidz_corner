@extends('web.layouts.app')
@section('title', 'Too Many Requests')
@section('content')

    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-12">
                <div class="card border-0" style="border-radius:16px; box-shadow:0 8px 24px rgba(0,0,0,0.12);">
                    <div class="card-body text-center py-5">

                        {{-- Icon --}}
                        <div style="font-size:80px; margin-bottom:20px;">
                            ⏳
                        </div>

                        {{-- Title --}}
                        <h2 style="font-weight:700; color:#C73B65; margin-bottom:15px;">
                            Too Many Requests
                        </h2>

                        {{-- Message --}}
                        <p class="text-muted mb-4" style="font-size:16px;">
                            {{ $message ?? 'You have made too many requests. Please wait a moment before trying again.' }}
                        </p>

                        {{-- Countdown --}}
                        <div class="mb-4">
                            <p class="mb-2">Please wait:</p>
                            <div id="countdown" style="font-size:48px; font-weight:700; color:#1D9DB1;"
                                data-seconds="{{ $retryAfter ?? 60 }}">
                                {{ $retryAfter ?? 60 }}s
                            </div>
                        </div>

                        {{-- Button --}}
                        <a href="{{ url()->previous() }}" id="retryBtn" class="btn disabled"
                            style="background:#C73B65; color:#fff; border-radius:25px; padding:12px 40px; font-weight:600; opacity:0.5;">
                            <i class="fa fa-arrow-left mr-2"></i> Go Back
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var countdownEl = document.getElementById('countdown');
            var retryBtn = document.getElementById('retryBtn');
            var seconds = parseInt(countdownEl.dataset.seconds) || 60;

            var timer = setInterval(function () {
                seconds--;
                countdownEl.textContent = seconds + 's';

                if (seconds <= 0) {
                    clearInterval(timer);
                    countdownEl.textContent = '✅';
                    retryBtn.classList.remove('disabled');
                    retryBtn.style.opacity = '1';
                }
            }, 1000);
        });
    </script>
@endsection