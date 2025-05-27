<x-app-layout>
    @section('title')
        {{ 'Tutorial' }}
    @endsection
    <section x-data="{ modalIsOpen: false, video: null, title: null }" class="pb-6">

        <h1 class="text-xl font-bold px-10 py-6">Tutorial Clips</h1>
        <div class="grid md:grid-cols-3 gap-5 px-10">
            <div @click="modalIsOpen = true; video = '{{ asset('video/dashboard.mp4') }}'; title = 'Dashboard Overview'; $nextTick(() => $refs.videoPlayer.load())"
                class="block max-w-[18rem] rounded-lg bg-white text-surface shadow-secondary-1 cursor-pointer hover:shadow-md transition-all duration-300 ease-in-out">
                <div class="relative overflow-hidden bg-cover bg-no-repeat">
                    <img class="rounded-t-lg" src="{{ asset('images/trustconvert.png') }}" alt="Nature Image" />
                </div>
                <div class="p-6">
                    <p class="text-base">
                        Dashboard Overview
                    </p>
                </div>
            </div>

            <div @click="modalIsOpen = true; video = '{{ asset('video/user-page.mp4') }}'; title = 'Users View'; $nextTick(() => $refs.videoPlayer.load())"
                class="block max-w-[18rem] rounded-lg bg-white text-surface shadow-secondary-1 cursor-pointer hover:shadow-md transition-all duration-300 ease-in-out">
                <div class="relative overflow-hidden bg-cover bg-no-repeat">
                    <img class="rounded-t-lg" src="{{ asset('images/trustconvert.png') }}" alt="Nature Image" />
                </div>
                <div class="p-6">
                    <p class="text-base">
                        Users View
                    </p>
                </div>
            </div>

            <div @click="modalIsOpen = true; video = '{{ asset('video/platform-page.mp4') }}'; title = 'Platform view'; $nextTick(() => $refs.videoPlayer.load())"
                class="block max-w-[18rem] rounded-lg bg-white text-surface shadow-secondary-1 cursor-pointer hover:shadow-md transition-all duration-300 ease-in-out">
                <div class="relative overflow-hidden bg-cover bg-no-repeat">
                    <img class="rounded-t-lg" src="{{ asset('images/trustconvert.png') }}" alt="Nature Image" />
                </div>
                <div class="p-6">
                    <p class="text-base">
                        Platform view
                    </p>
                </div>
            </div>

            <div @click="modalIsOpen = true; video = '{{ asset('video/campaign.mp4') }}'; title = 'Campaign'; $nextTick(() => $refs.videoPlayer.load())"
                class="block max-w-[18rem] rounded-lg bg-white text-surface shadow-secondary-1 cursor-pointer hover:shadow-md transition-all duration-300 ease-in-out">
                <div class="relative overflow-hidden bg-cover bg-no-repeat">
                    <img class="rounded-t-lg" src="{{ asset('images/trustconvert.png') }}" alt="Nature Image" />
                </div>
                <div class="p-6">
                    <p class="text-base">
                        Campaign
                    </p>
                </div>
            </div>

            <div @click="modalIsOpen = true; video = '{{ asset('video/review-page.mp4') }}'; title = 'Reviews'; $nextTick(() => $refs.videoPlayer.load())"
                class="block max-w-[18rem] rounded-lg bg-white text-surface shadow-secondary-1 cursor-pointer hover:shadow-md transition-all duration-300 ease-in-out">
                <div class="relative overflow-hidden bg-cover bg-no-repeat">
                    <img class="rounded-t-lg" src="{{ asset('images/trustconvert.png') }}" alt="Nature Image" />
                </div>
                <div class="p-6">
                    <p class="text-base">
                        Reviews
                    </p>
                </div>
            </div>

            <div @click="modalIsOpen = true; video = '{{ asset('video/social share.mp4') }}'; title = 'Social Share'; $nextTick(() => $refs.videoPlayer.load())"
                class="block max-w-[18rem] rounded-lg bg-white text-surface shadow-secondary-1 cursor-pointer hover:shadow-md transition-all duration-300 ease-in-out">
                <div class="relative overflow-hidden bg-cover bg-no-repeat">
                    <img class="rounded-t-lg" src="{{ asset('images/trustconvert.png') }}" alt="Nature Image" />
                </div>
                <div class="p-6">
                    <p class="text-base">
                        Social Share
                    </p>
                </div>
            </div>
            <div @click="modalIsOpen = true; video = '{{ asset('video/reseller.mp4') }}'; title = 'Resell View'; $nextTick(() => $refs.videoPlayer.load())"
                class="block max-w-[18rem] rounded-lg bg-white text-surface shadow-secondary-1 cursor-pointer hover:shadow-md transition-all duration-300 ease-in-out">
                <div class="relative overflow-hidden bg-cover bg-no-repeat">
                    <img class="rounded-t-lg" src="{{ asset('images/trustconvert.png') }}" alt="Nature Image" />
                </div>
                <div class="p-6">
                    <p class="text-base">
                        Resell View
                    </p>
                </div>
            </div>


        </div>


        {{-- modal --}}
        <div class="fixed items-center justify-center  flex top-0 left-0 mx-auto w-full h-full bg-gray-600/50  z-50 transition duration-1000 ease-in-out"
            x-show="modalIsOpen" style="display: none;">
            <div @click.away="modalIsOpen = false; video = null; $nextTick(() => $refs.videoPlayer.load())"
                class="bg-white w-[90%] md:w-[60%] h-[25rem] shadow-inner  border rounded-2xl overflow-auto  py-6 px-8 transition-all relative duration-700">
                <div class=" h-full ">

                    <div x-text="title" class="font-bold text-xl flex items-center">
                    </div>
                    <ul class="h-[70%] w-full px-10 pt-5 space-y-2 pb-10">
                        <video controls class="w-full" x-ref="videoPlayer">
                            <source :src="video" type="video/mp4">
                        </video>
                    </ul>
                </div>
            </div>
        </div>

    </section>


</x-app-layout>
