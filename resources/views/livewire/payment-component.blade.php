<div class="space-y-5">
    {{-- Care about people's approval and you will be their prisoner. --}}
    <h2 class="text-lg font-semibold mb-4">PayPal Integration</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="saveCredentials">
        <div class="mb-4">
            <label for="clientId" class="block text-sm font-medium text-gray-700">Client ID</label>
            <input type="text" id="clientId" wire:model="clientId" class="form-control" placeholder="Enter client ID"
                required autocomplete="off" @if (!empty($paypal_keys['client_id']) && !empty($paypal_keys['secret'])) readonly @endif>
            @error('clientId')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="secret" class="block text-sm font-medium text-gray-700">Secret</label>
            <input type="text" id="secret" wire:model="secret" class="form-control" placeholder="Enter secret key"
                required autocomplete="off" @if (!empty($paypal_keys['client_id']) && !empty($paypal_keys['secret'])) readonly @endif>
            @error('secret')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end">
            @if (!empty($paypal_keys['client_id']) && !empty($paypal_keys['secret']))
                <button type="button" Wire:click="clearKeys()"
                    class="w-full max-w-40 cursor-pointer bg-red-600 text-white py-2 rounded-md hover:bg-red-700">Clear
                    Credentials</button>
            @else
                <button type="submit"
                    class="w-full max-w-40 cursor-pointer bg-green-600 text-white py-2 rounded-md hover:bg-green-700">Save
                    Credentials</button>
            @endif
        </div>
    </form>

    @if (!empty($paypal_keys['client_id']) && !empty($paypal_keys['secret']))
        <div class="w-full py-1  items-center flex justify-between">
            <h5 class="font-semibold">Currency</h5>
            @php
                $currencies = [
                    'USD' => 'US Dollar',
                    'EUR' => 'Euro',
                    'GBP' => 'British Pound',
                    'AUD' => 'Australian Dollar',
                    'CAD' => 'Canadian Dollar',
                    'JPY' => 'Japanese Yen',
                    'NZD' => 'New Zealand Dollar',
                    'CHF' => 'Swiss Franc',
                    'SEK' => 'Swedish Krona',
                    'NOK' => 'Norwegian Krone',
                    'MXN' => 'Mexican Peso',
                    'SGD' => 'Singapore Dollar',
                    'HKD' => 'Hong Kong Dollar',
                ];
            @endphp


            <select wire:model.change="currency" wire:change="update_currency('currency')"
                class="bg-gray-300 text-gray-800 rounded-md p-2 font-medium">
                <option value="">Currency</option>
                @foreach ($currencies as $code => $name)
                    <option class="bg-white text-gray-700  font-medium" value="{{ $code }}">
                        {{ $name }}</option>
                @endforeach
            </select>

        </div>
    @endif
    @if (!empty($paypal_keys['client_id']) && !empty($paypal_keys['secret']))
        <div class="w-full py-1  items-center flex justify-between">
            <h5 class="font-semibold">Amount</h5>
           

            <input wire:model="amount" wire:keydown.debounce.2000ms="update_amount('amount')"
                class="bg-gray-300 w-16 border-2 border-slate-300 text-gray-800 rounded-md p-2 font-medium" placeholder="20.0" />

        </div>
    @endif

</div>
