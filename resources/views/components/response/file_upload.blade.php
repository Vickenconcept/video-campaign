<div>
    <div class="text-center">
        <button id="upload_widget" class="cloudinary-button">Upload files</button>
        <p class="text-sm font-semibold mt-2 text-slate-700">Click button to upload file , max of 100mb</p>
    </div>

    <div class="flex space-x-3 pt-5 ">
        @if ($nextStep !== $firstPosition)
            @foreach ($previous as $index => $prev)
                <button class="btn cursor-pointer" wire:click="goToPrevious({{ $step->id }},'{{ $index }}')">
                    Back
                </button>
            @endforeach
        @endif
        @foreach ($nexts as $index => $next)
            @if ($loop->first)
                <button
                    class="btn cursor-pointer"
                    wire:click="goToNext({{ $step->id }}, '{{ $index }}')">
                    Continue
                </button>
            @endif
        @endforeach
    </div>

</div>
