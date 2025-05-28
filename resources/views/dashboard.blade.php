<x-app-layout>
    @section('title')
        {{ 'Dashboard' }}
    @endsection
    <div class="max-w-5xl mx-auto py-5 px-3 xl:px-0">
        <h4 class="text-2xl font-semibold mb-8">Hey, Welcome Back</h4>
        @php
            $user = auth()->user();
            $responsesCount = \App\Models\Response::whereIn(
                'user_token',
                $user->folders
                    ->flatMap(
                        fn($f) => $f->campaigns->flatMap(
                            fn($c) => $c->steps->flatMap(fn($s) => $s->responses->pluck('user_token')),
                        ),
                    )
                    ->unique(),
            )->count();
            $foldersCount = $user->folders()->count();
            $campaignsCount = \App\Models\Campaign::whereIn('folder_id', $user->folders->pluck('id'))->count();
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
        <div id="stats" class="grid gird-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-black/70 to-white/5 p-6 rounded-lg">
                <div class="flex flex-row space-x-4 items-center">
                    <div id="stats-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-8 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                        </svg>

                    </div>
                    <div>
                        <p class="text-white text-sm font-medium uppercase leading-4">Responses</p>
                        <p class="text-white font-bold text-2xl inline-flex items-center space-x-2">
                            <span>{{ $responsesCount }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-indigo-500 p-6 rounded-lg">
                <div class="flex flex-row space-x-4 items-center">
                    <div id="stats-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-8 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                        </svg>

                    </div>
                    <div>
                        <p class="text-white text-sm font-medium uppercase leading-4">Folders</p>
                        <p class="text-white font-bold text-2xl inline-flex items-center space-x-2">
                            <span>{{ $foldersCount }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-black/70 p-6 rounded-lg">
                <div class="flex flex-row space-x-4 items-center">
                    <div id="stats-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-8 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                        </svg>

                    </div>
                    <div>
                        <p class="text-white text-sm font-medium uppercase leading-4">Campaigns</p>
                        <p class="text-white font-bold text-2xl inline-flex items-center space-x-2">
                            <span>{{ $campaignsCount }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div id="last-users">
            <h1 class="font-bold py-4 uppercase">Latest Responses</h1>
            <div class="overflow-x-scroll">
                <table class="w-full whitespace-nowrap">
                    <thead class="bg-black/70 text-white">
                        <tr>
                            <th class="text-left py-3 px-2 rounded-l-lg">Name</th>
                            <th class="text-left py-3 px-2">Email</th>
                            <th class="text-left py-3 px-2">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($firstFiveResponses as $response)
                            <tr class="border-b border-gray-700">
                                <td class="py-3 px-2 font-bold flex space-x-2 items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>

                                    <span>{{ $response->name ?? '-' }}</span>
                                </td>
                                <td class="py-3 px-2">{{ $response->email ?? '-' }}</td>
                                <td class="py-3 px-2">{{ $response->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
