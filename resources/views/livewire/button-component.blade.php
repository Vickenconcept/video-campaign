<div>
    {{-- Success is as dangerous as failure. --}}
    <div>
        <label for="" class="text-sm font-semibold">Call to action text:</label>
        <div>
            <input type="text" class="form-control" placeholder="eg. Get started.." wire:model="button_component" wire:keydown.debounce.2000ms="saveButtonComponent()">
        </div>
    </div>
</div>
