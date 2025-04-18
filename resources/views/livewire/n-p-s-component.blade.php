<div>
    <div x-data="{ NPS: 0 }" @mouseleave="NPS = 0"
        class="bg-white rounded-lg shadow  flex items-center justify-center space-x-10 py-3 px-3">
        <div class="space-y-3">

            <div class="flex space-x-2">
                <label for="nps-1" 
                    class="text-gray-700 text-sm bg-gray-300 cursor-pointer font-semibold rounded py-1 px-2"
                    :class="{ 'text-yellow-400 bg-gray-900': NPS >= 1 }" @mouseenter=" NPS = 1">
                    <span>1</span>
                    <input type="radio" class="hidden" wire:model="NPSScore" value="1" id="nps-1">
                </label>
                <label for="nps-2" 
                    class="text-gray-700 text-sm bg-gray-300 cursor-pointer font-semibold rounded py-1 px-2"
                    :class="{ 'text-yellow-400 bg-gray-900': NPS >= 2 }" @mouseenter=" NPS = 2">
                    <span>2</span>
                    <input type="radio" class="hidden" wire:model="NPSScore" value="2" id="nps-2">
                </label>
                <label for="nps-3" 
                    class="text-gray-700 text-sm bg-gray-300 cursor-pointer font-semibold rounded py-1 px-2"
                    :class="{ 'text-yellow-400 bg-gray-900': NPS >= 3 }" @mouseenter=" NPS = 3">
                    <span>3</span>
                    <input type="radio" class="hidden" wire:model="NPSScore" value="3" id="nps-3">
                </label>
                <label for="nps-4" 
                    class="text-gray-700 text-sm bg-gray-300 cursor-pointer font-semibold rounded py-1 px-2"
                    :class="{ 'text-yellow-400 bg-gray-900': NPS >= 4 }" @mouseenter=" NPS = 4">
                    <span>4</span>
                    <input type="radio" class="hidden" wire:model="NPSScore" value="4" id="nps-4">
                </label>
                <label for="nps-5" 
                    class="text-gray-700 text-sm bg-gray-300 cursor-pointer font-semibold rounded py-1 px-2"
                    :class="{ 'text-yellow-400 bg-gray-900': NPS >= 5 }" @mouseenter=" NPS = 5">
                    <span>5</span>
                    <input type="radio" class="hidden" wire:model="NPSScore" value="5" id="nps-5">
                </label>
                <label for="nps-6" 
                    class="text-gray-700 text-sm bg-gray-300 cursor-pointer font-semibold rounded py-1 px-2"
                    :class="{ 'text-yellow-400 bg-gray-900': NPS >= 6 }" @mouseenter=" NPS = 6">
                    <span>6</span>
                    <input type="radio" class="hidden" wire:model="NPSScore" value="6" id="nps-6">
                </label>
                <label for="nps-7" 
                    class="text-gray-700 text-sm bg-gray-300 cursor-pointer font-semibold rounded py-1 px-2"
                    :class="{ 'text-yellow-400 bg-gray-900': NPS >= 7 }" @mouseenter=" NPS = 7">
                    <span>7</span>
                    <input type="radio" class="hidden" wire:model="NPSScore" value="7" id="nps-7">
                </label>
                <label for="nps-8" 
                    class="text-gray-700 text-sm bg-gray-300 cursor-pointer font-semibold rounded py-1 px-2"
                    :class="{ 'text-yellow-400 bg-gray-900': NPS >= 8 }" @mouseenter=" NPS = 8">
                    <span>8</span>
                    <input type="radio" class="hidden" wire:model="NPSScore" value="8" id="nps-8">
                </label>
                <label for="nps-9" 
                    class="text-gray-700 text-sm bg-gray-300 cursor-pointer font-semibold rounded py-1 px-2"
                    :class="{ 'text-yellow-400 bg-gray-900': NPS >= 9 }" @mouseenter=" NPS = 9">
                    <span>9</span>
                    <input type="radio" class="hidden" wire:model="NPSScore" value="9" id="nps-9">
                </label>
                <label for="nps-10" 
                    class="text-gray-700 text-sm bg-gray-300 cursor-pointer font-semibold rounded py-1 px-2"
                    :class="{ 'text-yellow-400 bg-gray-900': NPS >= 10 }" @mouseenter=" NPS = 10">
                    <span>10</span>
                    <input type="radio" class="hidden" wire:model="NPSScore" value="10" id="nps-10">
                </label>
            </div>


            <div class="flex justify-between">
                <span class="text-xs text-gray-500 ">very unlikely</span>
                <span class="text-xs text-gray-500 ">very likely</span>
            </div>
        </div>
    </div>
</div>
