<div>

    <section class="grid lg:grid-cols-7 gap-5" x-data="{ activeResponse: null }">
        <div class="lg:col-span-3">
            <div class="max-w-sm mx-auto">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <ul class="divide-y divide-gray-200">
                        @forelse ($responses as $key =>  $response)
                            {{-- @php
                                $individualResponses = $responsesByToken[$response->user_token] ?? collect();
                            @endphp

                            <h3 class="font-semibold text-md">Original Responses:</h3>
                            @foreach ($individualResponses as $r)
                                <div class="ml-4 mb-2 text-sm">
                                    <p>- Name: {{ $r->name }}</p>
                                    <p> Email: {{ $r->email }}</p>
                                    <p> Created At: {{ $r->created_at }}</p>
                                </div>
                            @endforeach --}}
                            <li
                                class="p-3 flex justify-between items-center user-card hover:shadow-2xl transition duration-500 ease-in-out">
                                <div class="flex items-center w-[60%] cursor-pointer"
                                    @click="activeResponse = @js($response)"
                                    wire:click="setResponse('{{ $response->user_token }}')">
                                    <img class="w-10 h-10 rounded-full"
                                        src="https://unsplash.com/photos/oh0DITWoHi4/download?force=true&w=640"
                                        alt="Christy">
                                    <p>
                                        <span class="ml-3 font-medium  capitalize truncate">
                                            {{ $response->name }}
                                        </span>
                                        <span class="ml-3 font-medium truncate text-xs text-gray-500">
                                            {{ $response->email }}
                                        </span>
                                    </p>
                                </div>
                                <div class="flex space-x-1">
                                    {{-- <a href="#" class="text-gray-500 hover:text-gray-700 cursor-pointer ">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a> --}}
                                    <button class="text-gray-500 hover:text-gray-700 cursor-pointer ">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6h16M4 12h16m-7 6h7" />
                                        </svg>
                                    </button>
                                </div>
                            </li>
                        @empty
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>


        <div class="lg:col-span-4  h-[450px] bg-slate-500 rounded-lg overflow-hidden pb-5 " wire:key="active-{{ now() }}">
            @php
                $individualResponses = $responsesByToken[$activeResponse->user_token] ?? collect();
            @endphp
            @if (!empty($activeResponse))
                <div class="relative h-full">
                    @if (optional($activeResponse)->video)
                        <div class="relative h-full ">
                            @foreach ($individualResponses as $index => $res)
                                @if ($index == $activeIndex)
                                    {{-- <video controls class="mx-auto bg-slate-50/10 max-w-full  object-contain">
                                        <source src="{{ optional($activeResponse)->video }}" type="video/webm">
                                    </video> --}}

                                    @if (!empty($res->video))
                                        <video controls class="mx-auto bg-slate-50/10 max-w-full  object-contain">
                                            <source src="{{ optional($activeResponse)->video }}" type="video/webm">
                                        </video>
                                    @elseif (!empty($res->audio))
                                        <div class="h-full flex justify-center items-center p-10">
                                            <audio controls class="mx-auto w-full">
                                                <source src="{{ $res->audio }}" type="audio/mpeg">
                                                Your browser does not support the audio element.
                                            </audio>
                                        </div>
                                    @elseif (!empty($res->text))
                                        <div>
                                            text
                                        </div>
                                    @endif
                                    {{-- <div>
                                        {{ $index }}
                                    </div> --}}
                                @endif
                            @endforeach
                        </div>
                    @endif





                    <div class="absolute bottom-0 left-0 p-2  w-full h-[20%]">
                        {{-- <p class="text-white"> {{ optional($activeResponse)->email }}</p> --}}

                        <div>
                            <div class="grid grid-cols-8 gap-1 h-24">
                                @foreach ($individualResponses as $index => $res)
                                    @if (!empty($res->text) || !empty($res->audio) || !empty($res->video))
                                        <div wire:click="showResponse({{ $index }})"
                                            class=" text-sm border rounded-md bg-white p-1 col-span-1 w-full h-full flex justify-center items-center">
                                            @if (!empty($res->video))
                                                <i class='bx bxs-videos text-3xl'></i>
                                            @elseif (!empty($res->audio))
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
                                                </svg>
                                            @elseif (!empty($res->text))
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-8">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                                </svg>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>
