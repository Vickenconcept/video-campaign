@php
    $timer = is_array($step->timer_setting) ? $step->timer_setting : json_decode($step->timer_setting, true);
    $start = $timer['start_time'] ?? null;
    $end = $timer['end_time'] ?? null;
    $cta_url = $timer['cta_url'] ?? '';
    $cta_text = $timer['cta_text'] ?? '';
    $additional_text = $timer['additional_text'] ?? '';
    
    // Debug: Log timer data
    \Log::info('Timer data:', [
        'timer_setting' => $step->timer_setting,
        'parsed_timer' => $timer,
        'start' => $start,
        'end' => $end
    ]);
@endphp

<div class="max-w-lg mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-6 flex flex-col items-center space-y-4"
    x-data="timerCountdown({
        start: '{{ $start }}',
        end: '{{ $end }}'
    })" x-init="startCountdown()">
    <div class="w-full text-center">
        <h2 class="text-2xl font-bold mb-2">Countdown Timer</h2>
        
        @if ($additional_text)
            <p class="text-gray-600 mb-2">{{ $additional_text }}</p>
        @endif
        <div class="text-3xl font-mono font-semibold text-indigo-700 mb-4">
            <span x-text="days"></span>d
            <span x-text="hours"></span>h
            <span x-text="minutes"></span>m
            <span x-text="seconds"></span>s
        </div>
    </div>
    @if ($cta_url)
        <a :href="'{{ $cta_url }}'" target="_blank"
            class="w-full inline-block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition duration-200"
            :class="{ 'opacity-50 cursor-not-allowed': ctaDisabled }" :disabled="ctaDisabled">
            {{ $cta_text }}
        </a>
    @endif
</div>


