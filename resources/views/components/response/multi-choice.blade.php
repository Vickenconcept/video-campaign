<div>
    this is the multi choice
    <div class="flex space-x-3">
        @foreach ($previous as $index => $prev)
            <button class="btn cursor-pointer" wire:click="goToPrevious({{ $step->id }},'{{ $index }}')">
                Back
            </button>
        @endforeach
        @if ($lastPosition != $step->id)
            @foreach ($nexts as $index => $next)
                <button class="btn cursor-pointer" wire:click="goToNext({{ $step->id }},'{{ $index }}')">
                    Continue
                </button>
            @endforeach
        @else
            <button class="btn cursor-pointer">
                Continue
            </button>
        @endif
    </div>
</div>
