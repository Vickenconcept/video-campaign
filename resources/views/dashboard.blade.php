<x-app-layout>
    @section('title')
        {{ 'Dashboard' }}
    @endsection

    <div class="max-w-7xl mx-auto pt-6 sm:px-6 lg:px-8 px-3 pb-32 overflow-y-auto h-screen">
        <!-- Welcome Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-gray-600">Here's what's happening with your campaigns today.</p>
        </div>

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

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Video Campaigns Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Video Funnel</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $campaignsCount }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $foldersCount }} folders</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-video text-2xl text-blue-600'></i>
                    </div>
                </div>
            </div>

            <!-- Email Campaigns Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Video Email</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $emailCampaignsCount }}</p>
                        <div class="flex gap-2 mt-1">
                            <span
                                class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">{{ $emailCampaignsSent }}
                                sent</span>
                            <span
                                class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full">{{ $emailCampaignsScheduled }}
                                scheduled</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-envelope text-2xl text-purple-600'></i>
                    </div>
                </div>
            </div>
            <!-- Video page Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Video Page</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $videoPagesCount }}</p>
                        <div class="flex gap-2 mt-1">
                            <span
                                class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">{{ $videoPagesSent }}
                                sent</span>
                            <span
                                class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full">{{ $emailCampaignsScheduled }}
                                scheduled</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-envelope text-2xl text-orange-600'></i>
                    </div>
                </div>
            </div>



            <!-- Email Recipients Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
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
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <a href="{{ route('folder.index') }}"
                class="bg-gradient-to-r from-green-600 to-green-700 text-white p-4 rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 flex items-center gap-3">
                <i class='bx bx-video text-xl'></i>
                <div>
                    <p class="font-semibold">Video Funnel</p>
                    <p class="text-green-100 text-sm">Create interactive</p>
                </div>
            </a>
            <a href="{{ route('email.campaigns.create') }}"
                class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-4 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 flex items-center gap-3">
                <i class='bx bx-plus text-xl'></i>
                <div>
                    <p class="font-semibold">Create Video Email</p>
                    <p class="text-blue-100 text-sm">New campaign</p>
                </div>
            </a>

            <a href="{{ route('video-page.campaigns.create') }}"
                class="bg-gradient-to-r from-purple-600 to-purple-700 text-white p-4 rounded-xl hover:from-purple-700 hover:to-purple-800 transition-all duration-200 flex items-center gap-3">
                <i class='bx bx-video-plus text-xl'></i>
                <div>
                    <p class="font-semibold">Create Video page</p>
                    <p class="text-purple-100 text-sm">New campaigns</p>
                </div>
            </a>


            <a href="{{ route('response.index') }}"
                class="bg-gradient-to-r from-orange-600 to-orange-700 text-white p-4 rounded-xl hover:from-orange-700 hover:to-orange-800 transition-all duration-200 flex items-center gap-3">
                <i class='bx bx-chart text-xl'></i>
                <div>
                    <p class="font-semibold">View Responses</p>
                    <p class="text-orange-100 text-sm">Analytics</p>
                </div>
            </a>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <i class='bx bx-time text-xl text-gray-600'></i>
                    Recent Responses
                </h2>
            </div>

            @if ($firstFiveResponses->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Time
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($firstFiveResponses as $response)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                                                <i class='bx bx-user text-gray-600'></i>
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
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-200">
                    <a href="{{ route('response.index') }}"
                        class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center gap-1">
                        View all responses
                        <i class='bx bx-chevron-right'></i>
                    </a>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class='bx bx-message-dots text-2xl text-gray-400'></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No responses yet</h3>
                    <p class="text-gray-500 mb-6">Start creating campaigns to see responses here.</p>
                    <a href="{{ route('folder.index') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">
                        Create Your First Video Funnel
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
