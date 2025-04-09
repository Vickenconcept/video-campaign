<div class="space-y-4">
    {{-- Success is as dangerous as failure. --}}
    <div>
        <label for="" class="text-sm font-semibold">Add your appointment scheduling link:</label>
        <div>
            <input type="text" class="form-control" placeholder="eg. https://calendly.com/videoaskteam/30min" wire:model="calender_link" wire:keydown.debounce.2000ms="saveCalenderLink()">
        </div>
    </div>
    {{-- <div>
        <select class="form-control" id=""></select>
    </div> --}}
</div>