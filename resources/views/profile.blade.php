<x-app-layout>
    @section('title')
        {{ 'profile' }}
    @endsection
    <div class="space-y-8 h-full max-w-3xl mx-auto py-8">
        <div class="py-5 border-b px-3 flex space-x-5 items-center">
            <div>
                <h3 class="font-bold text-2xl text-gray-900">My Profile</h3>
            </div>
            <span class="text-xs text-gray-500">Manage your account</span>
        </div>

        <div class="px-3">
            @if(session('success'))
                <div class="mb-4 p-3 rounded-lg bg-green-50 border border-green-200 text-green-700 flex items-center gap-2">
                    <i class='bx bx-check-circle text-xl'></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-700 flex items-center gap-2">
                    <i class='bx bx-error-circle text-xl'></i> {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('changeName') }}" method="POST" class="space-y-4" id="profile-form">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input id="name" name="name" type="text" autocomplete="off"
                            class="block w-full rounded-lg border border-gray-300 shadow-sm px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition placeholder-gray-400 @error('name') border-red-400 focus:ring-red-200 @enderror"
                            value="{{ old('name', auth()->user()->name) }}">
                        @error('name')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input id="email" name="email" type="email" autocomplete="off"
                            class="block w-full rounded-lg border border-gray-200 bg-gray-100 px-4 py-2 text-gray-500 cursor-not-allowed"
                            value="{{ auth()->user()->email }}" readonly>
                    </div>
                </div>
                <div class="mt-5">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 shadow-md px-5 py-2 font-semibold text-white rounded-lg flex items-center gap-2 transition-colors w-full md:w-auto justify-center">
                        <i class='bx bx-save'></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <div class="space-y-5 px-3">
            <hr>
            <h1 class="font-semibold text-lg text-gray-800">Change Password</h1>
            <p class="text-xs text-gray-500 mb-2">Changing your password will log you out of every device.</p>
            <form action="{{ route('changePassword') }}" method="POST" class="space-y-4" id="password-form">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-5">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                        <input id="password" name="password" type="password" autocomplete="off"
                            class="block w-full rounded-lg border border-gray-300 shadow-sm px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition placeholder-gray-400 @error('password') border-red-400 focus:ring-red-200 @enderror">
                        @error('password')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                        <input id="new_password" name="new_password" type="password" autocomplete="off"
                            class="block w-full rounded-lg border border-gray-300 shadow-sm px-4 py-2 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition placeholder-gray-400 @error('new_password') border-red-400 focus:ring-red-200 @enderror">
                        @error('new_password')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mt-5">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 shadow-md px-5 py-2 font-semibold text-white rounded-lg flex items-center gap-2 transition-colors w-full md:w-auto justify-center">
                        <i class='bx bx-save'></i>
                        Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        // Optional: Add real-time validation feedback (client-side)
        document.addEventListener('DOMContentLoaded', function () {
            const nameInput = document.getElementById('name');
            nameInput.addEventListener('input', function () {
                if (nameInput.value.trim().length < 2) {
                    nameInput.classList.add('border-red-400', 'focus:ring-red-200');
                } else {
                    nameInput.classList.remove('border-red-400', 'focus:ring-red-200');
                }
            });
        });
    </script>
</x-app-layout>
