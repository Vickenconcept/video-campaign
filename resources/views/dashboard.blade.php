<x-app-layout>
    @section('title')
        {{ 'Dashboard' }}
    @endsection

    <div class="max-w-7xl mx-auto pt-6 sm:px-6 lg:px-8 px-3 pb-32 overflow-y-auto h-screen">
        <!-- Welcome Header -->
        {{-- <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-gray-600">Here's what's happening with your campaigns today.</p>
        </div> --}}

        @php
            $user = auth()->user();

            $foldersCount = $user->folders()->count();
            $campaignsCount = \App\Models\Campaign::whereIn('folder_id', $user->folders->pluck('id'))->count();

            // Email Campaign Stats
            $emailCampaignsCount = \App\Models\EmailCampaign::where('user_id', $user->id)
                ->where('type', 'video_email')
                ->count();
            $emailCampaignsSent = \App\Models\EmailCampaign::where('user_id', $user->id)
                ->where('type', 'video_email')
                ->where('status', 'sent')
                ->count();
            $emailCampaignsScheduled = \App\Models\EmailCampaign::where('user_id', $user->id)
                ->where('type', 'video_email')
                ->where('status', 'scheduled')
                ->count();
            $emailCampaignsDraft = \App\Models\EmailCampaign::where('user_id', $user->id)
                ->where('type', 'video_email')
                ->where('status', 'draft')
                ->count();
            $totalEmailRecipients = \App\Models\EmailRecipient::whereHas('campaign', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count();

            // Video Page Stats
            $videoPagesCount = \App\Models\EmailCampaign::where('user_id', $user->id)
                ->where('type', 'video_page')
                ->count();
            $videoPagesSent = \App\Models\EmailCampaign::where('user_id', $user->id)
                ->where('type', 'video_page')
                ->where('status', 'sent')
                ->count();
            $videoPagesScheduled = \App\Models\EmailCampaign::where('user_id', $user->id)
                ->where('type', 'video_page')
                ->where('status', 'scheduled')
                ->count();
            $videoPagesDraft = \App\Models\EmailCampaign::where('user_id', $user->id)
                ->where('type', 'video_page')
                ->where('status', 'draft')
                ->count();
            $totalEmailRecipients = \App\Models\EmailRecipient::whereHas('campaign', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->count();

            // Recent responses
            $firstFiveResponses = \App\Models\Response::whereIn(
                'user_token',
                $user->folders
                    ->flatMap(
                        fn($f) => $f->campaigns->flatMap(
                            fn($c) => $c->steps->flatMap(fn($s) => $s->responses->pluck('user_token')),
                        ),
                    )
                    ->unique(),
            )
                ->latest()
                ->take(5)
                ->get();
        @endphp

        <main class="flex gap-4 flex-col lg:flex-row">
            <section class="w-full lg:w-[70%]">
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8  ">
                    <!-- Video Campaigns Card -->
                    <div
                        class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-3xl p-6 text-white shadow-2xl shadow-indigo-500/25 transform hover:scale-[1.02] transition-all duration-300 animate-slide-in-delayed">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-purple-200 mb-2">Video Funnel</p>
                                <div class="text-3xl font-bold text-white flex items-center gap-2">
                                    {{ $campaignsCount }}

                                    <p
                                        class="text-xs bg-white/30 text-white font-semibold px-3 py-1 rounded-full flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-4 text-white">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                                        </svg>

                                        <span><strong>0</strong>%</span>
                                    </p>
                                </div>
                                <p class="text-sm text-purple-200 mt-2">{{ $foldersCount }} folders</p>
                            </div>
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 text-indigo-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                                </svg>

                            </div>
                        </div>
                    </div>

                    <!-- Email Campaigns Card -->
                    <div
                        class="bg-white rounded-3xl shadow-md shadow-gray-200 px-6 py-10 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-blue-600 mb-2">Video Email</p>
                                <p class="text-3xl font-bold text-blue-600">{{ $emailCampaignsCount }}</p>
                                <div class="flex gap-2 mt-2">
                                    <span
                                        class="text-xs bg-blue-100 text-blue-700 font-semibold px-2 py-1 rounded-full">{{ $emailCampaignsSent }}
                                        sent</span>
                                    <span
                                        class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full">{{ $emailCampaignsScheduled }}
                                        scheduled</span>
                                </div>
                            </div>
                            <div
                                class="w-12 h-12 bg-gradient-to-r from-blue-400 to-cyan-700 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>

                            </div>
                        </div>
                    </div>
                    <!-- Video page Card -->
                    <div
                        class="bg-white rounded-3xl shadow-md shadow-gray-200 px-6 py-10 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-orange-600 mb-2">Video Page</p>
                                <p class="text-3xl font-bold text-orange-600">{{ $videoPagesCount }}</p>
                                <div class="flex gap-2 mt-2">
                                    <span
                                        class="text-xs bg-orange-100 text-orange-700 font-semibold px-2 py-1 rounded-full">{{ $videoPagesSent }}
                                        sent</span>
                                    <span
                                        class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full">{{ $emailCampaignsScheduled }}
                                        scheduled</span>
                                </div>
                            </div>
                            <div
                                class="w-12 h-12 bg-gradient-to-r from-orange-500 to-orange-700 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>

                            </div>
                        </div>
                    </div>



                    <!-- Email Recipients Card -->
                    {{-- <div
                        class="bg-white rounded-3xl shadow-sm border border-gray-200 px-6 py-10 hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-1">Email Recipients</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $totalEmailRecipients }}</p>
                                <p class="text-sm text-gray-500 mt-1">Total subscribers</p>
                            </div>
                            <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <i class='bx bx-user text-2xl text-indigo-600'></i>
                            </div>
                        </div>
                    </div> --}}
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-xl shadow-sm shadow-gray-200">
                    <div class="px-6 py-4 ">
                        <div class="flex items-center gap-2">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-pink-500 to-rose-600 rounded-2xl flex items-center justify-center shadow-lg shadow-pink-500/25">
                                <svg data-v-77bca2a3="" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-activity-icon w-6 h-6 text-white">
                                    <path
                                        d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2">
                                    </path>
                                </svg>
                            </div>
                            <h2 class="text-lg font-semibold text-gray-900">
                                Recent Responses
                            </h2>
                        </div>
                    </div>

                    @if ($firstFiveResponses->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full ">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-sm text-gray-800 font-medium uppercase tracking-wider">
                                            User
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-sm text-gray-800 font-medium uppercase tracking-wider">
                                            Email
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-sm text-gray-800 font-medium uppercase tracking-wider">
                                            Time
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-sm text-gray-800 font-medium uppercase tracking-wider">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white ">
                                    @foreach ($firstFiveResponses as $response)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="size-6 text-gray-600">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                                        </svg>

                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $response->name ?? 'Anonymous' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $response->email ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $response->created_at->diffForHumans() }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-green-100 to-green-200 text-green-800">
                                                    Completed
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="px-6 py-4 flex justify-end">
                            <a href="{{ route('response.index') }}"
                                class="text-pink-600 hover:text-pink-800 text-sm font-medium flex items-center gap-1">
                                View all responses
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 text-pink-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
                                </svg>


                            </a>
                        </div>
                    @else
                        <div class="px-6 py-12 text-center">
                            <div
                                class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>

                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No responses yet</h3>
                            <p class="text-gray-500 mb-6">Start creating campaigns to see responses here.</p>
                            <a href="{{ route('folder.index') }}"
                                class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-2 rounded-lg font-medium hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                                Create Your First Video Funnel
                            </a>
                        </div>
                    @endif
                </div>

            </section>

            <!-- Quick Actions -->
            <div class="w-full lg:w-[30%] rounded-2xl bg-white shadow-sm shadow-gray-200">
                <div class="p-5 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-cyan-500/25">
                            <svg data-v-77bca2a3="" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-zap-icon w-5 h-5 text-white">
                                <path
                                    d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="font-bold text-gray-900 text-md">Quick Actions</h2>
                            <p class="text-sm text-gray-500">Create a new campaign</p>
                        </div>

                    </div>
                </div>
                <div class="text-xs text-gray-500 p-4">
                    <div class="bg-gradient-to-r from-cyan-400 via-blue-500 to-indigo-600 p-6 text-white rounded-t-2xl shadow-lg shadow-cyan-500/25">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-cyan-500/25">
                                <svg data-v-77bca2a3="" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-zap-icon w-5 h-5 text-white">
                                    <path
                                        d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="font-bold text-white text-md">Quick Actions</h2>
                                <p class="text-sm text-blue-100">Get things done faster</p>
                            </div>
                            <div>
                                <p
                                class="text-xs bg-white/30 text-white font-semibold px-3 py-1 rounded-full flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                                  </svg>
                                  

                                <span><strong>4</strong></span>
                            </p>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 mt-4">
                        <a href="{{ route('folder.index') }}"
                            class="relative bg-gradient-to-b from-green-600 to-green-700 text-white px-4 py-8 rounded-2xl hover:from-green-700 hover:to-green-800 transition-all duration-200 flex items-center justify-center flex-col">
                            <div class="mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                                  </svg>
                                  
                            </div>
                            <p class="font-semibold text-md">Video Funnel</p>
                            <p class="text-green-100 text-sm text-center">Create interactive</p>

                            <div class="bg-white/30 absolute top-0 right-0 w-12 h-12 rounded-bl-full flex items-center justify-center"> </div>
                            <div class="bg-white/30 absolute bottom-0 left-0 w-12 h-12 rounded-tr-full flex items-center justify-center"> </div>
                        </a>

                        <a href="{{ route('email.campaigns.create') }}"
                            class="relative bg-gradient-to-b from-blue-600 to-blue-700 text-white px-4 py-8 rounded-2xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 flex items-center justify-center flex-col">
                            <div class="mb-4">
                                <i class='bx bx-plus text-2xl text-white'></i>
                            </div>
                            <p class="font-semibold text-md">Create Video Email</p>
                            <p class="text-blue-100 text-sm text-center">New campaign</p>

                            <div class="bg-white/30 absolute top-0 right-0 w-12 h-12 rounded-bl-full flex items-center justify-center"> </div>
                            <div class="bg-white/30 absolute bottom-0 left-0 w-12 h-12 rounded-tr-full flex items-center justify-center"> </div>
                        </a>

                        <a href="{{ route('video-page.campaigns.create') }}"
                            class="relative bg-gradient-to-b from-purple-600 to-purple-700 text-white px-4 py-8 rounded-2xl hover:from-purple-700 hover:to-purple-800 transition-all duration-200 flex items-center justify-center flex-col">
                            <div class="mb-4">
                                <i class='bx bx-video-plus text-2xl text-white'></i>
                            </div>
                            <p class="font-semibold text-md">Create Video page</p>
                            <p class="text-purple-100 text-sm text-center">New campaigns</p>

                            <div class="bg-white/30 absolute top-0 right-0 w-12 h-12 rounded-bl-full flex items-center justify-center"> </div>
                            <div class="bg-white/30 absolute bottom-0 left-0 w-12 h-12 rounded-tr-full flex items-center justify-center"> </div>
                        </a>


                        <a href="{{ route('response.index') }}"
                            class="relative bg-gradient-to-b from-orange-600 to-orange-700 text-white px-4 py-8 rounded-2xl hover:from-orange-700 hover:to-orange-800 transition-all duration-200 flex items-center justify-center flex-col">
                            <div class="mb-4">
                                <i class='bx bx-chart text-2xl text-white'></i>
                            </div>
                            <p class="font-semibold text-md">View Responses</p>
                            <p class="text-orange-100 text-sm text-center">Analytics</p>

                            <div class="bg-white/30 absolute top-0 right-0 w-12 h-12 rounded-bl-full flex items-center justify-center"> </div>
                            <div class="bg-white/30 absolute bottom-0 left-0 w-12 h-12 rounded-tr-full flex items-center justify-center"> </div>
                        </a>
                    </div>
                </div>
            </div>
        </main>


    </div>
</x-app-layout>
