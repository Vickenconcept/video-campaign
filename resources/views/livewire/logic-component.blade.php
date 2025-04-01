<div>
    @if ($activeStep !== null)
        @if ($activeStep->answer_type == 'multi_choice')


            <div>
                <ul class="space-y-3">
                    @forelse ($multi_choice_question as $index => $option)
                        <div x-data="{ openDrawer: false }" @click.away="openDrawer = false" class="relative">
                            <li class="form-control cursor-pointer " @click="openDrawer = !openDrawer">
                                {{-- {{ $index }} --}}
                                <div class="flex space-x-5 font-semibold text-gray-800">
                                    <span>Always jump to</span>
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                                        </svg>
                                    </span>
                                </div>
                            </li>
                            <div x-show="openDrawer"
                                class="absolute -bottom-44 z-10 left-0 w-[60%] h-48 overflow-y-auto rounded-lg shadow-2xl bg-white p-5 ">
                                @php
                                    $campaignId = is_object($activeStep) ? $activeStep->campaign_id : $activeStep;
                                    $otherSteps = \App\Models\Step::where('campaign_id', $campaignId)
                                        ->when(is_object($activeStep), function ($query) use ($activeStep) {
                                            $query->where('id', '!=', $activeStep->id);
                                        })
                                        ->orderBy('position')
                                        ->get();
                                @endphp
                                <p class="text-gray-500 text-xs font-semibold mb-2">Choose a destination</p>
                                @foreach ($otherSteps as $step)
                                    <div class="py-2 cursor-pointer rounded-md bg-slate-100 p-2 mb-2 border border-slate-100 hover:border-black transition duration-500 ease-in-out"
                                        wire:click="setNextStep('{{ $index }}', {{ $step->position }})">
                                        <p class="text-gray-800 flex justify-between items-center  font-semibold">
                                            <span>{{ $step->name }}</span>

                                            @if ($option == $step->position)
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                @endforeach

                                @if ($otherSteps->isEmpty())
                                    <p class="text-gray-500 py-2">No other steps found in this campaign</p>
                                @endif

                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 py-2">No option created. Create one</p>
                    @endforelse
                </ul>
            </div>
        @else
            <div>
                this is others
            </div>
        @endif
    @endif
</div>
