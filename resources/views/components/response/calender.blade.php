<div>
    <div class="">
        @if ($step->calender_link)
            <iframe width="100%" height="500" style="border:none;" src="{{ $step->calender_link }}"></iframe>
        @else
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0 w-full">
                <div class='flex space-x-2 justify-center items-center bg-white h-32'>
                    <span class='sr-only'>Loading... </span>
                    <div class='h-8 w-8 bg-gray-900 rounded-full animate-bounce [animation-delay:-0.3s]'></div>
                    <div class='h-8 w-8 bg-gray-700 rounded-full animate-bounce [animation-delay:-0.15s]'>
                    </div>
                    <div class='h-8 w-8 bg-gray-600 rounded-full animate-bounce'></div>
                </div>
            </div>
        @endif
    </div>
    {{-- https://calendly.com/kuhstomatica/demo --}}
</div>
