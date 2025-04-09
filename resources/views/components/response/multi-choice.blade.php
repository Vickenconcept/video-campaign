<div>
    <div class="space-y-4">
        @php
            $settings = json_decode($step->multi_choice_setting, true);
            $randomize = collect($settings)->firstWhere('name', 'randomize')['status'] ?? false;

            $displayOptions = $nexts;

            if ($randomize) {
                $keys = array_keys($displayOptions);
                shuffle($keys);

                $shuffledOptions = [];
                foreach ($keys as $key) {
                    $shuffledOptions[$key] = $displayOptions[$key];
                }

                $displayOptions = $shuffledOptions;
            }
        @endphp

        <div class="text-center font-semibold text-sm">
            @foreach ($settings as $key => $setting)
                @if ($setting['name'] == 'option_count' && $setting['status'] == 1)
                    You have {{ count($selectedOptions) }}/ {{ count($nexts) }} options
                @endif
            @endforeach
        </div>

        <div class="flex flex-col space-y-4">

            @php
                $allowMultipleSelect = false;

                foreach ($settings as $setting) {
                    if ($setting['name'] == 'multiple_select' && $setting['status'] == 1) {
                        $allowMultipleSelect = true;
                        break;
                    }
                }
            @endphp

            @if ($allowMultipleSelect)
                <div class="flex flex-col space-y-4 ">
                    @if ($lastPosition != $step->id)
                        @foreach ($displayOptions as $index => $next)
                            <label for="{{ $index }}"
                                class="btn2 cursor-pointer  flex justify-center block  @if (in_array($index, $selectedOptions)) border-2 border-blue-500 @else border-2 border-gray-300 @endif">
                                <span>
                                    {{ $index }}
                                    <input type="checkbox" wire:model.live="selectedOptions" value="{{ $index }}"
                                        class="hidden" id="{{ $index }}">
                                </span>
                            </label>
                        @endforeach
                    @else
                        <button class="btn cursor-pointer">
                            Continue
                        </button>
                    @endif
                </div>

                <div class="flex space-x-3 pt-5 ">
                    @if ($nextStep !== $firstPosition)
                        @foreach ($previous as $index => $prev)
                            <button class="btn cursor-pointer"
                                wire:click="goToPrevious({{ $step->id }},'{{ $index }}')">
                                Back
                            </button>
                        @endforeach
                    @endif
                    @foreach ($nexts as $index => $next)
                        @if ($loop->first)
                            <button
                                class="btn  {{ empty($this->selectedOptions) ? 'cursor-not-allowed opacity-50' : 'cursor-pointer' }}"
                                @if (empty($this->selectedOptions)) disabled @endif
                                wire:click="goToNext({{ $step->id }}, '{{ $index }}')">
                                Continue
                            </button>
                        @endif
                    @endforeach
                </div>
            @else
                @if ($lastPosition != $step->id)
                    @foreach ($nexts as $index => $next)
                        <button class="btn2 cursor-pointer flex justify-center w-full"
                            wire:click="goToNext({{ $step->id }}, '{{ $index }}')">
                            {{ $index }}
                        </button>
                    @endforeach
                @else
                    <button class="btn cursor-pointer">
                        Continue
                    </button>
                @endif
            @endif

        </div>

    </div>
</div>
