<div>

    @if ($lastPosition != $step->id)
        @foreach ($nexts as $index => $next)
            <button class="btn cursor-pointer" wire:click="goToNext({{ $step->id }},'{{ $index }}')">
                {{ $step->button_component }}
            </button>
        @endforeach
    @else
        <button class="btn">
            Finish
        </button>
    @endif
</div>
