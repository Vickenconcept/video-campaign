<div>
    <div class="">
        @if ($step->calender_link)
            <iframe width="100%" height="500" style="border:none;" src="{{ $step->calender_link }}"></iframe>
        @else
            <p>Loading ...</p>
        @endif
    </div>
    {{-- https://calendly.com/kuhstomatica/demo --}}
</div>
