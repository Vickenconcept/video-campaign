<div class="overflow-auto h-screen pt-5 pb-32" x-data="multiSelect()" x-init="$watch('selectedEmails', value => $wire.selectedEmails = value)">
    @section('title')
        {{ 'ESP Connect' }}
    @endsection
    <div class="container mx-auto max-w-screen-lg px-4 py-8">
        <!-- Enhanced Header Section -->
        <div class="bg-gradient-to-r from-blue-50 to-white rounded-xl p-6 shadow-2xl shadow-blue-500/20 border border-blue-200 mb-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-3">Email Service Provider Connections</h2>
                <p class="text-gray-600">Connect and manage your email service provider integrations</p>
            </div>
        </div>

        <!-- Enhanced Main Container -->
        <div class="bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden">
            <x-session-msg />

            <!-- Enhanced Tabs Navigation -->
            <div class="flex flex-wrap border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                <button @click="activeTab = 'mailchimp'"
                    :class="{ 'border-blue-600 text-blue-700 bg-blue-50 rounded-t-lg font-semibold': activeTab === 'mailchimp', 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'mailchimp' }"
                    class="py-4 px-6 inline-flex items-center border-b-2 cursor-pointer border-transparent font-medium text-sm transition-all duration-200">
                    <i class='bx bx-envelope mr-2'></i>
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
                    :class="{ 'border-blue-600 text-blue-700 bg-blue-50 rounded-t-lg font-semibold': activeTab === 'getresponse', 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'getresponse' }"
                    class="py-4 px-6 inline-flex items-center border-b-2 cursor-pointer border-transparent font-medium text-sm transition-all duration-200">
                    <i class='bx bx-send mr-2'></i>
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
                    :class="{ 'border-blue-600 text-blue-700 bg-blue-50 rounded-t-lg font-semibold': activeTab === 'convertkit', 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'convertkit' }"
                    class="py-4 px-6 inline-flex items-center border-b-2 cursor-pointer border-transparent font-medium text-sm transition-all duration-200">
                    <i class='bx bx-conversation mr-2'></i>
                    ConvertKit
                    @if ($connectionStatus['convertkit'])
                        <svg class="w-5 h-5 ml-2 text-green-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    @endif
                </button>
                <button @click="activeTab = 'activecampaign'"
                    :class="{ 'border-blue-600 text-blue-700 bg-blue-50 rounded-t-lg font-semibold': activeTab === 'activecampaign', 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'activecampaign' }"
                    class="py-4 px-6 inline-flex items-center border-b-2 cursor-pointer border-transparent font-medium text-sm transition-all duration-200">
                    <i class='bx bx-target-lock mr-2'></i>
                    Activecampaign
                    @if ($connectionStatus['activecampaign'])
                        <svg class="w-5 h-5 ml-2 text-green-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    @endif
                </button>
                {{-- <button @click="activeTab = 'hubspot'"
                    :class="{ 'border-blue-600 text-blue-700 bg-blue-50 rounded-t-lg font-semibold': activeTab === 'hubspot', 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-100': activeTab !== 'hubspot' }"
                    class="py-4 px-6 inline-flex items-center border-b-2 cursor-pointer border-transparent font-medium text-sm transition-all duration-200">
                    <i class='bx bx-hub mr-2'></i>
                    Hubspot
                    @if ($connectionStatus['hubspot'])
                        <svg class="w-5 h-5 ml-2 text-green-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    @endif
                </button> --}}
            </div>

            <!-- Enhanced Tab Panes -->
            <div class="p-6">
                <!-- Mailchimp Connection -->
                <div x-show="activeTab === 'mailchimp'" style="display: none;" class="max-w-xl">
                    <div class="bg-gradient-to-r from-gray-50 to-white rounded-lg p-6 border border-gray-200 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class='bx bx-envelope text-blue-600 mr-2'></i>
                            Mailchimp Connection
                        </h3>
                        <form wire:submit.prevent="connectMailchimp">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-semibold mb-2" for="mailchimpApiKey">
                                    Mailchimp API Key
                                </label>
                                <input wire:model="mailchimpApiKey" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" id="mailchimpApiKey" type="text"
                                    placeholder="Enter your Mailchimp API key">
                            </div>
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-semibold mb-2" for="mailchimpServerPrefix">
                                    Server Prefix
                                </label>
                                <input wire:model="mailchimpServerPrefix" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" id="mailchimpServerPrefix"
                                    type="text" placeholder="e.g. us21">
                            </div>
                            @if (empty($mailchimpLists))
                                <button type="submit" wire:loading.attr="disabled" wire:target="connectMailchimp"
                                    class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <span wire:loading.remove wire:target="connectMailchimp">Re-connect</span>
                                    <span wire:loading wire:target="connectMailchimp">Connecting...</span>
                                </button>
                            @endif
                            @if (!empty($mailchimpLists))
                                <button type="submit" wire:loading.attr="disabled" wire:target="connectMailchimp"
                                    class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-green-500">
                                    <span wire:loading.remove wire:target="connectMailchimp">Connected!</span>
                                    <span wire:loading wire:target="connectMailchimp">Connecting...</span>
                                </button>
                            @endif
                        </form>
                    </div>

                    @if (!empty($mailchimpLists))
                        <div class="bg-gradient-to-r from-green-50 to-white rounded-lg p-6 border border-green-200">
                            <h3 class="text-lg font-semibold mb-4 text-green-800 flex items-center">
                                <i class='bx bx-check-circle text-green-600 mr-2'></i>
                                Your Mailchimp Lists
                            </h3>
                            <ul class="divide-y divide-green-200">
                                @foreach ($mailchimpLists ?? [] as $list)
                                    <li class="py-3 text-green-700">{{ $list['name'] }} <span class="text-green-500 text-sm">({{ $list['id'] }})</span></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- GetResponse Connection -->
                <div x-show="activeTab === 'getresponse'" style="display: none;" class="max-w-xl">
                    <div class="bg-gradient-to-r from-gray-50 to-white rounded-lg p-6 border border-gray-200 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class='bx bx-send text-blue-600 mr-2'></i>
                            GetResponse Connection
                        </h3>
                        <form wire:submit.prevent="connectGetResponse">
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-semibold mb-2" for="getResponseApiKey">
                                    GetResponse API Key
                                </label>
                                <input wire:model="getResponseApiKey" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" id="getResponseApiKey"
                                    type="text" placeholder="Enter your GetResponse API key">
                                <p class="text-xs text-gray-500 mt-2">
                                    Find this in Getresponse tools > Integrations and API > API or
                                    <a href="https://app.getresponse.com/api" class="hover:underline text-blue-500"
                                        target="_blank">Get here</a>
                                </p>
                            </div>

                            @if (empty($getResponseLists))
                                <button type="submit" wire:loading.attr="disabled" wire:target="connectGetResponse"
                                    class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <span wire:loading.remove wire:target="connectGetResponse">Re-connect</span>
                                    <span wire:loading wire:target="connectGetResponse">Connecting...</span>
                                </button>
                            @endif
                            @if (!empty($getResponseLists))
                                <button type="submit" wire:loading.attr="disabled" wire:target="connectGetResponse"
                                    class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-green-500">
                                    <span wire:loading.remove wire:target="connectGetResponse">Connected!</span>
                                    <span wire:loading wire:target="connectGetResponse">Connecting...</span>
                                </button>
                            @endif
                        </form>
                    </div>

                    @if (!empty($getResponseLists))
                        <div class="bg-gradient-to-r from-green-50 to-white rounded-lg p-6 border border-green-200">
                            <h3 class="text-lg font-semibold mb-4 text-green-800 flex items-center">
                                <i class='bx bx-check-circle text-green-600 mr-2'></i>
                                Your GetResponse Audiences
                            </h3>
                            <ul class="divide-y divide-green-200">
                                @foreach ($getResponseLists as $list)
                                    <li class="py-3 text-green-700">{{ $list['name'] }} <span class="text-green-500 text-sm">({{ $list['audienceId'] }})</span></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- ConvertKit Connection -->
                <div x-show="activeTab === 'convertkit'" style="display: none;" class="max-w-xl">
                    <div class="bg-gradient-to-r from-gray-50 to-white rounded-lg p-6 border border-gray-200 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class='bx bx-conversation text-blue-600 mr-2'></i>
                            ConvertKit Connection
                        </h3>
                        <form wire:submit.prevent="connectConvertKit">
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-semibold mb-2" for="convertKitApiKey">
                                    ConvertKit API Key
                                </label>
                                <input wire:model="convertKitApiKey" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" id="convertKitApiKey"
                                    type="text" placeholder="Enter your ConvertKit API key">
                            </div>

                            @if (empty($convertKitLists))
                                <button type="submit" wire:loading.attr="disabled" wire:target="connectConvertKit"
                                    class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <span wire:loading.remove wire:target="connectConvertKit">Re-connect</span>
                                    <span wire:loading wire:target="connectConvertKit">Connecting...</span>
                                </button>
                            @endif
                            @if (!empty($convertKitLists))
                                <button type="submit" wire:loading.attr="disabled" wire:target="connectConvertKit"
                                    class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-green-500">
                                    <span wire:loading.remove wire:target="connectConvertKit">Connected!</span>
                                    <span wire:loading wire:target="connectConvertKit">Connecting...</span>
                                </button>
                            @endif
                        </form>
                    </div>

                    @if (!empty($convertKitLists))
                        <div class="bg-gradient-to-r from-green-50 to-white rounded-lg p-6 border border-green-200">
                            <h3 class="text-lg font-semibold mb-4 text-green-800 flex items-center">
                                <i class='bx bx-check-circle text-green-600 mr-2'></i>
                                Your ConvertKit Forms
                            </h3>
                            <ul class="divide-y divide-green-200">
                                @foreach ($convertKitLists as $form)
                                    <li class="py-3 text-green-700">{{ $form['name'] }} <span class="text-green-500 text-sm">({{ $form['id'] }})</span></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- ActiveCampaign Connection -->
                <div x-show="activeTab === 'activecampaign'" style="display: none;" class="max-w-xl">
                    <div class="bg-gradient-to-r from-gray-50 to-white rounded-lg p-6 border border-gray-200 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class='bx bx-target-lock text-blue-600 mr-2'></i>
                            ActiveCampaign Connection
                        </h3>
                        <form wire:submit.prevent="connectActiveCampaign">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-semibold mb-2" for="activeCampaignApiKey">
                                    ActiveCampaign API Key
                                </label>
                                <input wire:model="activeCampaignApiKey" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" id="activeCampaignApiKey"
                                    type="text" placeholder="Enter your ActiveCampaign API key">
                            </div>

                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-semibold mb-2" for="activeCampaignAccount">
                                    Account Name
                                </label>
                                <div class="flex items-center">
                                    <input wire:model="activeCampaignAccount"
                                        class="bg-white border border-gray-300 text-gray-800 rounded-l-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 placeholder-gray-500 transition-colors duration-200"
                                        id="activeCampaignAccount" type="text" placeholder="your-account">
                                    <span
                                        class="bg-gray-100 text-gray-700 font-semibold border border-l-0 border-gray-300 p-3 rounded-r-lg text-gray-700 whitespace-nowrap">.api-us1.com</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Found in your API URL (e.g., "your-account" in
                                    https://your-account.api-us1.com)</p>
                            </div>

                            @if ($activecampaignAuth)
                                <button type="submit" wire:loading.attr="disabled" wire:target="connectActiveCampaign"
                                    class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-green-500">
                                    <span wire:loading.remove wire:target="connectActiveCampaign">Connected!
                                    </span>
                                    <span wire:loading wire:target="connectActiveCampaign">Connecting...</span>
                                </button>
                            @endif
                            @if (!$activecampaignAuth)
                                <button type="submit" wire:loading.attr="disabled" wire:target="connectActiveCampaign"
                                    class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <span wire:loading.remove wire:target="connectActiveCampaign">Connect
                                        ActiveCampaign</span>
                                    <span wire:loading wire:target="connectActiveCampaign">Connecting...</span>
                                </button>
                            @endif

                        </form>
                    </div>
                </div>

                <!-- HubSpot Connection -->
                <div x-show="activeTab === 'hubspot'" style="display: none;" class="max-w-xl">
                    <div class="bg-gradient-to-r from-gray-50 to-white rounded-lg p-6 border border-gray-200 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class='bx bx-hub text-blue-600 mr-2'></i>
                            HubSpot Connection
                        </h3>
                        <form wire:submit.prevent="connectHubSpot">
                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-semibold mb-2" for="hubspotApiKey">
                                    HubSpot API Key
                                </label>
                                <input wire:model="hubspotApiKey" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200" id="hubspotApiKey" type="text"
                                    placeholder="Enter your HubSpot API key">
                                <p class="text-xs text-gray-500 mt-2">Find this in HubSpot Settings > Integrations > API
                                    Key</p>
                            </div>

                            @if ($hubspotAuth)
                                <button type="submit" wire:loading.attr="disabled" wire:target="connectHubSpot"
                                    class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-green-500">
                                    <span wire:loading.remove wire:target="connectHubSpot">Connected!
                                    </span>
                                    <span wire:loading wire:target="connectHubSpot">Connecting...</span>
                                </button>
                            @endif
                            @if (!$hubspotAuth)
                                <button type="submit" wire:loading.attr="disabled" wire:target="connectHubSpot"
                                    class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <span wire:loading.remove wire:target="connectHubSpot">Connect
                                        Hubspot</span>
                                    <span wire:loading wire:target="connectHubSpot">Connecting...</span>
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <!-- Enhanced Migration Section -->
            <div class="mt-8 pt-8 border-t border-gray-200 bg-gradient-to-r from-gray-50 to-white p-6">
                <h3 class="text-xl font-bold mb-6 text-gray-900 flex items-center">
                    <i class='bx bx-transfer text-green-600 mr-2'></i>
                    Migrate Subscribers
                </h3>
                <form wire:submit.prevent="migrateSubscriber">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-2" for="targetEsp">
                                Target ESP
                            </label>
                            <select wire:model.live="targetEsp"
                                class="relative w-full bg-white border border-gray-300 rounded-lg shadow-sm pl-3 pr-10 py-3 text-left cursor-default focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
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
                                @if ($connectionStatus['activecampaign'])
                                    <option value="activecampaign">ActiveCampaign</option>
                                @endif
                                {{-- @if ($connectionStatus['hubspot'])
                                    <option value="hubspot">Hubspot</option>
                                @endif --}}
                            </select>
                        </div>
                        <div x-show="activeTab != 'activecampaign' && activeTab != 'hubspot'">
                            <label class="block text-gray-700 text-sm font-semibold mb-2" for="targetList">
                                Target List
                            </label>
                            <select wire:model="targetList"
                                class="relative w-full bg-white border border-gray-300 rounded-lg shadow-sm pl-3 pr-10 py-3 text-left cursor-default focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
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

                        <div class="max-w-2xl mb-6" x-data="multiSelect()">
                            <div class="relative">
                                <label for="multi-select" class="block text-gray-700 text-sm font-semibold mb-2">Select
                                    Emails:</label>
                                <div class="mt-1 relative">
                                    <button type="button" @click="open = !open"
                                        class="relative w-full bg-white border border-gray-300 rounded-lg shadow-sm pl-3 pr-10 py-3 text-left cursor-default focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
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
                                        class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-lg py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                                        style="display: none;">
                                        <div @click="toggleSelectAll"
                                            class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-blue-600 hover:text-white font-semibold">
                                            <span class="block truncate">Select All Emails</span>
                                        </div>
                                        <template x-for="option in options" :key="option">
                                            <div @click="toggleOption(option)"
                                                class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-blue-600 hover:text-white">
                                                <span x-text="option"
                                                    :class="{ 'font-semibold': selectedEmails.includes(option) }"
                                                    class="block truncate"></span>
                                                <span x-show="selectedEmails.includes(option)"
                                                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-blue-600 hover:text-white">
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
                    </div>

                    <x-session-msg />
                    <button type="submit" wire:loading.attr="disabled" wire:target="migrateSubscriber"
                        class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer focus:outline-none focus:ring-2 focus:ring-green-500">
                        <span wire:loading.remove wire:target="migrateSubscriber"> Migrate Subscriber </span>
                        <span wire:loading wire:target="migrateSubscriber">Loading...</span>
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
                },
                toggleSelectAll() {
                    if (this.selectedEmails.length === this.options.length) {
                        this.selectedEmails = [];
                    } else {
                        this.selectedEmails = [...this.options];
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
