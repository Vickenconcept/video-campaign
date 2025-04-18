<div class="overflow-auto h-full" x-data="multiSelect()" x-init="$watch('selectedEmails', value => $wire.selectedEmails = value)">
    {{-- <div class="overflow-auto h-full" x-data="{ activeTab: 'mailchimp' }"> --}}
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-6">Email Service Provider Connections</h2>

            <!-- Tabs Navigation -->
            <div class="flex border-b mb-6">
                <button @click="activeTab = 'mailchimp'"
                    :class="{ 'border-blue-500 text-blue-600': activeTab === 'mailchimp', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'mailchimp' }"
                    class="py-4 px-6 inline-flex items-center border-b-2 font-medium text-sm">
                    Mailchimp
                    @if ($connectionStatus['mailchimp'])
                        <svg class="w-5 h-5 ml-2 text-green-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    @endif
                </button>

                <button @click="activeTab = 'getresponse'"
                    :class="{ 'border-blue-500 text-blue-600': activeTab === 'getresponse', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'getresponse' }"
                    class="py-4 px-6 inline-flex items-center border-b-2 font-medium text-sm">
                    GetResponse
                    @if ($connectionStatus['getresponse'])
                        <svg class="w-5 h-5 ml-2 text-green-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    @endif
                </button>

                <button @click="activeTab = 'convertkit'"
                    :class="{ 'border-blue-500 text-blue-600': activeTab === 'convertkit', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'convertkit' }"
                    class="py-4 px-6 inline-flex items-center border-b-2 font-medium text-sm">
                    ConvertKit
                    @if ($connectionStatus['convertkit'])
                        <svg class="w-5 h-5 ml-2 text-green-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    @endif
                </button>
            </div>

            <!-- Tab Panes -->
            <div>
                <!-- Mailchimp Connection -->
                <div x-show="activeTab === 'mailchimp'" style="display: none;">
                    <form wire:submit.prevent="connectMailchimp">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="mailchimpApiKey">
                                Mailchimp API Key
                            </label>
                            <input wire:model="mailchimpApiKey"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="mailchimpApiKey" type="text" placeholder="Enter your Mailchimp API key">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="mailchimpServerPrefix">
                                Server Prefix
                            </label>
                            <input wire:model="mailchimpServerPrefix"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="mailchimpServerPrefix" type="text" placeholder="e.g. us21">
                        </div>
                        @if (empty($mailchimpLists))
                            <button type="submit" wire:loading.attr="disabled" wire:target="connectMailchimp"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer focus:outline-none focus:shadow-outline">
                                <span wire:loading.remove wire:target="connectMailchimp">Re-connect</span>
                                <span wire:loading wire:target="connectMailchimp">Connecting...</span>
                            </button>
                        @endif
                        @if (!empty($mailchimpLists))
                            <button type="submit" wire:loading.attr="disabled" wire:target="connectMailchimp"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer focus:outline-none focus:shadow-outline">
                                <span wire:loading.remove wire:target="connectMailchimp">Connected!</span>
                                <span wire:loading wire:target="connectMailchimp">Connecting...</span>
                            </button>
                        @endif
                    </form>

                    @if (!empty($mailchimpLists))
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold mb-2">Your Mailchimp Lists</h3>
                            <ul class="divide-y divide-gray-200">
                                @foreach ($mailchimpLists ?? [] as $list)
                                    <li class="py-2">{{ $list['name'] }} ({{ $list['id'] }})</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- GetResponse Connection -->
                <div x-show="activeTab === 'getresponse'" style="display: none;">
                    <form wire:submit.prevent="connectGetResponse">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="getResponseApiKey">
                                GetResponse API Key
                            </label>
                            <input wire:model="getResponseApiKey"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="getResponseApiKey" type="text" placeholder="Enter your GetResponse API key">
                        </div>


                        @if (empty($getResponseLists))
                            <button type="submit" wire:loading.attr="disabled" wire:target="connectGetResponse"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer focus:outline-none focus:shadow-outline">
                                <span wire:loading.remove wire:target="connectGetResponse">Re-connect</span>
                                <span wire:loading wire:target="connectGetResponse">Connecting...</span>
                            </button>
                        @endif
                        @if (!empty($getResponseLists))
                            <button type="submit" wire:loading.attr="disabled" wire:target="connectGetResponse"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer focus:outline-none focus:shadow-outline">
                                <span wire:loading.remove wire:target="connectGetResponse">Connected!</span>
                                <span wire:loading wire:target="connectGetResponse">Connecting...</span>
                            </button>
                        @endif
                    </form>

                    @if (!empty($getResponseLists))
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold mb-2">Your GetResponse Audiences</h3>
                            <ul class="divide-y divide-gray-200">
                                @foreach ($getResponseLists as $list)
                                    <li class="py-2">{{ $list['name'] }} ({{ $list['audienceId'] }})</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- ConvertKit Connection -->
                <div x-show="activeTab === 'convertkit'" style="display: none;">
                    <form wire:submit.prevent="connectConvertKit">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="convertKitApiKey">
                                ConvertKit API Key
                            </label>
                            <input wire:model="convertKitApiKey"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="convertKitApiKey" type="text" placeholder="Enter your ConvertKit API key">
                        </div>
                        
                        @if (empty($convertKitLists))
                            <button type="submit" wire:loading.attr="disabled" wire:target="connectConvertKit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer focus:outline-none focus:shadow-outline">
                                <span wire:loading.remove wire:target="connectConvertKit">Re-connect</span>
                                <span wire:loading wire:target="connectConvertKit">Connecting...</span>
                            </button>
                        @endif
                        @if (!empty($convertKitLists))
                            <button type="submit" wire:loading.attr="disabled" wire:target="connectConvertKit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded cursor-pointer focus:outline-none focus:shadow-outline">
                                <span wire:loading.remove wire:target="connectConvertKit">Connected!</span>
                                <span wire:loading wire:target="connectConvertKit">Connecting...</span>
                            </button>
                        @endif
                    </form>

                    @if (!empty($convertKitLists))
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold mb-2">Your ConvertKit Forms</h3>
                            <ul class="divide-y divide-gray-200">
                                @foreach ($convertKitLists as $form)
                                    <li class="py-2">{{ $form['name'] }} ({{ $form['id'] }})</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Migration Section -->
            <div class="mt-8 pt-8 border-t">
                <h3 class="text-xl font-bold mb-4">Migrate Subscribers</h3>
                <form wire:submit.prevent="migrateSubscriber">


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="targetEsp">
                                Target ESP
                            </label>
                            <select wire:model.live="targetEsp"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="targetEsp">
                                <option value="">Select target</option>
                                @if ($connectionStatus['mailchimp'])
                                    <option value="mailchimp">Mailchimp</option>
                                @endif
                                @if ($connectionStatus['getresponse'])
                                    <option value="getresponse">GetResponse</option>
                                @endif
                                @if ($connectionStatus['convertkit'])
                                    <option value="convertkit">ConvertKit</option>
                                @endif
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="targetList">
                                Target List
                            </label>
                            <select wire:model="targetList"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="targetList">
                                <option value="">Select list</option>
                                @if ($targetEsp === 'mailchimp')
                                    @foreach ($mailchimpLists as $list)
                                        <option value="{{ $list['id'] }}">{{ $list['name'] }}</option>
                                    @endforeach
                                @elseif($targetEsp === 'getresponse')
                                    @foreach ($getResponseLists as $list)
                                        <option value="{{ $list['audienceId'] }}">{{ $list['name'] }}</option>
                                    @endforeach
                                @elseif($targetEsp === 'convertkit')
                                    @foreach ($convertKitLists as $form)
                                        <option value="{{ $form['id'] }}">{{ $form['name'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="max-w-2xl  mb-5" x-data="multiSelect()">
                        <div class="relative">
                            <label for="multi-select" class="block text-sm font-medium text-gray-700 mb-1">Select
                                options:</label>
                            <div class="mt-1 relative">
                                <button type="button" @click="open = !open"
                                    class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <span class="block truncate"
                                        x-text="selectedEmails.length ? selectedEmails.join(', ') : 'Select options'"></span>
                                    <span
                                        class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </button>

                                <div x-show="open" @click.away="open = false"
                                    class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                                    style="display: none;">
                                    <template x-for="option in options" :key="option">
                                        <div @click="toggleOption(option)"
                                            class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-indigo-600 hover:text-white">
                                            <span x-text="option"
                                                :class="{ 'font-semibold': selectedEmails.includes(option) }"
                                                class="block truncate"></span>
                                            <span x-show="selectedEmails.includes(option)"
                                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600 hover:text-white">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded cursor-pointer focus:outline-none focus:shadow-outline">
                        Migrate Subscriber
                    </button>
                </form>
            </div>
        </div>



    </div>



    <script>
        function multiSelect() {
            return {
                activeTab: 'mailchimp',
                open: false,
                options: @json($emails),
                selectedEmails: @entangle('selectedEmails'),
                toggleOption(option) {
                    if (this.selectedEmails.includes(option)) {
                        this.selectedEmails = this.selectedEmails.filter(item => item !== option);
                    } else {
                        this.selectedEmails.push(option);
                    }
                }
            }
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            Livewire.on('notify', (data) => {
                if (data.status == 'success') {
                    Toastify({
                        text: `${data.msg}`,
                        // gravity: "bottom",
                        position: "center",
                        duration: 3000,
                        backgroundColor: "linear-gradient(to right, #56ab2f, #a8e063)"
                    }).showToast();

                }
                if (data.status == 'error') {
                    Toastify({
                        text: `${data.msg}`,
                        // gravity: "bottom",
                        position: "center",
                        duration: 3000,
                        backgroundColor: "linear-gradient(to right, #FF5F6D, #FFC371)"
                    }).showToast();
                }
            });
        });
    </script>
</div>
