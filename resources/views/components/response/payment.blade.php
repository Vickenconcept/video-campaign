<div>

    @php
        $currency = json_decode($campaign->paypal_keys, true);
        $currency = $currency['currency'];
    @endphp
    <div class="">
        <div class="flex justify-between text-gray-700">
            <p class="font-semibold">Amount</p>
            <p class="text-xl font-semibold">{{ $currency }}
                {{ $step->amount }}</p>
        </div>
        <div id="paypal-button-container" class="mt-4"></div>
    </div>
    <div class="flex space-x-3 pt-5 ">
        @if ($nextStep !== $firstPosition)
            @foreach ($previous as $index => $prev)
                <button class="btn cursor-pointer" wire:click="goToPrevious({{ $step->id }},'{{ $index }}')">
                    Back
                </button>
            @endforeach
        @endif
        {{-- @foreach ($nexts as $index => $next)
            @if ($loop->first)
                <button class="btn cursor-pointer" wire:click="goToNext({{ $step->id }}, '{{ $index }}')">
                    Continue
                </button>
            @endif
        @endforeach --}}
    </div>
</div>
