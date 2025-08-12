<div class="space-y-4">
    <div>
        <label class="block text-sm font-bold mb-1">Start Time</label>
        <input type="datetime-local" wire:model.defer="start_time" class="form-control" />
    </div>
    <div>
        <label class="block text-sm font-bold mb-1">End Time</label>
        <input type="datetime-local" wire:model.defer="end_time" class="form-control" />
    </div>
    <div>
        <label class="block text-sm font-bold mb-1">CTA URL</label>
        <input type="url" wire:model.defer="cta_url" class="form-control" placeholder="https://..." />
    </div>
    <div>
        <label class="block text-sm font-bold mb-1">CTA TEXT</label>
        <input type="text" wire:model.defer="cta_text" class="form-control" placeholder="Contact us" />
    </div>
    <div>
        <label class="block text-sm font-bold mb-1">Additional Text</label>
        <textarea wire:model.defer="additional_text" class="form-control" rows="2"></textarea>
    </div>
    <div>
        <button class="btn cursor-pointer" wire:click="saveTimer" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="saveTimer">Save Timer Settings</span>
            <span wire:loading wire:target="saveTimer">Saving...</span>
        </button>
    </div>
</div> 