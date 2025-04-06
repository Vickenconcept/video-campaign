<div class="h-screen">
    {{-- @php
        $lastPosition = $steps->max('position');
        $firstPosition = $steps->min('position');
    @endphp --}}

    {{-- 
    
    @if ($step->answer_type == 'button')
        <p>button</p>
    @endif
    @if ($step->answer_type == 'calender')
        <p>calender</p>
    @endif

    @if ($step->answer_type == 'live_call')
        <p>live_call</p>
    @endif

    @if ($step->answer_type == 'NPS')
        <p>NPS</p>
    @endif

    @if ($step->answer_type == 'file_upload')
        <p>file_upload</p>
    @endif

    @if ($step->answer_type == 'payment')
        <p>payment</p>
    @endif --}}

    @php
        $lastPosition = $steps->max('position');
        $firstPosition = $steps->min('position');
    @endphp
    @foreach ($steps as $step)
        @php
            $nexts = json_decode($step->multi_choice_question, true);
            $video_setting = json_decode($step->video_setting, true);
        @endphp
        @if ($step->position == $firstPosition && $nextStep == '')
            <div class="h-full w-full  overflow-hidden grid grid-cols-2" wire:transition>
                @php
                    $fit = $video_setting['fit'] ?? false;

                    $positionClasses = [
                        'top-left' => 'items-start justify-start',
                        'top-center' => 'items-start justify-center',
                        'top-right' => 'items-start justify-end',
                        'center-left' => 'items-center justify-start',
                        'center' => 'items-center justify-center',
                        'center-right' => 'items-center justify-end',
                        'bottom-left' => 'items-end justify-start',
                        'bottom-center' => 'items-end justify-center',
                        'bottom-right' => 'items-end justify-end',
                    ];

                    $alignment = !$fit
                        ? $positionClasses[$video_setting['position']] ?? 'items-center justify-center'
                        : '';
                @endphp

                <div class="h-full w-full bg-slate-300 flex {{ $alignment }}">
                    <div class="relative max-w-full max-h-full">
                        @if ($step->video_url)
                            <video controls class="mx-auto bg-slate-50/10 max-w-full max-h-full object-contain">
                                <source src="{{ $step->video_url }}" type="video/webm">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                        @if (!empty($video_setting['overlay_text']))
                            <div
                                class="absolute @if ($video_setting['overlay_bg'] ?? false) ) bg-black/30 @endif h-auto w-full left-0 top-0 p-5">
                                <p
                                    class="max-w-md mx-auto text-white text-center font-bold capitalize {{ $video_setting['text_size'] }}">
                                    {{ $video_setting['overlay_text'] ?? '' }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!--  -->
                <div class=" relative h-full bg-white flex justify-center items-center">
                    @if ($preview)
                        <div class="absolute h-auto w-full left-0 top-0 p-1 bg-gray-800">
                            <p class="max-w-md mx-auto text-white text-center font-medium text-sm">
                                You're in preview mode, answers won't be submitted
                            </p>
                        </div>
                    @endif
                    <div class="h-[80%] w-[80%] border rounded-md flex justify-center items-center p-10 overflow-y-auto">
                        {{-- {{ $step->name }} --}}
                        <div class="w-[80%]">
                            <div>
                                @if ($step->contact_detail)
                                    @php
                                        $form = json_decode($step->form, true);
                                    @endphp
                                    <div class="space-y-4">
                                        @foreach ($form as $field)
                                            @if ($field['active'])
                                                <div class="space-y-2">
                                                    <label for="{{ $field['name'] }}"
                                                        class="block font-semibold text-gray-700 capitalize">
                                                        {{ $field['label'] }}
                                                        @if ($field['required'])
                                                            <span class="text-red-500">*</span>
                                                        @endif
                                                    </label>

                                                    @switch($field['type'])
                                                        @case('text')
                                                        @case('email')

                                                        @case('tel')
                                                            <input type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                                                                id="{{ $field['name'] }}" class="form-control"
                                                                placeholder="{{ $field['label'] }}"
                                                                @if ($field['required']) required @endif>
                                                        @break

                                                        @case('checkbox')
                                                            <div class="flex items-center">
                                                                <input type="checkbox" name="{{ $field['name'] }}"
                                                                    id="{{ $field['name'] }}"
                                                                    class="h-4 w-4 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                                                <label for="{{ $field['name'] }}" class="ml-2 text-gray-700">
                                                                    {{ $field['label'] }}
                                                                </label>
                                                            </div>
                                                        @break

                                                        @default
                                                            <input type="text" name="{{ $field['name'] }}"
                                                                id="{{ $field['name'] }}" class="form-control"
                                                                placeholder="{{ $field['label'] }}">
                                                    @endswitch
                                                </div>
                                            @endif
                                        @endforeach
                                        @foreach ($nexts as $index => $next)
                                            @if ($loop->first)
                                                <button class="btn"
                                                    wire:click="goToNext({{ $step->id }},'{{ $index }}')">
                                                    {{-- {{ $index }} --}}
                                                    Continue
                                                </button>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    @if ($step->answer_type == 'open_ended')
                                        <p>open_ended</p>
                                    @endif

                                    @if ($step->answer_type == 'ai_chat')
                                        <p>ai_chat</p>
                                    @endif

                                    @if ($step->answer_type == 'multi_choice')
                                        <p>multi_choice</p>
                                    @endif
                                @endif
                            </div>






                            {{-- @foreach ($nexts as $index => $next)
                                <button class="btn"
                                    wire:click="goToNext({{ $step->id }},'{{ $index }}')">
                                    {{ $index }}
                                </button>
                            @endforeach --}}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($step->id == $nextStep)
            <div class="h-full w-full  overflow-hidden grid grid-cols-2" wire:transition>
                @php
                    $fit = $video_setting['fit'] ?? false;

                    $positionClasses = [
                        'top-left' => 'items-start justify-start',
                        'top-center' => 'items-start justify-center',
                        'top-right' => 'items-start justify-end',
                        'center-left' => 'items-center justify-start',
                        'center' => 'items-center justify-center',
                        'center-right' => 'items-center justify-end',
                        'bottom-left' => 'items-end justify-start',
                        'bottom-center' => 'items-end justify-center',
                        'bottom-right' => 'items-end justify-end',
                    ];

                    $alignment = !$fit
                        ? $positionClasses[$video_setting['position']] ?? 'items-center justify-center'
                        : '';
                @endphp

                <div class="h-full w-full bg-slate-300 flex {{ $alignment }}">
                    <div class="relative max-w-full max-h-full">
                        @if ($step->video_url)
                            <video controls class="mx-auto bg-slate-50/10 max-w-full max-h-full object-contain">
                                <source src="{{ $step->video_url }}" type="video/webm">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                        @if (!empty($video_setting['overlay_text']))
                            <div
                                class="absolute @if ($video_setting['overlay_bg'] ?? false) ) bg-black/30 @endif h-auto w-full left-0 top-0 p-5">
                                <p
                                    class="max-w-md mx-auto text-white text-center font-bold capitalize {{ $video_setting['text_size'] }}">
                                    {{ $video_setting['overlay_text'] ?? '' }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="relative h-full bg-white">
                    @if ($preview)
                        <div class="absolute h-auto w-full left-0 top-0 p-1 bg-gray-800">
                            <p class="max-w-md mx-auto text-white text-center font-medium text-sm">
                                You're in preview mode, answers won't be submitted
                            </p>
                        </div>
                    @endif
                    <div class="h-[80%] w-[80%] border rounded-md flex justify-center items-center">
                        {{-- {{ $step->name }} --}}
                        <div class="w-[50%]">
                            {{ $step->name }}
                            @if ($lastPosition != $step->id)
                                @foreach ($nexts as $index => $next)
                                    <button class="btn"
                                        wire:click="goToNext({{ $step->id }},'{{ $index }}')">
                                        {{ $index }}
                                    </button>
                                @endforeach
                            @else
                                <button class="btn">
                                    Finish
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach

    <p>{{ $nextStep }}</p>




</div>
